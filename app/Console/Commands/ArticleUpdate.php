<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Intervention\Image\ImageManagerStatic as Image;
use Goutte\Client;
use App\Article;
use Exception;

class ArticleUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:article {article?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'article update';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if(is_null($this->argument('article'))){
            $articles = Article::active()->findOrFail($article->id);
        }else{
            $articles = Article::active()->get();
        }
        foreach ($articles as $article) {
         $this->articleUpdate($article);
     }
     echo 'done';
     return true;
 }

 public function articleUpdate($article){
    try{

        $url = $article->url;
        $client = new Client();
        $crawler = $client->request('GET', $url);
        $title = $crawler->filter('title')->text();
        $imageUrl = '';
        $imageName = $article->thumbnail;
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

     $article->fill([
        'user_id' => $article->user_id,
        'title' => $title,
        'thumbnail' => $imageName,
    ])->save();

     return true;

 }catch(Exception $e){

    return false;
}
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
