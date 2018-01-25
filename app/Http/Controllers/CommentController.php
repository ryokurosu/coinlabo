<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Goutte\Client;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Article;
use App\Blog;
use App\Comment;


class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function postComment($id,Request $request)
    {
      Comment::create([
        'user_id' => Auth::id(),
        'article_id' => $id,
        'text' => $request->text,
    ]);
      return back();
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
