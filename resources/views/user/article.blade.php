@extends('layouts.app')

@section('title','申請済み記事一覧')

@section('fullLayout','true')



@section('meta')
<meta name="robots" content="nofollow,noindex">
@endsection


@section('content')
<div class="panel panel-default">
    <div class="panel-heading"><h1>@yield('title')</h1></div>

    <div class="panel-body">
        {{$articles->links()}}
        @if (Session::has('message'))
        <div class="alert alert-success">{{ Session::get('message') }}</div>
        @endif
        <div class="form">
            <h2>新規記事申請フォーム</h2>
            <form class="form-horizontal" action="{{route('user.article.new')}}" method="post">
                {{csrf_field()}}
                <div class="form-group">
                    <label class="col-md-4 control-label" for="url">記事URL</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" id="url" name="url" placeholder="https://example.com" required>
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
            <a class="btn btn-success" href="{{route('user.article.fetch')}}">記事更新をリクエスト</a>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <td>記事ID</td>
                    <td>タイトル</td>
                    <td>URL</td>
                    <td>ステータス</td>
                    <td>投稿日</td>
                    <td>記事を見る</td>
                </tr>
            </thead>
            <tbody>
                @foreach($articles as $article)
                <tr>
                    <td>{{$article->id}}</td>
                    <td>{{$article->title}}</td>
                    <td><a href="{{$article->url}}">{{$article->url}}</a></td>
                    <td>
                        @if($article->active)
                        <button class="btn btn-primary">公開中</button>
                        @else
                        <button class="btn btn-secondary">非公開</button>
                        @endif
                    </td>
                    <td>{{$article->updated_at->format('Y/m/d')}}</td>
                    <td>
                        @if($article->active)
                        <a href="{{route('article.page',$article)}}">記事を見る</a>
                        @else

                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{$articles->links()}}
    </div>
</div>
@endsection
