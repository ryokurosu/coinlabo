@extends('layouts.app')

@section('title','[管理者]ユーザー一覧')

@section('fullLayout','true')

@section('meta')
<meta name="robots" content="nofollow,noindex">
@endsection


@section('content')
<div class="panel panel-default">
    <div class="panel-heading"><h1>@yield('title')</h1></div>

    <div class="panel-body">
        {{$users->links()}}
        <div id="status-message">

        </div>
        <table class="table">
            <thead>
                <tr>
                    <td>ユーザーID</td>
                    <td>ユーザー名</td>
                    <td>権限</td>
                    <td>稼働状況</td>
                    <td>強制停止</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    @foreach($users as $user)
                    <td>{{$user->id}}</td>
                    <td>{{$user->name}}</td>
                    <td>
                        @if($user->auth == 2)
                        管理者
                        @else
                        一般
                        @endif
                    </td>
                    <td>
                        @if($user->active)
                        稼働中
                        @else
                        停止中
                        @endif
                    </td>
                    <td>
                      @if($user->active)
                      <a href="{{url('/admin/user/'.$user->id.'/inactivate')}}">強制停止する</a>
                      @else
                      <a href="{{url('/admin/user/'.$user->id.'/activate')}}">使用可能にする</a>
                      @endif
                  </td>
                  @endforeach
              </tr>
          </tbody>
      </table>
      {{$users->links()}}
  </div>
</div>

@endsection
