@extends('layouts.app')

@section('title','お探しのページが見つかりません')

@section('meta')
<meta name="robots" content="nofollow,noindex">
@endsection

@section('content')
<div class="panel panel-default">
	<div class="panel-heading"><h1>@yield('title')</h1></div>

	<div class="panel-body">
		<p>残念ながらお探しのページが見つかりません。</p>	
		<p>トップページに戻り引き続き{{config('app.name')}}をお楽しみください。</p>
		<center><a href="{{url('/')}}" class="btn btn-primary">戻る</a></center>	
	</div>
</div>
@endsection
