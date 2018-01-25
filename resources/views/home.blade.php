@extends('layouts.app')

@section('fullLayout','true')


@section('content')
<div class="panel panel-default">
    <div class="panel-heading"><h1>@yield('title')</h1></div>

    <div class="panel-body">
        @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
        @endif
        <h2>{{config('app.name')}}へようこそ</h2>
        <p>名前：{{Auth::user()->name}}</p>
        <a class="btn btn-success" href="{{url('/')}}">{{config('app.name')}}へ戻る
        </a>
    </div>
</div>
@endsection
