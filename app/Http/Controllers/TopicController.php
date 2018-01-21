<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Topic;

class TopicController extends Controller
{
    public function __construct()
    {

    }

    public function index()
    {
       $topics = Topic::paginate(10);
       return view('topic.index',[
        'topics' => $topics
    ]);
   }

   public function page($id){
    $topic = Topic::findOrFail($id);
    return view('topic.page',[
        'topic' => $topic
    ]);
}
}
