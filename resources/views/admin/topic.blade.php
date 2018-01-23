@extends('layouts.app')

@section('title','[管理者]ニュース一覧')

@section('fullLayout','true')

@section('meta')
<meta name="robots" content="nofollow,noindex">
@endsection


@section('content')
<div class="panel panel-default">
    <div class="panel-heading"><h1>@yield('title')</h1></div>

    <div class="panel-body">
        {{$topics->links()}}
        @if (Session::has('message'))
        <div class="alert alert-success">{{ Session::get('message') }}</div>
        @endif
        <div class="form">
            <h2>新規ニュース作成フォーム</h2>
            <form class="form-horizontal" action="{{route('admin.topic.new')}}" method="post" enctype='multipart/form-data'>
                {{csrf_field()}}
                <div class="form-group">
                    <label class="col-md-4 control-label" for="title">タイトル</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" id="title" name="title" placeholder="タイトル" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="text">説明文</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" id="text" name="text" placeholder="簡単な説明文" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="url">参考URL</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" id="url" name="url" placeholder="https://example.com" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="thumbnail">サムネイル画像</label>
                    <div class="col-md-6">
                        <input type="file" class="form-control" id="thumbnail" name="thumbnail" placeholder="簡単な説明文" required>
                    </div>
                </div>
                <div class="form-group">
                    <div class="preview col-xs-10 col-xs-offset-1">
                        <img id="preview-image">
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
        <table class="table">
            <thead>
                <tr>
                    <td>ニュースID</td>
                    <td>タイトル</td>
                    <td>サムネイル</td>
                    <td>投稿日</td>
                    <td>確認</td>
                    <td>編集</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    @foreach($topics as $topic)
                    <td>{{$topic->id}}</td>
                    <td>{{$topic->title}}</td>
                    <td><img src="{{$topic->imagePath()}}" alt="{{$topic->title}}" width="60"></td>
                    <td>{{$topic->updated_at->format('Y/m/d')}}</td>
                    <td><a href="{{route('topic.page',$topic)}}">ニュースを見る</a></td>
                    <td><a href="{{route('admin.topic.edit',$topic)}}">編集</a></td>
                    @endforeach
                </tr>
            </tbody>
        </table>
        {{$topics->links()}}
    </div>
</div>

<script>
    $(function(){
        $('form').on('change', 'input[type="file"]', function(e) {
            var file = e.target.files[0],
            reader = new FileReader(),
            $preview = $("#preview-image");
            t = this;

    // 画像ファイル以外の場合は何もしない
    if(file.type.indexOf("image") < 0){
        return false;
    }

    // ファイル読み込みが完了した際のイベント登録
    reader.onload = (function(file) {
        return function(e) {
        // .prevewの領域の中にロードした画像を表示するimageタグを追加
        $preview.attr('src',e.target.result)
    };
})(file);

reader.readAsDataURL(file);
});
    });
</script>
@endsection
