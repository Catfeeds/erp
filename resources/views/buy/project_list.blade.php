@extends('layouts.main')
@section('title','已立项清单')
@section('content')
    <!-- 主体内容 === 不可复用 -->
    <div class="index-content print-no-padding">

        <div class="ui breadcrumb">
            <a class="section">采购管理</a>
            <div class="divider"> / </div>
            <div class="active section">采购立项清单</div>
        </div>

        <!-- 操作区域 -->
        <div class="content-operation flex-row flex-between flex-wrap">
            <div>
                <button id="buyNewProjectLink" class="ui primary button">
                    <i class="icon plus"></i>
                    <span>新建立项</span>
                </button>
            </div>
            <form action="/views/buy/project_list.html" class="ui form flex-fluid">
                <div class="ui left action right input fluid">
                    <div class="ui button white dropdown ">
                        <input name="seartch-type" type="hidden">
                        <div class="text">请选中搜索内容</div>
                        <i class="dropdown icon"></i>
                        <div class="menu">
                            <div class="item" data-value="1">采购编号</div>
                            <div class="item" data-value="2">供货商</div>
                            <div class="item" data-value="3">项目编号</div>
                            <div class="item" data-value="4">项目内容</div>
                        </div>
                    </div>
                    <input name="value" type="text" placeholder="搜索内容" value="">
                    <button class="ui button">搜索</button>
                </div>
            </form>
        </div>
        <!-- / 操作区域 -->

        <div class="content-wrap table-head-nowrap">

            <table class="ui center aligned table selectable unstackable" id="projectDetailTable">
                <thead>
                <tr>
                    <th>采购编号</th>
                    <th>供货商</th>
                    <th>采购金额</th>
                    <th>项目编号</th>
                    <th>项目内容</th>
                    <th>项目经理</th>
                    <th>发票条件</th>
                    <th>经办人</th>
                    <th>复核人</th>
                    <th>审批人</th>
                    <th>预算内/外</th>
                </tr>
                </thead>
                <tbody>
                @foreach($lists as $list)
                <tr>
                    <td>
                        <a href="javascript:_helper.fullWindow('{{url('stock/check/budgetary')}}?id={{$list->id}}')">{{$list->number}}</a>
                    </td>
                    <td>{{$list->supplier}}</td>
                    <td>123,233,421 ￥</td>
                    <td>{{\App\Models\Project::find($list->project_id)->number}}</td>
                    <td class="table-content" title="这是一大段内容这是一大段内容这是一大段内容这是一大段内容这是一大段内容">{{\App\Models\Project::find($list->project_id)->name}}</td>
                    <td>{{\App\Models\Project::find($list->project_id)->pm}}</td>
                    <td>专用票17%</td>
                    <td>专用票11%</td>
                    <td>张三</td>
                    <td>李四</td>
                    <td>内</td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="ui page dimmer">
            <div class="content">
                <div class="center">
                    <a href="javascript:_helper.fullWindow('{{url('buy/budgetary')}}')" class="ui inverted teal approve button">预算内采购</a>
                    <a href="javascript:_helper.fullWindow('{{url('buy/extrabudgetary')}}')" class="ui inverted blue approve button">预算外采购</a>
                </div>
            </div>
        </div>

    </div>
    <!-- /主体内容 === 不可复用 -->
@endsection
@section('pageJs')
    <script src="{{url('js/buy_project_list.js')}}"></script>
@endsection