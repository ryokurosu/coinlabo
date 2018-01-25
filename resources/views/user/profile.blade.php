@extends('layouts.app')

@section('title','設定')

@section('fullLayout','true')

@section('meta')
<meta name="robots" content="nofollow,noindex">
@endsection


@section('content')
<div class="panel panel-default">
    <div class="panel-heading"><h1>@yield('title')</h1></div>

    <div class="panel-body">
        <h2 class="small">名前:{{$user->name}}</h2>   
        <h2 class="small">メールアドレス:{{$user->email}}</h2>
        <p>残高:{{$user->getbalance()}}BTC</p>

        <!-- Button trigger modal -->
        <button type="button" id="get-address-btn" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
            Bitcoinアドレスを見る
        </button>
        <div class="div-box">
            @if($user->google2fa)
            <a class="btn btn-success" disabled>2段階認証を設定する</a>
            <p>※2段階認証は<b>設定済み</b>です。</p>
            <a class="btn btn-danger" href="javascript:void(0);" onclick="var ok=confirm('本当に2段階認証を解除しますか？');if (ok) location.href='{{route('user.google.disable')}}'; return false;">2段階認証を解除する</a>
            @else
            <a href="{{route('user.googleauth')}}" class="btn btn-success">2段階認証を設定する</a>
            <p>※2段階認証が<b>未設定</b>です。</p>
            @endif
        </div>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">あなたのBitcoinアドレス</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
            <p id="coin-address"></p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
    </div>
</div>
</div>
</div>
</div>

<script>

    $(function(){
        $('#get-address-btn').on('click',function(){
            $('#coin-address').text('{{$user->getaddress()}}');
        });
    });
</script>
@endsection
