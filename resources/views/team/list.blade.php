@extends('layouts.main')
@section('title','已立项清单')
@section('content')
    <!-- 主体内容 === 不可复用 -->
    <div class="index-content print-no-padding">

        <div class="ui breadcrumb">
            <a class="section">数据维护</a>
            <div class="divider"> / </div>
            <div class="active section">施工队列表</div>
        </div>

        <!-- 操作区域 -->
        <div class="content-operation">

            <form action="" class="ui form">
                <div class="flex-row flex-between flex-wrap">
                    <div>
                        <a class="ui primary button" href="javascript:_helper.fullWindow('{{url('team/create')}}')">
                            <i class="icon plus"></i>
                            <span>新增施工队</span>
                        </a>
                        <a class="ui green button" href="{{url('export/team')}}">
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
                                <div class="item" data-value="2">施工队名称</div>
                                <div class="item" data-value="3">施工队经理</div>
                            </div>
                        </div>
                        <input name="name" type="text" placeholder="搜索内容" value="">
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
                    <th>施工队名称</th>
                    <th>施工队经理</th>
                    <th>开户银行</th>
                    <th>账号</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($teams as $team)
                <tr>
                    <td>{{$team->id}}</td>
                    <td>{{$team->name}}</td>
                    <td>{{$team->manager}}</td>
                    <td>{{$team->bank}}</td>
                    <td>{{$team->account}}</td>
                    <td style="white-space:nowrap">
                        <a class="ui mini button primary" href="javascript:_helper.fullWindow('{{url('team/create')}}?id={{$team->id}}')">修改</a>
                        <button class="ui mini button negative dataTeamDelete" data-id="{{$team->id}}">删除</button>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>

    </div>
    <!-- /主体内容 === 不可复用 -->
@endsection
@section('pageJs')
    <script src="{{url('js/data_team_list.js')}}"></script>
@endsection