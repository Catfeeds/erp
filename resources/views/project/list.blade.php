@extends('layouts.main')
@section('title','已立项清单')
@section('content')
    <div class="index-content print-no-padding">
<div class="ui breadcrumb">
    <a class="section">项目立项管理</a>
    <div class="divider"> / </div>
    <div class="active section">已立项清单</div>
</div>

<!-- 操作区域 -->
<div class="content-operation flex-row flex-between">
    <div>
        <a class="ui primary button" href="javascript:_helper.fullWindow('{{url('project/create')}}');">
            <i class="icon plus"></i>
            <span>新建立项</span>
        </a>
        <a class="ui green button" href="{{url('export/project/list')}}?search={{$search}}">
            <i class="icon download"></i>
            <span>Excel 导出</span>
        </a>
    </div>
    <form class="ui form flex-fluid">
        <div class="ui left action right input fluid">
            <div class="ui button white dropdown ">
                <input name="seartch-type" type="hidden">
                <div class="text">请选中搜索内容</div>
                <i class="dropdown icon"></i>
                <div class="menu">
                    <div class="item" data-value="1">项目号</div>
                    <div class="item" data-value="2">项目内容</div>
                    <div class="item" data-value="3">甲方</div>
                </div>
            </div>
            <input name="search" type="text" placeholder="搜索内容" value="">
            <button class="ui button">搜索</button>
        </div>
    </form>
</div>
<!-- / 操作区域 -->

<div class="content-wrap">

    <table class="ui center aligned table selectable" id="projectDetailTable">
        <thead>
        <tr>
            <th>项目号</th>
            <th>立项日期</th>
            <th>项目内容</th>
            <th>项目经理</th>
            <th>合同金额</th>
            <th>实际金额</th>
            <th>甲方</th>
            <th>主合同金额</th>
            <th>发包单位</th>
            <th>分包合同金额</th>
            <th>合同约定完工日期</th>
            <th>状态</th>
        </tr>
        </thead>
        <tbody>
        @foreach($projects as $project)
        <tr>
            <td>
                <a href="{{url('project/check')}}?id={{$project->id}}">{{$project->number}}</a>
            </td>
            <td>{{date('Y-m-d',$project->createTime)}}</td>
            <td title="{{$project->name}}">{{$project->name}}</td>
            <td>{{$project->pm}}</td>
            <td>{{number_format($project->price,2)}}</td>
            <td>{{number_format(\App\Models\ProjectSituations::where('project_id','=',$project->id)->sum('price'),2)}}</td>
            <td>{{$project->PartyA}}</td>
            <td>{{number_format(\App\Models\ProjectSituations::where('project_id','=',$project->id)->where('type','=',1)->sum('price'),2)}}</td>
            <td>{{implode('|',$project->unit)}}</td>
            <td>{{number_format(\App\Models\ProjectSituations::where('project_id','=',$project->id)->where('type','=',2)->sum('price'),2)}}</td>
            <td>{{date('Y-m-d',$project->finishTime)}}</td>
            <td>{{$project->state==1?'未确认':'已确认'}}</td>
        </tr>
        @endforeach
        </tbody>
    </table>

</div>
        {{$projects->links()}}
@endsection
@section('pageJs')
    <script src="{{url('js/project_list.js')}}"></script>
@endsection