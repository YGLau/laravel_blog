@extends('layouts.home')
@section('info')
    <title>后盾个人博客</title>
    <meta name="keywords" content="{{ $cate->cate_keywords }}" />
    <meta name="description" content="{{ $cate->cate_description }}" />
@endsection
@section('content')
    <article class="blogs">
        <h1 class="t_nav"><span>{{ $cate->cate_title }}</span><a href="{{url('/')}}" class="n1">网站首页</a><a href="{{ $nav->nav_name == '首页' ? '/' : url('/list/'.$nav->nav_id)}}" class="n2">{{ $nav->nav_name }}</a></h1>
        <div class="newblog left">
            @foreach($articles as $a)
            <h2>{{ $a->art_title }}</h2>
            <p class="dateview"><span>发布时间：{{ date('Y-m-d', $a->art_time) }}</span><span>作者：{{ $a->art_editor }}</span><span>分类：[<a href="/news/life/">{{ $cate->cate_name }}</a>]</span></p>
            <figure><img src="{{ url($a->art_thumb) }}"></figure>
            <ul class="nlist">
                <p>{{ $a->art_description }}</p>
                <a title="{{ $a->art_title }}" href="{{ url('a/'.$a->art_id) }}" target="_blank" class="readmore">阅读全文>></a>
            </ul>
            <div class="line"></div>
            @endforeach

            <div class="page">
                {{ $articles->links() }}
            </div>
        </div>
        <aside class="right">
            @if($subCates)
            <div class="rnav">
                <ul>
                    @foreach($subCates as $subC)
                    <li class="rnav{{ $subC->cate_order }}"><a href="#" target="_blank">{{ $subC->cate_name }}</a></li>
                    @endforeach
                </ul>
            </div>
            @endif
            <div class="news">
                @parent
            </div>
            {{--<div class="visitors">--}}
                {{--<h3><p>最近访客</p></h3>--}}
                {{--<ul>--}}
                {{--</ul>--}}
            {{--</div>--}}
            <!-- Baidu Button BEGIN -->
            <div id="bdshare" class="bdshare_t bds_tools_32 get-codes-bdshare"><a class="bds_tsina"></a><a class="bds_qzone"></a><a class="bds_tqq"></a><a class="bds_renren"></a><span class="bds_more"></span><a class="shareCount"></a></div>
            <script type="text/javascript" id="bdshare_js" data="type=tools&amp;uid=6574585" ></script>
            <script type="text/javascript" id="bdshell_js"></script>
            <script type="text/javascript">
                document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + Math.ceil(new Date()/3600000)
            </script>
            <!-- Baidu Button END -->
        </aside>
    </article>
@endsection
