@extends('layouts.admin')
@section('content')
    <!--面包屑配置项 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{ url('admin/info') }}">首页</a> &raquo; 配置项管理
    </div>
    <!--面包屑配置项 结束-->

    <!--搜索结果页面 列表 开始-->

        <div class="result_wrap">
            <div class="result_title">
                <h3>配置项列表</h3>
                @if(count($errors) > 0)
                    <div class="mark">
                        @if(is_object($errors))
                            @foreach($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        @else
                            <p>{{ $errors }}</p>
                        @endif
                    </div>
                @endif
            </div>
            <!--快捷配置项 开始-->
            <div class="result_content">
                <div class="short_wrap">
                    <a href="{{ url('admin/conf/create') }}"><i class="fa fa-plus"></i>添加配置项</a>
                    <a href="{{ url('admin/conf') }}"><i class="fa fa-recycle"></i>全部配置项</a>
                </div>
            </div>
            <!--快捷配置项 结束-->
        </div>
    <form action="{{ url('admin/conf/changecontent') }}" method="post">
        {{ csrf_field() }}
        <div class="result_wrap">
            <div class="result_content">
                <table class="list_tab">
                    <tr>
                        <th class="tc" width="5%">排序</th>
                        <th class="tc" width="5%">conf_ID</th>
                        <th>名称</th>
                        <th>标题</th>
                        <th>内容</th>
                        <th>操作</th>
                    </tr>
                    @foreach($data as $v)
                        <tr>
                            <td class="tc">
                                <input type="text" onchange="changeOrder(this, {{ $v->conf_id }})" value="{{ $v->conf_order }}">
                            </td>
                            <td class="tc">{{ $v->conf_id }}</td>
                            <td>
                                <a href="#">{{ $v->conf_name }}</a>
                            </td>
                            <td>{{ $v->conf_title }}</td>
                            <td>
                                <input type="hidden" name="conf_id[]" value="{{ $v->conf_id }}" />
                                {!! $v->_html !!}
                            </td>
                            <td>
                                <a href="{{ url('admin/conf/'.$v->conf_id.'/edit') }}">修改</a>
                                <a href="javascript:;" onclick="delConfig({{$v->conf_id}})">删除</a>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
        <div class="btn_group">
            <input type="submit" value="提交">
            <input type="button" class="back" onclick="history.go(-1)" value="返回" >
        </div>
    </form>
    <!--搜索结果页面 列表 结束-->
<script>
    function changeOrder(obj, conf_id) {
        var conf_order = $(obj).val();
        $.post('{{ url('admin/conf/changeorder') }}', {'_token':'{{ csrf_token() }}', 'conf_id':conf_id, 'conf_order':conf_order}, function (data) {
            if (data.status == 1) {
                layer.alert(data.msg, {icon: 6});
            } else  {
                layer.alert(data.msg, {icon: 5});
            }
        })
    }

    function delConfig(conf_id) {
        //询问框
        layer.confirm('您确定删除吗？', {
            btn: ['确定','取消'] //按钮
        }, function(){
            $.post('{{ url('admin/conf/') }}/'+ conf_id, {'_method':'delete', '_token':'{{ csrf_token() }}', 'conf_id':conf_id}, function (data) {
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
