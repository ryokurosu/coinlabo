<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;
use App\User;
use Odan\Encoding\Base32;

class ArticleController extends Controller
{
    public function __construct()
    {

    }

    public function index()
    {
        $articles = Article::active()->paginate(32);
        return view('article.index',[
            'articles' => $articles
        ]);
    }

    public function page($id){
        $article = Article::active()->findOrFail($id);
        return view('article.page',[
            'article' => $article
        ]);
    }

    public function user($id){
        $user = User::active()->findOrFail($id);
        $articles = $user->articles()->active()->paginate(20);
        return view('article.user',[
            'articles' => $articles,
            'user' => $user
        ]);
    }

}
