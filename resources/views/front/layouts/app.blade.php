<!doctype html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
        <meta name="generator" content="Jekyll v4.0.1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title', '証券アナリストジャーナル検索')</title>
        <link rel="canonical" href="https://getbootstrap.com/docs/4.5/examples/album/">
        <!-- jQuery Confirm -->
        <link href="{{ asset('plugins/jquery-confirm/jquery-confirm.min.css') }}" rel="stylesheet">
        <link href="{{ asset('/css/ionicons.css') }}" rel="stylesheet">
        <!-- app.css -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <!-- Custom styles for this template -->
        <link href="{{ asset('css/common.css') }}" rel="stylesheet">
        <link href="{{ asset('css/front.css') }}" rel="stylesheet">
        @yield('css')
    </head>
    <body class="{{!empty($isLp)?'page page-lp':''}}">
        <?php 
            $routeName = app('router')->currentRouteName();
        ?>
        @if($routeName != 'front-lp')
            @include('front.shared._header', [
                'routeName' => $routeName
            ])
        @endif

        @yield('content')

        @include('front.shared._footer')

        @if(empty($isLp))
            <div class="left-bn-area">
                <a href="{{route('front-lp')}}" class="btn btn-sm btn-secondary x-small">ジャーナル最新号（電子ブック）<span class="">&darr;</span></a>
            </div>
        @endif
        
        <form id="form-article-export" action="{{route('article-export')}}" method="post" enctype="multipart/form-data" hidden>
           {{csrf_field()}}
        </form>
        <!-- app.js -->
        <script src="{{ asset('js/app.js') }}"></script>
        <!-- jQuery -->
        <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
        <!-- jquery-confirm -->
        <script src="{{ asset('plugins/jquery-confirm/jquery-confirm.min.js') }}"></script>
        <script src="{{ asset('js/jquery.cookie.js') }}"></script>
        <script src="{{ asset('js/common.js') }}"></script>
        <script src="{{asset('js/front.js')}}"></script>
        @yield('js')
    </body>
</html>