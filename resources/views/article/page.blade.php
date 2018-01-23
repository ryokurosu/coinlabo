@extends('layouts.app')

@section('title',$article->title)
@section('image',$article->imagePath())

@section('content')
<div class="panel panel-default">
   <div class="panel-heading"><h1>@yield('title')</h1></div>

   <div class="panel-body">
    <div class="article-thumbnail">
        <img src="{{url('/images/'.$article->thumbnail)}}" alt="{{$article->title}}">
    </div>
    <div class="article-meta">
        <h2>{{$article->title}}</h2>
        <p>投稿者<a href="{{url('/user/'.$article->user->id)}}">{{$article->user->name}}</a></p>
        <p>投稿日時：{{$article->updated_at->format('Y/m/d H:i:s')}}</p>
        <p>評価数：{{$article->count}}</p>
    </div>
    <div class="article-url">
        <p>URL：<a href="{{$article->url}}">{{$article->url}}</a></p>
    </div>
</div>

<div class="panel-body">
    @if(!Auth::guest())
    <div class="comment-post-area">
        <form action="{{route('comment',$article')}}" method="post">
            {{ csrf_field() }}
            <div class="form-group">
                <textarea class="form-control" name="text" id="text" cols="30" rows="10" maxlength="140" placeholder="コメントを入力"></textarea>
            </div>
            <button type="submit" class="btn btn-primary" id="comment-btn">コメント投稿</button>
        </div>
    </form>
</div>
@endif
<h2 class="coment-heading">コメント</h2>
<div class="comment-area" id="c-area">
  @foreach($article->comments()->active()->get() as $comment)
  <div class="comment">
    <div class="comment-text">
        <p>{{$comment->text}}</p>
    </div>
    <div class="comment-user">
        <p class="user-info">Name：{{$comment->user->name}}</p>
        <span class="comment-meta">{{$comment->updated_at->format('Y/m/d h:i:s')}}</span>
    </div>
</div>
@endforeach
@if(count($article->comments()->active()->get()) == 0)
<p>まだコメントはついていません。</p>
@endif
<a id="open-btn">続きを見る</a>
</div>
</div>
</div>

<script>
    $(function(){
        $h = $('#c-area').height();
        if($h < 320){
            $('#open-btn').css('display','none');
        }else{
            $('#c-area').css('height','320px');
        }

        $('#open-btn').on('click',function(){
            $('#c-area').css('height','auto');
            $('#open-btn').css('display','none');
        });
    });
</script>
@endsection
