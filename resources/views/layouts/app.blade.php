
@if(Request::url() == url(''))
@section('title'){{config('app.name')}}@stop
@else
@section('title') | {{config('app.name')}}@append
@endif

@section('description')coinlabo(コインラボ)は、暗号通貨のニュース、最新情報を提供しているサイトやブログを紹介し、評価できるプラットフォームです。@append


<!DOCTYPE html>
<html lang="{{config('app.locale')}}">
<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# article: http://ogp.me/ns/article#">

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>@yield('title')</title>

  <!-- Styles -->
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">

  <!-- Analytics Tag -->
  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-110214894-10"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-110214894-10');
  </script>

  <!-- jquery -->
  <script
  src="https://code.jquery.com/jquery-3.2.1.min.js"
  integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
  crossorigin="anonymous"></script>

  <meta property="og:title" content="@yield('title')">
  <meta name="twitter:title" content="@yield('title')">
  <meta property="og:description" content="@yield('description')">
  <meta name="twitter:description" content="@yield('description')">
  <meta name="description" content="@yield('description')">
  <meta property="og:url" content="{{url()->full()}}">
  <meta property="og:type" content="website">
  <meta property="og:site_name" content="{{config('app.name', 'Laravel')}}">
  <meta property="og:locale" content="ja_JP">
  <meta property="fb:app_id" content="339751459830292">
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:domain" content="{{config('app.domain')}}">
  <meta name="twitter:creator" content="@ryokurosu">
  <meta name="twitter:site" content="@ryokurosu">
  <meta property="og:image" content="@yield('image',url('/thumbnail.jpg'))">
  <meta name="twitter:url" content="{{url()->full()}}">
  <meta name="twitter:image" content="@yield('image',url('/thumbnail.jpg'))">
  <link rel="shortcut icon" href="{{url('/favicon.ico')}}">
  <link rel="apple-touch-icon-precomposed" href="{{url('/favicon.ico')}}">
  
  @yield('meta')



</head>
<body>
  <div id="app">
    <nav class="navbar navbar-default navbar-static-top">
      <div class="container">
        <div class="navbar-header">

          <!-- Collapsed Hamburger -->
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse" aria-expanded="false">
            <span class="sr-only">Toggle Navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>

          <!-- Branding Image -->
          <a class="navbar-brand" href="{{ url('/') }}">
            <img src="{{url('/logo.png')}}" alt="{{config('app.name')}}">
          </a>
        </div>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">
          <!-- Left Side Of Navbar -->
          <ul class="nav navbar-nav">
            <li><a href="{{route('article')}}">記事</a></li>
            <li><a href="{{route('topic')}}">ニュース</a></li>

          </ul>

          <!-- Right Side Of Navbar -->
          <ul class="nav navbar-nav navbar-right">
            <!-- Authentication Links -->
            @guest
            <li><a href="{{ route('login') }}">ログイン</a></li>
            <li><a href="{{ route('register') }}">登録</a></li>
            @else
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                {{ Auth::user()->name }} <span class="caret"></span>
              </a>

              <ul class="dropdown-menu">
                <li><a href="{{route('user.article')}}">記事管理</a></li>
                <li><a href="{{route('user.blog')}}">ブログ管理</a></li>
                <li><a href="{{route('user.profile')}}">設定</a></li>
                @if(Auth::user()->isAdmin())
                <hr>
                <li>管理者ページ</li>
                <li><a href="{{route('admin.article')}}">記事管理</a></li>
                <li><a href="{{route('admin.blog')}}">ブログ管理</a></li>
                <li><a href="{{route('admin.user')}}">ユーザー管理</a></li>
                <li><a href="{{route('admin.topic')}}">ニュース管理</a></li>
                @endif
                <hr>
                <li>
                  <a href="{{ route('logout') }}"
                  onclick="event.preventDefault();
                  document.getElementById('logout-form').submit();">
                  Logout
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  {{ csrf_field() }}
                </form>
              </li>
            </ul>
          </li>
          @endguest
        </ul>
      </div>
    </div>
  </nav>
  <div class="container">
    <div class="row">
      @if(View::hasSection('fullLayout'))
      <div id="main" class="col-md-12 col-xs-12">
        @yield('content')
      </div>
      @else
      <div id="main" class="col-md-9 col-xs-12">
        @yield('content')
      </div>
      <div id="side" class="col-md-3 col-xs-12">
        <!-- ここにsideコンテンツも自動で入れて良い -->
        @yield('side')
        @foreach(\App\Coin::all() as $c)
        <ul class="list-group">
          <li class="list-group-item title">1{{$c->unit}}</li>
          <li class="list-group-item">
            <center>{{$c->per}}円</center>
          </li>
        </ul>
        @endforeach
        <ul class="list-group">
          <li class="list-group-item title">人気記事</li>
          @foreach($PopularArticles as $article)
          <li class="list-group-item">
            <a href="{{route('article.page',$article)}}">
              <div class="div-box"><img src="{{$article->imagePath()}}" alt="{{$article->title}}"></div>
              <div class="div-box">{{$article->title}}</div>
            </a>
            <p class="article-{{$article->id}}-amount">{{number_format($article->amount,5)}}BTC</p>
            @foreach(\App\Coin::all() as $coin)
            <button type="button" class="btn btn-{{$coin->alias}} coin-tip-btn" value="{{$article->id}}" data-set="{{$coin->unit}}" data-target="article">
              TIP<img src="{{$coin->imagePath()}}" alt="{{$coin->name}}@yield('title')" width="22">
            </button>
            @endforeach
          </li>
          @endforeach
        </ul>

        <ul class="list-group">
          <li class="list-group-item title">人気ブログ</li>
          @foreach($PopularBlogs as $blog)
          <li class="list-group-item">
            <div class="div-box"><img src="{{$blog->imagePath()}}" alt="{{$blog->title}}"></div>
            <div class="div-box">{{$blog->title}}</div>
            <p class="blog-{{$blog->id}}-amount">{{number_format($blog->amount,5)}}BTC</p>
            @foreach(\App\Coin::all() as $coin)
            <button type="button" class="btn btn-{{$coin->alias}} coin-tip-btn" value="{{$blog->id}}" data-set="{{$coin->unit}}" data-target="blog">
              TIP<img src="{{$coin->imagePath()}}" alt="{{$coin->name}}@yield('title')" width="22">
            </button>
            @endforeach
          </li>
        </li>
        @endforeach
      </ul>
    </div>
    @endif
  </div>
</div>
</div>

<!-- Scripts -->
<script>
  $(function(){
    $('.coin-tip-btn').on('click',function(){
      $elem = $(this);
      var target = $(this).attr('data-target');
      var id = $(this).val();
      var amount = 0.00001;
      var alias;
      switch(target){
        case 'article':
        alias = 'articledonate';
        break;

        case 'blog':
        alias = 'blogdonate';
        break;

        default:
        alias = 'articledonate';
        break;
      }
      $.ajax({
        type : "POST",
        data : {
          id : id,
          amount : amount
        },
        url : "{{url('/user')}}/" + alias,
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success : function(data) {
         if(data.status){
          var _val = data.amount;
          var val  = Math.floor(_val * 100000) / 100000;

          $('.' + target + '-' + id + '-amount').text(val+'BTC');
          $elem.prop('disabled',true);
        }
      },
      error : function(data) {
        　alert('エラーが発生しました。ページを更新してください。');
        
      　　}　
    });
    })
  });

</script>
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
