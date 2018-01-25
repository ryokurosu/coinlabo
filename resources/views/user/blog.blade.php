@extends('layouts.app')

@section('title','申請済みブログ一覧')

@section('fullLayout','true')


@section('meta')
<meta name="robots" content="nofollow,noindex">
@endsection


@section('content')
<div class="panel panel-default">
    <div class="panel-heading"><h1>@yield('title')</h1></div>

    <div class="panel-body">
        {{$blogs->links()}}
        @if (Session::has('message'))
        <div class="alert alert-success">{{ Session::get('message') }}</div>
        @endif
        <div class="form">
            <h2>新規ブログ申請フォーム</h2>
            <form class="form-horizontal" action="{{route('user.blog.new')}}" method="post">
                {{csrf_field()}}
                <div class="form-group">
                    <label class="col-md-4 control-label" for="url">ブログURL</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" id="url" name="url" placeholder="https://example.com" required>
                        <p>※トップページのURLでの申請をお願いします。</p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="url">ブログRSS</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" id="rss" name="rss" placeholder="https://example.com/rss" required>
                        <p>※RSSを入力しておくと、毎日自動で新着記事を投稿してくれます。</p>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-8 col-md-offset-4">
                        <button type="submit" class="btn btn-primary">
                            申請
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <div class="div-box">
            <a class="btn btn-success" href="{{route('user.blog.fetch')}}">RSS更新をリクエスト</a>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <td>ブログID</td>
                    <td>タイトル</td>
                    <td>URL</td>
                    <td>ステータス</td>
                </tr>
            </thead>
            <tbody>
                @foreach($blogs as $blog)
                <tr>
                    <td>{{$blog->id}}</td>
                    <td>{{$blog->title}}</td>
                    <td><a href="{{$blog->url}}" target="_blank">{{$blog->url}}</a></td>
                    <td>
                        @if($blog->active)
                        <button class="btn btn-primary">公開中</button>
                        @else
                        <button class="btn btn-default">非公開</button>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{$blogs->links()}}
    </div>
</div>
@endsection
