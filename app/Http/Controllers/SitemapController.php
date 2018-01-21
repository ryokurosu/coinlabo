<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;
use App\User;
use App\Topic;

class SitemapController extends Controller
{
    public function index(){
    return response()->view('sitemap',
        [
            'articles' => Article::active()->get(),
            'users' => User::active()->get(),
            'topics' => Topic::all()

        ]
    )->header('Content-Type', 'text/xml');
}
}
