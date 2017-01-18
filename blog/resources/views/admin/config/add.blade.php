@extends('layouts.admin')
@section('content')
    <!--面包屑配置项 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{ url('admin/info') }}">首页</a> &raquo; 添加配置项
    </div>
    <!--面包屑配置项 结束-->

    <!--结果集标题与配置项组件 开始-->
    <div class="result_wrap">
        <div class="result_alias">
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
            <h3>快捷操作</h3>
        </div>
        <div class="result_content">
            <div class="short_wrap">
                <a href="{{ url('admin/conf') }}"><i class="fa fa-recycle"></i>全部配置项</a>
            </div>
        </div>
    </div>
    <!--结果集标题与配置项组件 结束-->

    <div class="result_wrap">
        <form action="{{ url('admin/conf') }}" method="post">
            {{ csrf_field() }}
            <table class="add_tab">
                <tbody>
                <tr>
                    <th><i class="require">*</i>标题：</th>
                    <td>
                        <input type="text" class="sm" name="conf_title">
                        <span><i class="fa fa-exclamation-circle yellow ">标题必须填写</i></span>
                    </td>
                </tr>
                <tr>
                    <th><i class="require">*</i>名称：</th>
                    <td>
                        <input type="text" class="sm" name="conf_name">
                        <span><i class="fa fa-exclamation-circle yellow ">名称必须填写</i></span>
                    </td>
                </tr>

                <tr>
                    <th>字段类型：</th>
                    <td>
                        <input type="radio" name="field_type" value="input" checked onclick="controlTr()">input
                        <input type="radio" name="field_type" value="textarea" onclick="controlTr()">textarea
                        <input type="radio" name="field_type" value="radio" onclick="controlTr()">radio
                    </td>
                </tr>
                <tr class="field_value">
                    <th>类型值：</th>
                    <td>
                        <input type="text" class="lg" name="field_value">
                        <p><i class="fa fa-exclamation-circle yellow ">类型只有在radio情况下才需要配置,1|开启,0|关闭</i></p>
                    </td>
                </tr>
                <tr>
                    <th>排序：</th>
                    <td>
                        <input type="text" class="sm" name="conf_order" value="0">
                    </td>
                </tr>
                <tr>
                    <th>说明：</th>
                    <td>
                        <textarea name="conf_tips" id="" cols="30" rows="10"></textarea>
                    </td>
                </tr>
                <tr>
                    <th></th>
                    <td>
                        <input type="submit" value="提交">
                        <input type="button" class="back" onclick="history.go(-1)" value="返回">
                    </td>
                </tr>
                </tbody>
            </table>
        </form>
    </div>
    <script>
       controlTr();
        function controlTr() {
            var type = $('input[name=field_type]:checked').val();
            if (type == 'radio') {
                $('.field_value').show();
            } else  {
                $('.field_value').hide();
            }
        }
    </script>
@endsection

