<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    @yield('info')
    <link href="{{ url('resources/views/home/css/base.css') }}" rel="stylesheet">
    <link href="{{ url('resources/views/home/css/index.css') }}" rel="stylesheet">
    <link href="{{ url('resources/views/home/css/style.css') }}" rel="stylesheet">
    <link href="{{ url('resources/views/home/css/new.css') }}" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="{{ url('resources/views/home/js/modernizr.js') }}"></script>
    <![endif]-->
</head>
<body>
<header>
    <div id="logo"><a href="/"></a></div>
    <nav class="topnav" id="topnav">
        @foreach($navs as $k => $v)
            <a href="{{ $v->nav_id == '1' ? url('/') : url('/list/'.$v->nav_id) }}"><span>{{ $v->nav_name }}</span><span class="en">{{ $v->nav_alias }}</span></a>
        @endforeach
    </nav>
</header>
@section('content')
    <h3>
        <p>最新<span>文章</span></p>
    </h3>
    <ul class="rank">
        @foreach($newArticles as $new)
            <li><a href="{{ url('a/'.$new->art_id) }}" title="{{ $new->art_title }}" target="_blank">{{ $new->art_title }}</a></li>
        @endforeach
    </ul>
    <h3 class="ph">
        <p>点击<span>排行</span></p>
    </h3>
    <ul class="paih">
        @foreach($hotClick as $c)
            <li><a href="{{ url('a/'.$c->art_id) }}" title="{{ $c->art_title }}" target="_blank">{{ $c->art_title }}</a></li>
        @endforeach
    </ul>
@show
<footer>
    <p>{!! Config::get('web.copyright') !!} {!! Config::get('web.web_count') !!}</p>
</footer>
{{--<script src="{{ url('resources/views/home/js/silder.js') }}"></script>--}}
</body>
</html>
