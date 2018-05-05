@extends('layouts.main')
@section('title','已立项清单')
@section('content')
    <!-- 主体内容 === 不可复用 -->
    <div class="index-content print-no-padding">

        <div class="ui breadcrumb">
            <a class="section">数据维护</a>
            <div class="divider"> / </div>
            <div class="active section">项目类别列表</div>
        </div>

        <!-- 操作区域 -->
        <div class="content-operation">
            <a class="ui primary button" href="javascript:_helper.fullWindow('{{url('project/type/create')}}')">
                <i class="icon plus"></i>
                <span>新增类别</span>
            </a>
        </div>
        <!-- / 操作区域 -->

        <div class="content-wrap table-head-nowrap">

            <table class="ui center aligned table selectable unstackable">
                <thead>
                <tr>
                    <th>序号</th>
                    <th>内容</th>
                    <th>税率</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @for($i=0;$i<count($types);$i++)
                <tr>
                    <td>{{$i+1}}</td>
                    <td>{{$types[$i]->name}}</td>
                    <td>{{$types[$i]->rate}}%</td>
                    <td>
                        <a class="ui mini button primary" href="javascript:_helper.fullWindow('{{url('project/type/create')}}?id={{$types[$i]->id}}')">修改</a>
                        <button class="ui mini button negative dataTypeDelete" data-id="{{$types[$i]->id}}">删除</button>
                    </td>
                </tr>
                @endfor
                </tbody>
            </table>
        </div>

    </div>
    <!-- /主体内容 === 不可复用 -->
@endsection
@section('pageJs')
    <script src="{{url('js/data_type_list.js')}}"></script>
@endsection