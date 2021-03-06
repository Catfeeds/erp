@extends('layouts.main')
@section('title','仓库列表')
@section('content')
    <!-- 主体内容 === 不可复用 -->
    <div class="index-content print-no-padding">

        <div class="ui breadcrumb">
            <a class="section">数据维护</a>
            <div class="divider"> / </div>
            <div class="active section">仓库列表</div>
        </div>

        <!-- 操作区域 -->
        <div class="content-operation">

            <form method="get" class="ui form">
                <div class="flex-row flex-between flex-wrap">
                    <div>
                        <a class="ui primary button" href="javascript:_helper.fullWindow('{{url('warehouse/create')}}')">
                            <i class="icon plus"></i>
                            <span>新增仓库</span>
                        </a>
                        <a class="ui green button" href="{{url('export/warehouse')}}">
                            <i class="icon download"></i>
                            <span>Excel 导出</span>
                        </a>
                    </div>
                    <div class="ui left action right input fluid flex-fluid">
                        <div class="ui button white dropdown ">
                            <input name="search-type" type="hidden">
                            <div class="text">请选中搜索内容</div>
                            <i class="dropdown icon"></i>
                            <div class="menu">
                                <div class="item" data-value="1">仓库名称</div>
                                <div class="item" data-value="2">仓管员</div>
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
                    <th>仓库名称</th>
                    <th style="min-width:300px">仓库地址</th>
                    <th>仓管员</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @for($i=0;$i<count($warehouses);$i++)
                {{--@foreach($warehouses as $warehouse)--}}
                <tr>
                    <td>{{$i+1}}</td>
                    <td>{{$warehouses[$i]->name}}</td>
                    <td>{{$warehouses[$i]->address}}</td>
                    <td>{{$warehouses[$i]->admin}}</td>
                    <td style="white-space:nowrap;">
                        <a class="ui mini button primary" href="javascript:_helper.fullWindow('{{url('warehouse/create?id=')}}{{$warehouses[$i]->id}}')">修改</a>
                        <button class="ui mini button negative dataWarehouseDelete" data-id="{{$warehouses[$i]->id}}">删除</button>
                    </td>
                </tr>
                @endfor
                {{--@endforeach--}}
                </tbody>
            </table>
        </div>
        {{$warehouses->appends(['name'=>$name,'search-type'=>$type])->links()}}
    </div>
    <!-- /主体内容 === 不可复用 -->

@endsection
@section('pageJs')
    <script src="{{url('js/data_warehouse_list.js')}}"></script>
@endsection