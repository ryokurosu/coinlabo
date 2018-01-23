<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Intervention\Image\ImageManagerStatic as Image;
use Goutte\Client;
use App\Blog;
use App\Article;
use Exception;

class FetchArticleFromRss extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rss:fetch {blog?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'get articles from rss feeder';

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
        if(is_null($this->argument('blog'))){
            $blogs = Blog::active()->get();
        }else{
          $blogs = Blog::active()->findOrFail($this->argument('blog'));
        }
        foreach ($blogs as $blog) {
            try {
                $user = $blog->user;
                $rss = $blog->rss;
                $client = new Client();
                $sitemap = $client->request('GET', $rss);
                $sitemap->filter('item')->each(function($node) use (&$user) {
                    echo "|";
                    $link = $node->filter('link');
                    $this->setArticle($link->text(),$user);
                });
            } catch (Exception $e) {
                echo $e->getMessage()."\n";
                continue;
            }
        }
    }

    public function setArticle($articleUrl,$user){
        try{
           $url = $articleUrl;
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


               $image->save(public_path('/images/'.$imageName));

           }catch(Exception $e){
// $imageUrlが取れない時ある
           }

           Article::create([
            'user_id' => $user->id,
            'url' => $url,
            'title' => $title,
            'thumbnail' => $imageName,
        ]);

       }catch(Exception $e){
        // continue;
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
