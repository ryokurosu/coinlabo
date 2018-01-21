@extends('layouts.app')

@section('title','2段階認証')

@section('fullLayout','true')

@section('meta')
<meta name="robots" content="nofollow,noindex">
@endsection


@section('content')


<div class="panel panel-default">
	<div class="panel-heading"><h1>@yield('title')</h1></div>

	<div class="panel-body">
		@if(Session::has('message'))
		<div class="alert alert-info">{{Session::get('message')}}</div>
		@endif
		<form action="{{route('user.check2fa')}}" class="form-horizontal" method="POST">
			{{csrf_field()}}
			<div class="col-md-6 col-md-offset-2">
				<div class="form-group">
					<input class="form-control" name="one_time_password" type="text">
				</div>
			</div>
			<div class="col-md-2 col-md-offset-1">
				<div class="form-group">
					<button class="btn btn-primary" type="submit">認証</button>
				</div>
			</div>
		</form>
	</div>
</div>


@endsection