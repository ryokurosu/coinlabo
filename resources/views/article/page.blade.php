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
        <div class="sns">
          <a class="sns-icon" href="https://twitter.com/intent/tweet?text=@if(Request::url() != Request::root())@yield('description') via @endif{{ config('app.name', 'Laravel') }}&url={{url()->full()}}&hashtags={{ config('app.name', 'Laravel') }}" onClick="window.open(encodeURI(decodeURI(this.href)), 'tweetwindow', 'width=650, height=470, personalbar=0, toolbar=0, scrollbars=1, sizable=1'); return false;" rel="nofollow">
            <img src="{{url('/twitter.png')}}" width="24">
        </a>
        <a class="sns-icon" href="http://www.facebook.com/sharer.php?u={{url()->full()}}" target="_blank" rel="nofollow">
            <img src="{{url('/facebook.png')}}" width="24">
        </a>
        <a class="sns-icon" href="http://line.me/R/msg/text/?{{url()->full()}}" rel="nofollow">
            <img src="{{url('/line.png')}}" width="24">
        </a>
    </div>
    <p>投稿者<a href="{{url('/user/'.$article->user->id)}}">{{$article->user->name}}</a></p>
    <p>投稿日時：{{$article->updated_at->format('Y/m/d H:i:s')}}</p>
    <p>評価数：{{$article->count}}</p>
</div>
<div class="article-url">
    <p>URL：<a href="{{$article->url}}" target="_blank" rel="nofollow">{{$article->url}}</a></p>
</div>
<p class="article-{{$article->id}}-amount">{{number_format($article->amount,5)}}BTC</p>
@foreach(\App\Coin::all() as $coin)
<button type="button" class="btn btn-{{$coin->alias}} coin-tip-btn" value="{{$article->id}}" data-set="{{$coin->unit}}" data-target="article">
  TIP<img src="{{$coin->imagePath()}}" alt="{{$coin->name}}@yield('title')" width="22">
</button>
@endforeach
</div>

<div class="panel-body">
    @if(!Auth::guest())
    <div class="comment-post-area">
        <form action="{{route('comment',$article)}}" method="post">
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
  @foreach($article->comments()->get() as $comment)
  <div class="comment">
    <div class="comment-text">
        <p>{{$comment->text}}</p>
    </div>
    <div class="comment-user">
        <p class="user-info">Name：{{$comment->user->name}}</p>
        <span class="comment-meta">{{$comment->updated_at->format('Y/m/d h:i:s')}}</span>
    </div>
</div>
<hr>
@endforeach
@if(count($article->comments()->get()) == 0)
<p>まだコメントはついていません。</p>
@endif
<a id="open-btn">続きを見る</a>
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
    $(function(){
        $('.coin-tip-btn').on('click',function(){
          $elem = $(this);
          var target = $(this).attr('data-target');
          var id = $(this).val();
          var amount = 0.00001;
          var alias;
          switch(target){
            case 'article':
            alias = 'articledonate';
            break;

            case 'blog':
            alias = 'blogdonate';
            break;

            default:
            alias = 'articledonate';
            break;
        }
        $.ajax({
            type : "POST",
            data : {
              id : id,
              amount : amount
          },
          url : "{{url('/user')}}/" + alias,
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          success : function(data) {
            console.log(data.amount);
            if(data.status){
              var _val = data.amount;
              var val  = Math.floor(_val * 100000) / 100000;

              $('.' + target + '-' + id + '-amount').text(val+'BTC');
              $elem.prop('disabled',true);
          }
      },
      error : function(data) {
        　alert('エラーが発生しました。ページを更新してください。');
        
    　　}　
});
    })
    });
</script>
@endsection
