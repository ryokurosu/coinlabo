@extends('layouts.app')

@section('title',$user->name.'さんの投稿')


@section('content')
<div class="panel panel-default">
    <div class="panel-heading"><h1>@yield('title')</h1></div>

    <div class="panel-body">
        @foreach($articles as $article)
        @if($loop->first)
        <div class="col-md-12 col-xs-12">
            @else
            <div class="col-md-6 col-xs-6">
                @endif
                <a href="{{url('/article/'.$article->id)}}">
                    <div class="thumnail-area">
                        <img src="{{url('/images/'.$article->thumbnail)}}" alt="{{$article->title}}">
                    </div>
                    <div class="article-meta">
                        <h2>{{$article->title}}</h2>
                        <p class="small">{{$article->updated_at->format('Y/m/d H:i:s')}}</p>
                        <span class="badge badge-primary">{{$article->count}}</span>
                    </div>
                </a>
            </div>
            @endforeach
            {{$articles->links()}}
        </div>
    </div>
    @endsection
