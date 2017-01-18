@extends('layouts.admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{ url('admin/info') }}">首页</a> &raquo; 文章管理
    </div>
    <!--面包屑导航 结束-->

    <!--搜索结果页面 列表 开始-->
    <form action="#" method="post">

        <div class="result_wrap">
            <div class="result_title">
                <h3>文章列表</h3>
            </div>
            <!--快捷导航 开始-->
            <div class="result_content">
                <div class="short_wrap">
                    <a href="{{ url('admin/article/create') }}"><i class="fa fa-plus"></i>新增文章</a>
                    <a href="#"><i class="fa fa-recycle"></i>批量删除</a>
                    <a href="#"><i class="fa fa-refresh"></i>更新排序</a>
                </div>
            </div>
            <!--快捷导航 结束-->
        </div>

        <div class="result_wrap">
            <div class="result_content">
                <table class="list_tab">
                    <tr>
                        <th class="tc">排序</th>
                        <th class="tc">ID</th>
                        <th>文章标题</th>
                        <th>关键词</th>
                        <th>发布人</th>
                        <th>更新时间</th>
                        <th>查看次数</th>
                        <th>操作</th>
                    </tr>
                    @foreach($data as $v)
                        <tr>
                            <td class="tc">
                                <input type="text" name="ord[]" value="{{ $v->cate_id }}">
                            </td>
                            <td>{{ $v->art_id }}</td>
                            <td>
                                <a href="{{ url('admin/article/'.$v->art_id.'/edit') }}">{{ $v->art_title }}</a>
                            </td>
                            <td>{{ $v->art_tag }}</td>
                            <td>{{ $v->art_editor }}</td>
                            <td>{{ date('Y-m-d H:i:s', $v->art_time) }}</td>
                            <td class="tc">{{ $v->art_view }}</td>
                            <td>
                                <a href="{{ url('admin/article/'.$v->art_id.'/edit') }}">修改</a>
                                <a href="javascrpt:;" onclick="delArt({{ $v->art_id }})">删除</a>
                            </td>
                        </tr>
                    @endforeach

                </table>

                <div class="page_list">
                    {{ $data->links() }}
                </div>
            </div>

        </div>
    </form>
    <!--搜索结果页面 列表 结束-->
<style>
    .result_content ul li span {
        font-size: 15px;
        padding: 6px 12px;
    }
</style>
    <script>
        function delArt(art_id) {
            //询问框
            layer.confirm('您确定删除这篇文章吗？', {
                btn: ['确定','取消'] //按钮
            }, function(){
                $.post('{{ url('admin/article/') }}/'+ art_id, {'_method':'delete', '_token':'{{ csrf_token() }}', 'art_id':art_id}, function (data) {
                    if (data.status == 1) {
                        location.href = location.href;
                        layer.alert(data.msg, {icon: 6});
                    } else {
                        layer.alert(data.msg, {icon: 5});
                    }
                });
            }, function(){
            });
        }
    </script>

@endsection

