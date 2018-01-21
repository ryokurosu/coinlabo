@extends('layouts.app')

@section('title',$topic->title)

@section('content')
<div class="panel panel-default">
 <div class="panel-heading"><h1>@yield('title')</h1></div>

 <div class="panel-body">
    <div class="article-thumbnail">
        <img src="{{$topic->imagePath()}}" alt="{{$topic->title}}">
    </div>
    <div class="article-meta">
        <h2>{{$topic->title}}</h2>
        {!! $topic->text !!}
    </div>
    <div class="article-url">
        <p>URL：<a href="{{$topic->url}}" target="_blank">{{$topic->url}}</a></p>
    </div>
</div>
</div>
@endsection
