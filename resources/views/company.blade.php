@extends('layouts.app')

@section('title')会社概要@stop

@section('fullLayout','true')

@section('meta')
<meta name="robots" content="noindex,nofollow">
@endsection


@section('content')
<div class="page-title"><h1>@yield('title')</h1></div>
<div class="col-xs-12">
	<div class="panel panel-default">
		<div class="panel-body">
			<table class="table table-striped table-bordered">
				<tr>
					<th>商号</th>
					<th>株式会社Patriot</th>
				</tr>
				<td>本社所在地</td>
				<td>〒130-0013 東京都墨田区錦糸1-2-1
				アルカセントラル 14F　</td>
			</tr>
		</table>
	</div>
</div>
</div>
@endsection
