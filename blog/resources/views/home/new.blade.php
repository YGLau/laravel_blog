@extends('layouts.home')
@section('info')
  <title>{{ $article->art_title }} - {{ Config::get('web.web_title') }}</title>
  <meta name="keywords" content="{{ $article->art_tag }}" />
  <meta name="description" content="{{ $article->art_description }}" />
@endsection
@section('content')
  <article class="blogs">
    <h1 class="t_nav">
      <a href="{{ url('/') }}" class="n1">网站首页</a><a href="{{ url('/list/'.$article->cate_id) }}" class="n2">{{ $article->cate_name }}</a>
    </h1>
    <div class="index_about">
      <h2 class="c_titile">{{ $article->art_title }}</h2>
      <p class="box_c"><span class="d_time">发布时间：{{ date('Y-m-d', $article->art_time) }}</span><span>编辑：{{ $article->art_editor }}</span><span>查看次数：{{ $article->art_view }}</span></p>
      <ul class="infos">
        {!! $article->art_content !!}
      </ul>
      <div class="keybq">
        <p><span>关键字词</span>：{{ $article->art_tag }}</p>

      </div>
      <div class="ad"> </div>
      <div class="nextinfo">
            <p>上一篇：
              @if($linkArt['pre'])
                <a href="{{ url('/a/'.$linkArt['pre']->art_id) }}">{{ $linkArt['pre']->art_title }}</a>
            </p>
              @else
                <span>没有上一篇了</span>
              @endif
          <p>下一篇：
            @if($linkArt['next'])
                <a href="{{ url('/a/'.$linkArt['next']->art_id) }}">{{ $linkArt['next']->art_title }}</a>
          </p>
            @else
                <span>没有下一篇了</span>
            @endif
      </div>
      <div class="otherlink">
        <h2>相关文章</h2>
        <ul>
          @foreach($linkArts as $art)
            <li><a href="{{ url('/a/'.$art->art_id) }}" title="{{ $art->art_title }}">{{ $art->art_title }}</a></li>
          @endforeach
        </ul>
      </div>
    </div>
    <aside class="right">
      <!-- Baidu Button BEGIN -->
      <div id="bdshare" class="bdshare_t bds_tools_32 get-codes-bdshare"><a class="bds_tsina"></a><a class="bds_qzone"></a><a class="bds_tqq"></a><a class="bds_renren"></a><span class="bds_more"></span><a class="shareCount"></a></div>
      <script type="text/javascript" id="bdshare_js" data="type=tools&amp;uid=6574585" ></script>
      <script type="text/javascript" id="bdshell_js"></script>
      <script type="text/javascript">
        document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + Math.ceil(new Date()/3600000)
      </script>
      <!-- Baidu Button END -->
      <div class="blank"></div>
      <div class="news">
        @parent
      </div>
    </aside>
  </article>
@endsection
