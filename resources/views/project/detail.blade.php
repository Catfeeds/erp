@extends('layouts.main')
@section('title','已立项清单')
@section('content')
    <!-- 主体内容 === 不可复用 -->
    <div class="index-content print-no-padding">

        <div class="ui breadcrumb">
            <a class="section">项目立项管理</a>
            <div class="divider"> / </div>
            <div class="active section">项目明细清单</div>
        </div>

        <!-- 操作区域 -->
        <div class="content-operation flex-row flex-between flex-wrap">
            <div class="margin-top-20">
                <a class="ui green button" href="#">
                    <i class="icon download"></i>
                    <span>Excel 导出</span>
                </a>
            </div>
            <form action="" class="ui form flex-fluid margin-top-20">
                <div class="ui left action right input fluid">
                    <div class="ui button white dropdown ">
                        <input name="seartch-type" type="hidden">
                        <div class="text">请选中搜索内容</div>
                        <i class="dropdown icon"></i>
                        <div class="menu">
                            <div class="item" data-value="1">项目号</div>
                            <div class="item" data-value="2">项目内容</div>
                        </div>
                    </div>
                    <input name="search" type="text" placeholder="搜索内容" value="">
                    <button class="ui button">搜索</button>
                </div>
            </form>
        </div>
        <!-- / 操作区域 -->


        <!-- 表格循环 -->
        <div class="content-wrap table-head-nowrap">
            {{--<table class="ui celled structured table unstackable">--}}
                {{--<thead>--}}
                {{--<tr>--}}
                    {{--<th rowspan="2">类型</th>--}}
                    {{--<th rowspan="2">项目</th>--}}
                    {{--<th rowspan="2">内容</th>--}}
                    {{--<th rowspan="2">金额相关</th>--}}
                    {{--<th rowspan="2">金额类型</th>--}}
                    {{--<th rowspan="2">金额</th>--}}
                {{--</tr>--}}
                {{--</thead>--}}
                {{--<tbody>--}}
                {{--@foreach($projects as $project)--}}
                {{--<tr>--}}
                    {{--<td rowspan="7">基本</td>--}}
                    {{--<td>项目号</td>--}}
                    {{--<td>{{$project->number}}</td>--}}
                    {{--<td rowspan="2">--}}
                        {{--<div class="flex-row flex-between">--}}
                            {{--<p>项目实际金额</p>--}}
                            {{--<p>{{$project->mainContract()->sum('price')+$project->outContract()->sum('price')}} ￥</p>--}}
                        {{--</div>--}}
                    {{--</td>--}}
                    {{--<td>主合同金额</td>--}}
                    {{--<td>{{$project->mainContract()->sum('price')}} ￥</td>--}}
                {{--</tr>--}}
                {{--<tr>--}}
                    {{--<td>项目内容</td>--}}
                    {{--<td class="detail__content">{{$project->content}}</td>--}}
                    {{--<td>分包合同金额</td>--}}
                    {{--<td>{{$project->outContract()->sum('price')}} ￥</td>--}}
                {{--</tr>--}}
                {{--<tr>--}}
                    {{--<td>项目经理</td>--}}
                    {{--<td>{{$project->pm}}</td>--}}
                    {{--<td rowspan="5">其他金额相关</td>--}}
                    {{--<td>项目剩余未收款</td>--}}
                    {{--<td>12,423,222 ￥</td>--}}
                {{--</tr>--}}
                {{--<tr>--}}
                    {{--<td>合同金额</td>--}}
                    {{--<td>12,423,222 ￥</td>--}}
                    {{--<td>已开票请款</td>--}}
                    {{--<td>12,423,222 ￥</td>--}}
                {{--</tr>--}}
                {{--<tr>--}}
                    {{--<td>约定完工日期</td>--}}
                    {{--<td>2018-02-11</td>--}}
                    {{--<td>主合同收款</td>--}}
                    {{--<td>12,423,222 ￥</td>--}}
                {{--</tr>--}}
                {{--<tr>--}}
                    {{--<td>验收日期</td>--}}
                    {{--<td>2018-02-11</td>--}}
                    {{--<td>分包合同收款</td>--}}
                    {{--<td>12,423,222 ￥</td>--}}
                {{--</tr>--}}
                {{--<tr>--}}
                    {{--<td>保修截至日期</td>--}}
                    {{--<td>2018-02-11</td>--}}
                    {{--<td>应收账款</td>--}}
                    {{--<td>12,423,222 ￥</td>--}}
                {{--</tr>--}}
                {{--<tr>--}}
                    {{--<td class="center aligned" style="font-size:40px;" colspan="3" rowspan="5">--}}
                        {{--<a href="javascript:_helper.fullWindow()">权限设置</a>--}}
                    {{--</td>--}}
                    {{--<td rowspan="5">--}}
                        {{--<div class="flex-row flex-between">--}}
                            {{--<p>已发生成本</p>--}}
                            {{--<p>12,423,222 ￥</p>--}}
                        {{--</div>--}}
                    {{--</td>--}}
                    {{--<td>领料成本</td>--}}
                    {{--<td>12,423,222 ￥</td>--}}
                {{--</tr>--}}
                {{--<tr>--}}
                    {{--<td>施工成本</td>--}}
                    {{--<td>12,423,222 ￥</td>--}}
                {{--</tr>--}}
                {{--<tr>--}}
                    {{--<td>报销项目成本</td>--}}
                    {{--<td>12,423,222 ￥</td>--}}
                {{--</tr>--}}
                {{--<tr>--}}
                    {{--<td>费用付款其他成本</td>--}}
                    {{--<td>12,423,222 ￥</td>--}}
                {{--</tr>--}}
                {{--<tr>--}}
                    {{--<td>退料成本</td>--}}
                    {{--<td>12,423,222 ￥</td>--}}
                {{--</tr>--}}

                    {{--@endforeach--}}
                {{--</tbody>--}}
            {{--</table>--}}
            <table class="ui center aligned table selectable unstackable">
                <thead>
                <tr>
                    <th>项目号</th>
                    <th>项目内容</th>
                    <th>项目经理</th>
                    <th>约定完工日期</th>
                    <th>验收日期</th>
                    <th>保修截至日期</th>
                    <th class="function-toggle-one">项目实际金额（展开）</th>
                    <th class="function-one">主合同金额</th>
                    <th class="function-one">分包合同金额</th>
                    <th class="function-toggle-two">项目剩余未收款（展开）</th>
                    <th class="function-two">主合同未收款</th>
                    <th class="function-two">分包合同未收款</th>
                    <th class="function-toggle-three">应收账款（展开）</th>
                    <th class="function-three">已开票请款</th>
                    <th class="function-three">主合同收款</th>
                    <th class="function-three">分包合同收款</th>
                    <th class="function-toggle-four">已发生成本（展开）</th>
                    <th class="function-four">可领料成本</th>
                    <th class="function-four">施工成本</th>
                    <th class="function-four">报销项目成本</th>
                    <th class="function-four">费用其他成本</th>
                    <th class="function-four">退料成本</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($projects as $project)
                <tr>
                    <td>{{$project->number}}</td>
                    <td>{{$project->name}}</td>
                    <td>{{$project->pm}}</td>
                    <td>{{date('Y-m-d',$project->finishTime)}}</td>
                    <td>{{$project->acceptance_date}}</td>
                    <td>{{$project->deadline}}</td>
                    <td>{{$project->situation()->sum('price')}}￥</td>
                    <td class="function-one">{{$project->situation()->where('type','=',1)->sum('price')}}￥</td>
                    <td class="function-one">{{$project->situation()->where('type','=',2)->sum('price')}}￥</td>
                    <td>221,234￥</td>
                    <td class="function-two">221,234￥</td>
                    <td class="function-two">221,234￥</td>
                    <td>221,234￥</td>
                    <td class="function-three">221,234￥</td>
                    <td class="function-three">221,234￥</td>
                    <td class="function-three">221,234￥</td>
                    <td>221,234￥</td>
                    <td class="function-four">221,234￥</td>
                    <td class="function-four">221,234￥</td>
                    <td class="function-four">221,234￥</td>
                    <td class="function-four">221,234￥</td>
                    <td class="function-four">221,234￥</td>
                    <td>
                        <a href="javascript:_helper.fullWindow('{{url('project/auth')}}?id={{$project->id}}')">权限设置</a>
                    </td>
                </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- / 表格循环 -->
        {{$projects->links()}}
    </div>
    <!-- /主体内容 === 不可复用 -->
@endsection
@section('pageJs')
    <script src="{{url('js/project_detail.js')}}"></script>
@endsection