@extends('layouts.main')
@section('title','人员权限')
@section('content')
    <!-- 主体内容 === 不可复用 -->
    <div class="index-content print-no-padding">

        <div class="ui breadcrumb">
            <a class="section">数据维护</a>
            <div class="divider"> / </div>
            <div class="active section">人员权限</div>
        </div>

        <!-- 操作区域 -->
        <div class="content-operation">

            <form action="" class="ui form">
                <div class="flex-row flex-between flex-wrap">
                    <div>
                        <a class="ui primary button" href="javascript:_helper.fullWindow('{{url('user/create')}}')">
                            <i class="icon plus"></i>
                            <span>新增人员</span>
                        </a>
                        <a class="ui green button" href="{{url('export/user')}}">
                            <i class="icon download"></i>
                            <span>Excel 导出</span>
                        </a>
                    </div>
                    <div class="ui left action right input fluid flex-fluid">
                        <div class="ui button white dropdown ">
                            <input name="seartch-type" type="hidden">
                            <div class="text">请选中搜索内容</div>
                            <i class="dropdown icon"></i>
                            <div class="menu">
                                <div class="item" data-value="2">员工名称</div>
                            </div>
                        </div>
                        <input name="search" type="text" placeholder="搜索内容" value="">
                        <button class="ui button">搜索</button>
                    </div>
                </div>
            </form>
        </div>
        <!-- / 操作区域 -->

        <div class="content-wrap table-head-nowrap">

            <table class="ui center aligned table selectable unstackable">
                <thead>
                <tr>
                    <th>序号</th>
                    <th>人员</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @for($i=0;$i<count($users);$i++)
                <tr>
                    <td>{{$i+1}}</td>
                    <td>{{$users[$i]->name}}</td>
                    <td>
                        <a class="ui mini button primary" href="javascript:_helper.fullWindow('{{url('auth/check')}}?id={{$users[$i]->id}}')">查询权限</a>
                        <a class="ui mini button" href="javascript:_helper.fullWindow('{{url('user/create')}}?id={{$users[$i]->id}}')">修改</a>
                        <button class="ui mini button negative authDelete" data-id="{{$users[$i]->id}}">删除</button>
                    </td>
                </tr>
                @endfor
                </tbody>
            </table>
        </div>
        {{$users->links()}}
    </div>
    <!-- /主体内容 === 不可复用 -->
@endsection
@section('pageJs')
    <script src="{{url('js/data_auth_list.js')}}"></script>
@endsection