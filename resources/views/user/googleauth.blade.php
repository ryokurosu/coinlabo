@extends('layouts.app')

@section('title','2段階認証設定')

@section('fullLayout','true')

@section('meta')
<meta name="robots" content="nofollow,noindex">
@endsection


@section('content')
<div class="panel panel-default">
	<div class="panel-heading"><h1>@yield('title')</h1></div>

	<div class="panel-body">
		<div class="div-box">
			<div class="col-md-4 col-xs-12">
				<center><img src="{{$qr}}" alt="@yield('title')"></center>
			</div>
			<div class="col-md-6 col-md-offset-1 col-xs-12">
				<ol>
					<li><a href="https://itunes.apple.com/us/app/google-authenticator/id388497605?mt=8">認証アプリ</a>をインストールします。</li>
					<li>新規追加で、「QRコードを読み取る」か、「アドレス」「シークレットキー」を入力します。<br>※シークレットキー：{{$key}}</li>
					<li>表示された「6桁の数字」を入力します。</li>
				</ol>
			</div>
		</div>
		<div class="div-box">
			<form action="{{url('/user/googleauth')}}" method="post">
				{{ csrf_field() }}
				<input type="hidden" name="key" value="{{$key}}">
				<div class="col-md-6 col-md-offset-2">
					<div class="form-group">
						<input class="form-control" name="secret" type="text" placeholder="secret key">
					</div>
				</div>
				<div class="col-md-2 col-md-offset-1">
					<div class="form-group">
						<button class="btn btn-primary" type="submit">設定</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
@endsection
