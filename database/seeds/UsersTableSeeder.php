<?php


use Illuminate\Database\Seeder;
use App\User;
use App\Blog;
use App\Coin;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User;
        $user->name = 'ryokurosu';
        $user->email = 'knowrop1208@gmail.com';
        $user->password = '$2y$10$PlAR/ZaQQMFwzG2Iyd8pQuAdUNOU19cqQ5MSctnbJjp.urgLZTo56';
        $user->code = 'ryokurosu';
        $user->active = 1;
        $user->verified = 1;
        $user->status = 1;
        $user->auth = 2;
        $user->save();

        Coin::create([
            'name' => 'Bitcoin',
            'unit' => 'BTC',
            'alias' => 'bitcoin',
        ]);

        if(\Config::get('app.debug')){

            $blog = Blog::create([
                'user_id' => $user->id,
                'title' =>'SEOに役立つホットな話題をブログで配信：SEO HACKS公式ブログ',
                'active' => 1,
                'url' => 'https://www.seohacks.net/blog/',
                'rss' => 'https://www.seohacks.net/blog/feed/',
                'thumbnail' => 'OyklXJgJ.png',
            ]);



            $blog =Blog::create([
                'user_id' => $user->id,
                'title' =>'仮想通貨の教科書',
                'active' => 1,
                'url' => 'https://xn--u9j013golmz9dk9be21cst1au0f.biz/',
                'rss' => 'https://xn--u9j013golmz9dk9be21cst1au0f.biz/feed/',
                'thumbnail' => 'H2f6T2rd.png',
            ]);

            \Artisan::call('rss:fetch');
        }
        \Artisan::call('get:yen');

    }
}
