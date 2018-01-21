@extends('layouts.app')

@section('title','現在メンテナンス中です。')

@section('meta')
<meta name="robots" content="nofollow,noindex">
@endsection

@section('content')
<div class="panel panel-default">
	<div class="panel-heading"><h1>@yield('title')</h1></div>

	<div class="panel-body">
		<p>現在、サーバーのメンテナンス中です。</p>	
		<p>終了まで少々おまちください。今後とも{{config('app.name')}}をよろしくお願いします。</p>
	</div>
</div>
@endsection
