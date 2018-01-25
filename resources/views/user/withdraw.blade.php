@extends('layouts.app')

@section('title','出金')

@section('fullLayout','true')

@section('meta')
<meta name="robots" content="nofollow,noindex">
@endsection


@section('content')
<div class="panel panel-default">

    <div class="panel-heading"><h1>@yield('title')</h1></div>

    <div class="panel-body">
       @if (Session::has('message'))
       <div class="alert alert-success">{{ Session::get('message') }}</div>
       @endif
       <p>残高:{{$user->getbalance()}}BTC</p>

       <form action="{{route('user.withdraw.post')}}" method="post">
           {{ csrf_field() }}
           <div class="form-group">
            <label for="address" class="col-md-4 control-label">送信先アドレス</label>
            <div class="col-md-6">
                <input id="address" type="text" class="form-control" name="address" placeholder="送信先アドレス" required autofocus>
            </div>
        </div>

        <div class="form-group">
            <label for="amount" class="col-md-4 control-label">金額</label>

            <div class="col-md-6">
                <input id="amount" type="text" class="form-control" name="amount" placeholder="1.000BTC" required>
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-8 col-md-offset-4">
                <button type="submit" class="btn btn-primary">
                    送金
                </button>
            </div>
        </div>
    </form>
</div>
</div>
@endsection
