@extends('layouts.app')

@section('title','ニュース一覧')


@section('content')
<div class="panel panel-default">
    <div class="panel-heading"><h1>@yield('title')</h1></div>

    <div class="panel-body">
        @foreach($topics as $topic)
        @if($loop->first)
        <div class="col-md-12 col-xs-12">
            @else
            <div class="col-md-6 col-xs-6">
                @endif
                <a href="{{url('/topic/'.$topic->id)}}">
                    <div class="thumnail-area">
                        <img src="{{url('/images/'.$topic->thumbnail)}}" alt="{{$topic->title}}">
                    </div>
                    <div class="topic-meta">
                        <h2>{{$topic->title}}</h2>
                        <p class="small">{{$topic->updated_at->format('Y/m/d H:i:s')}}</p>
                        <span class="badge badge-primary">{{$topic->count}}</span>
                    </div>
                </a>
            </div>
            @endforeach
            {{$topics->links()}}
        </div>
    </div>
    @endsection
