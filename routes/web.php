<?php
use App\Article;
use App\Blog;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

View::share('PopularArticles',Article::active()->orderBy('amount','desc')->get());
View::share('PopularBlogs',Blog::active()->orderBy('amount','desc')->get());

Route::get('/sitemap.xml','SitemapController@index');

/***************** Everyone ****************/
Route::get('/', function () {
	return view('welcome');
})->name('root');

Auth::routes();
Route::get('/register/verify/{token}', 'Auth\RegisterController@verify');

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/article','ArticleController@index')->name('article');
Route::get('/article/{id}','ArticleController@page')->name('article.page');
Route::get('/user/{id}','ArticleController@user')->where('id', '[0-9]+')->name('article.user');


Route::get('/topic','TopicController@index')->name('topic');
Route::get('/topic/{id}','TopicController@page')->name('topic.page');

/************** user ********************/

Route::post('/google2fa/authenticate','UserController@check2FA')->name('user.check2fa');

Route::get('/user/article','UserController@article')->name('user.article');
Route::post('/user/article/new','UserController@articleNew')->name('user.article.new');
Route::get('/user/article/fetch','UserController@articleFetch')->name('user.article.fetch');
Route::get('/user/profile','UserController@profile')->name('user.profile');
Route::post('/user/getaddress','UserController@getaddress')->name('user.getaddress');
Route::post('/user/articledonate','UserController@articleDonate')->name('user.articledonate');
Route::post('/user/blogdonate','UserController@blogDonate')->name('user.articledonate');

Route::get('/user/blog','UserController@blog')->name('user.blog');
Route::post('/user/blog/new','UserController@blogNew')->name('user.blog.new');
Route::get('/user/blog/fetch','UserController@blogFetch')->name('user.blog.fetch');

Route::post('/article/{id}/comment','CommentController@postComment')->name('comment');

Route::get('/user/googleauth','UserController@googleAuth')->name('user.googleauth');
Route::post('/user/googleauth','UserController@googleAuthReturn')->name('user.googleauth.return');

Route::get('/user/disableauth','UserController@disableAuth')->name('user.google.disable');

/************ Admin **************/


Route::get('/admin/article','AdminController@article')->name('admin.article');
Route::post('/admin/article/{id}','AdminController@articleUpdate')->name('admin.article.update');

Route::get('/admin/blog','AdminController@blog')->name('admin.blog');
Route::post('/admin/blog/{id}','AdminController@blogUpdate')->name('admin.blog.update');

Route::get('/admin/topic','AdminController@topic')->name('admin.topic');
Route::post('/admin/topic/new','AdminController@topicCreate')->name('admin.topic.new');

Route::get('/admin/topic/{id}','AdminController@topicEdit')->name('admin.topic.edit');
Route::post('/admin/topic/{id}','AdminController@topicPost');


Route::get('/admin/user','AdminController@user')->name('admin.user');
Route::get('/admin/user/{id}/{status}','AdminController@userUpdate')->where('status',array('activate','inactivate'))->name('admin.user.edit');


