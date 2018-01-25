@extends('layouts.app')

@section('title')お問い合わせ@stop

@section('fullLayout','true')

@section('meta')
<meta name="robots" content="noindex,nofollow">
@endsection


@section('content')
<div class="page-title"><h1>@yield('title')</h1></div>
<div class="col-xs-12">
	<div class="panel panel-default">
		<div class="panel-body">
			<p>ご不明な点、要望などございましたら、以下のアドレスまでメールをお送り下さい。</p>
			<p><a href="mailto:contact@s-patriot.com">contact@s-patriot.com</a></p>
		</div>
	</div>
</div>
@endsection
