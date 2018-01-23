@extends('layouts.app')

@section('title','[管理者]記事一覧')

@section('fullLayout','true')

@section('meta')
<meta name="robots" content="nofollow,noindex">
@endsection


@section('content')
<div class="panel panel-default">
    <div class="panel-heading"><h1>@yield('title')</h1></div>

    <div class="panel-body">
        {{$articles->links()}}
        <div id="status-message" class="alert alert-success">{{ Session::get('message') }}</div>
        <table class="table">
            <thead>
                <tr>
                    <td>記事ID</td>
                    <td>ユーザー</td>
                    <td>タイトル</td>
                    <td>URL</td>
                    <td>ステータス</td>
                    <td>投稿日</td>
                </tr>
            </thead>
            <tbody>
                @foreach($articles as $article)
                <tr>
                    <td>{{$article->id}}</td>
                    <td>{{$article->user->name}}</td>
                    <td>{{$article->title}}</td>
                    <td><a href="{{$article->url}}">{{$article->url}}</a></td>
                    <td class="radio-label">
                        <input type="radio" class="status-btn status_{{$article->id}}" name="status_{{$article->id}}" id="on_{{$article->id}}" value="1" onclick="window.confirm('この記事を公開中にしてよろしいですか？');" @if($article->active) checked @endif>
                        <label for="on_{{$article->id}}" class="switch-on">公開中</label>
                        <input type="radio" class="status-btn status_{{$article->id}}" name="status_{{$article->id}}" id="off_{{$article->id}}" value="0" onclick="window.confirm('この記事を非公開にしてよろしいですか？');" @if(!$article->active) checked @endif>
                        <label for="off_{{$article->id}}" class="switch-off">非公開</label>
                    </td>
                    <td>{{$article->updated_at->format('Y/m/d')}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{$articles->links()}}
    </div>
</div>

<script>
    $(function(){
        $('.status-btn').on('change',function(){

            $id = $(this).attr('id');
            var tmp = $id.split('_');
            var article_id = tmp[1];

            var status = $('input[name="status_' + article_id +'"]:checked').val();
            $.ajax({
                type : "POST",
                　　　data: {
                    status : status
                　　　},
                　　　url : "{{url('/admin/article')}}/" + article_id,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                　　　success : function(data) {
                    if(data == 1){
                        $('#status-message').text('ブログを公開中にしました。');
                    }else{
                        $('#status-message').text('ブログを非公開にしました。');
                    }
                　　　},
                　　　error : function(data) {
                    　 $('#status-message').text('ブログの更新中にエラーが発生しました。');
                    toggleRadio('status_'+ article_id);
                　　}　
            });
        });

        function toggleRadio($radioClass){
            $checked = $('input[type="radio"].' + $radioClass + ':checked');
            $nonChecked = $('input[type="radio"].' + $radioClass).not(':checked');

            $checked.prop('checked',false);
            $nonChecked.prop('checked',true);
        }
    });

</script>
@endsection
