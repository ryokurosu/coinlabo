<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManagerStatic as Image;
use App\Article;
use App\Blog;
use App\User;
use App\Topic;

class AdminController extends UserController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
     $this->middleware(function ($request, $next) {
       if(Auth::user()->auth > 1){
         return $next($request);
       }else{
        return back();
      }
    });
     $this->middleware('2fa');
   }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function article()
    {
      return view('admin.article',[
        'articles' => Article::paginate(100),
      ]);
    }

    public function articleUpdate(Request $request,$id){
      $article =  $this->toggleModelActive(Article::findOrFail($id),$request->status);
      return $article->active;
    }


    public function blog()
    {
      return view('admin.blog',[
        'blogs' => Blog::paginate(50),
      ]);
    }

    public function blogUpdate(Request $request,$id)
    {
     $blog = $this->toggleModelActive(Blog::findOrFail($id),$request->status);
     return $blog->active;
   }

   public function topic()
   {
    return view('admin.topic',[
      'topics' => Topic::paginate(20),
    ]);
  }

  private function toggleModelActive($model,$requestState){
    if($requestState){
      $model->activate();
    }else{
      $model->inactivate();
    }
    return $model;
  }

  public function topicEdit($id)
  {
    return view('admin.topic.edit',[
      'topic' => Topic::findOrFail($id),
    ]);
  }

  public function topicPost(Request $request,$id){
    $topic = Topic::findOrFail($id)->fill($request->all())->save();
    return back();
  }

  public function topicCreate(Request $request){

    try{

      $image = $request->file('thumbnail');
      $extension = $image->getClientOriginalExtension();
      $imageName = $this->makeRandStr(8).'.'.$extension;
      $image->move('./images',$imageName);



      $formatImage = Image::make('./images/'.$imageName);
      $formatImage->resize(1200, null, function ($constraint) {
        $constraint->aspectRatio();
      });

      $formatImage->save('./images/'.$imageName);

      Topic::create([
        'title' => $request->title,
        'text' => $request->text,
        'url' => $request->url,
        'thumbnail' => $imageName,
      ]);

    }catch(Exception $e){
      \Session::flash('画像の保存に失敗しました。'."\n Error:".$e->getMessage());
    }
    return back();
  }

  public function user(){
    $users = User::paginate(40);
    return view('admin.user',[
      'users' => $users
    ]);
  }

  public function userInactivate($id){
    User::active()->findOrFail($id)->fill(['active' => 0])->save();
    return back();
  }

  public function userActivate($id){
   User::active()->findOrFail($id)->fill(['active' => 1])->save();
   return back();
 }

}
