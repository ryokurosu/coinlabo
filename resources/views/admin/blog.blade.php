@extends('layouts.app')

@section('title','[管理者]ブログ一覧')

@section('fullLayout','true')


@section('meta')
<meta name="robots" content="nofollow,noindex">
@endsection


@section('content')
<div class="panel panel-default">
    <div class="panel-heading"><h1>@yield('title')</h1></div>

    <div class="panel-body">
        {{$blogs->links()}}
        <div id="status-message" class="alert alert-success">{{ Session::get('message') }}</div>
        <table class="table">
            <thead>
                <tr>
                    <td>ブログID</td>
                    <td>ユーザー</td>
                    <td>タイトル</td>
                    <td>URL</td>
                    <td>RSS</td>
                    <td>ステータス</td>
                    <td>投稿日</td>
                </tr>
            </thead>
            <tbody>
                @foreach($blogs as $blog)
                <tr>
                    <td>{{$blog->id}}</td>
                    <td>{{$blog->user->name}}</td>
                    <td>{{$blog->title}}</td>
                    <td><a href="{{$blog->url}}">{{$blog->url}}</a></td>
                    <td><a href="{{$blog->rss}}">{{$blog->rss}}</a></td>
                    <td class="radio-label">
                        <input type="radio" class="status-btn status_{{$blog->id}}" name="status_{{$blog->id}}" id="on_{{$blog->id}}" value="1" onclick="window.confirm('このブログを公開中にしてよろしいですか？');" @if($blog->active) checked @endif>
                        <label for="on_{{$blog->id}}" class="switch-on">公開中</label>
                        <input type="radio" class="status-btn status_{{$blog->id}}" name="status_{{$blog->id}}" id="off_{{$blog->id}}" value="0" onclick="window.confirm('このブログを非公開にしてよろしいですか？');" @if(!$blog->active) checked @endif>
                        <label for="off_{{$blog->id}}" class="switch-off">非公開</label>
                    </td>
                    <td>{{$blog->updated_at->format('Y/m/d')}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{$blogs->links()}}
    </div>
</div>

<script>
    $(function(){
        $('.status-btn').on('change',function(){

            $id = $(this).attr('id');
            var tmp = $id.split('_');
            var blog_id = tmp[1];

          
            var status = $('input[name="status_' + blog_id +'"]:checked').val();
            $.ajax({
                type : "POST",
                　　　data: {
                    status : status
                　　　},
                　　　url : "{{url('/admin/blog')}}/" + blog_id,
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
                    toggleRadio('status_'+ blog_id);
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
