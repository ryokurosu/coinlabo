<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Goutte\Client;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Auth;
use Config;
use App\User;
use App\Article;
use App\Blog;
use Exception;
use Artisan;
use PragmaRX\Google2FA\Google2FA;


class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

      $this->middleware('auth');
      $this->middleware('2fa');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function article()
    {
      $user = Auth::user();
      $articles = $user->articles()->orderBy('active','desc')->paginate(20);
      return view('user.article',[
        'user' => $user,
        'articles' => $articles
      ]);
    }

    public function withdraw(){
      return view('user.withdraw',[
        'user' => Auth::user(),
      ]);
    }

    public function withdrawPost(Request $request){
      $user = Auth::user();
      try{
        $result = $user->sendfrom($request->address,$request->amount);
        \Session::flash('message', "送金が完了しました。トランザクションID：".$result->get());   
      }catch(Exception $e){

        \Session::flash('message', "送金に失敗しました".$e->getMessage());   
     }
     return back();
   }

   public function articleNew(Request $request)
   {
    try{

     $url = $request->url;
       // 個々から作る。スクレイピングしてタイトルとサムネイルを取ってくる必要がある
     $client = new Client();
     $crawler = $client->request('GET', $url);
     $title = $crawler->filter('title')->text();
     $imageUrl = '';
     $imageName = 'noimage.jpg';
      // try{

     $crawler->filter('meta')->each(function($node) use (&$imageUrl){
      if($node->attr('property') =='og:image'){
       $imageUrl =  $node->attr('content');
       return false;
     }
   });


     $imageUrl = strtok($imageUrl, '?');
     $image = Image::make(file_get_contents($imageUrl));
     $temp = explode('.',$imageUrl);
     $extension = $temp[count($temp) - 1];

     $image->resize(1200, null, function ($constraint) {
      $constraint->aspectRatio();
    });

     $imageName = $this->makeRandStr(8).'.'.$extension;


     $image->save('./images/'.$imageName);
  //     }catch(Exception $e){
// $imageUrlが取れない時ある
    //   }

     Article::create([
      'user_id' => Auth::id(),
      'url' => $url,
      'title' => $title,
      'thumbnail' => $imageName,
    ]);
     \Session::flash('message', '記事を申請しました。');   

   }catch(Exception $e){

    \Session::flash('message', "記事の申請に失敗しました。\n".$e->getMessage()); 
  }
  return back();
}

public function blog()
{
  $user = Auth::user();
  $blogs = $user->blogs()->paginate(5);
  return view('user.blog',[
    'user' => $user,
    'blogs' => $blogs
  ]);
}

public function profile(){
  return view('user.profile',[
    'user' => Auth::user()
  ]);
}

public function getaddress(Request $request){
  return $this->_getaddress();
}


public function BlogNew(Request $request)
{
  try{

   $url = $request->url;
   $client = new Client();
   $crawler = $client->request('GET', $url);
   $title = $crawler->filter('title')->text();
   $imageUrl = '';
   $imageName = 'noimage.jpg';
   try{

     $crawler->filter('meta')->each(function($node) use (&$imageUrl){
      if($node->attr('property') =='og:image'){
       $imageUrl =  $node->attr('content');
       return false;
     }
   });


     $imageUrl = strtok($imageUrl, '?');
     $image = Image::make(file_get_contents($imageUrl));
     $temp = explode('.',$imageUrl);
     $extension = $temp[count($temp) - 1];

     $image->resize(1200, null, function ($constraint) {
      $constraint->aspectRatio();
    });

     $imageName = $this->makeRandStr(8).'.'.$extension;


     $image->save('./images/'.$imageName);

   }catch(Exception $e){
// $imageUrlが取れない時ある
   }

   Blog::create([
    'user_id' => Auth::id(),
    'url' => $url,
    'title' => $title,
    'rss' =>$request->rss,
    'thumbnail' => $imageName,
  ]);
   \Session::flash('message', 'ブログを申請しました。');  
 }catch(Exception $e){
   \Session::flash('message', "ブログの申請に失敗しました。\n".$e->getMessage()); 
 }
 return back();
}

public function blogFetch(){
  try{

    $blogs = Auth::user()->blogs()->active()->get();
    foreach ($blogs as $blog) {
     $exitCode = Artisan::call('rss:fetch', [
      'blog' => $blog
    ]);
   }
 }catch(Exception $e){
  echo $e->getMessage();
}
return back();
}

public function articleFetch(){
  $articles = Auth::user()->articles()->active()->get();
  foreach ($articles as $article) {
   $exitCode = Artisan::call('update:article', [
    'article' => $article
  ]);
 }
 return back();
}
public function check2FA(Request $request){
  $user = Auth::user();
  $valid = $user->verifyGoogle2FA($request->one_time_password);
  if($valid){
    return redirect()->route('home');
  }else{
    return back();
  }
}
public function googleAuth(){
  if(Auth::user()->checkGoogle2FA()){
    return back();
  }
  $google2fa = new Google2FA();
  $generateKey = $google2fa->generateSecretKey();
  $user = Auth::user();
  $google2fa_url = $google2fa->getQRCodeGoogleUrl(
    Config::get('app.name'),
    $user->email,
    $generateKey
  );
  return view('user.googleauth',[
    'user' => Auth::user(),
    'qr' => $google2fa_url,
    'key' => $generateKey
  ]);
}

public function disableAuth(){
  Auth::user()->disableGoogle2FA();
  return back();
} 

public function googleAuthReturn(Request $request){
  $google2fa = new Google2FA();
  $secret = $request->secret;
  $key = $request->key;
  $valid = $google2fa->verifyKey($key, $secret);
  if($valid){
    Auth::user()->setGoogle2FA($key);
    return redirect()->route('user.profile');
  }else{
    return back();
  }
}

/*
param id : target article id
param amount : send amount (default 0.00001)

return article amount amount
 */
public function articleDonate(Request $request){
  $article =Article::active()->findOrFail($request->id);
  return $this->donate($article,$request->amount);
}

/*
param id : target blog id
param amount : send amount (default 0.00001)

return article amount amount
 */
public function blogDonate(Request $request){
  $blog =Blog::active()->findOrFail($request->id);
  return $this->donate($blog,$request->amount);
}

private function donate($model,$amount){
  $result = Auth::user()->sendToAddress($model->user->id,$amount);
  if($result){
    $model->increment('amount',$amount);
  }

  $ret_data = [
    'status' => $result->get(),
    'amount' => $model->amount
  ];

  return $ret_data;
}
function makeRandStr($length) {
  $str = array_merge(range('a', 'z'), range('0', '9'), range('A', 'Z'));
  $r_str = null;
  for ($i = 0; $i < $length; $i++) {
    $r_str .= $str[rand(0, count($str) - 1)];
  }
  return $r_str;
}



}
