@extends('layouts.main')
@section('title','已立项清单')
@section('content')
    <!-- 主体内容 === 不可复用 -->
    <div class="index-content print-no-padding">

        <div class="ui breadcrumb">
            <a class="section">库存管理</a>
            <div class="divider"> / </div>
            <div class="active section">领料出库清单</div>
        </div>

        <!-- 操作区域 -->
        <div class="content-operation flex-row flex-between flex-wrap">
            <div>
                <a href="javascript:_helper.fullWindow('{{url('stock/get/add')}}')" class="ui primary button">
                    <i class="icon plus"></i>
                    <span>新增领料出库</span>
                </a>
                <a href="{{url('export/stock/get/list')}}" class="ui positive button">
                    <i class="icon print"></i>
                    <span>导出</span>
                </a>
            </div>
            <form method="get" class="ui form flex-fluid">
                <div class="ui left action right input fluid">
                    <div class="ui button white dropdown ">
                        <input name="searchType" type="hidden">
                        <div class="text">请选中搜索内容</div>
                        <i class="dropdown icon"></i>
                        <div class="menu">
                            <div class="item" data-value="1">领料编号</div>
                            <div class="item" data-value="2">物料名称</div>
                            <div class="item" data-value="3">项目编号</div>
                            <div class="item" data-value="4">项目内容</div>
                            <div class="item" data-value="5">项目经理</div>
                            <div class="item" data-value="6">领料人</div>
                            <div class="item" data-value="7">出库仓库</div>
                        </div>
                    </div>
                    <input name="search" type="text" placeholder="搜索内容" value="">
                    <button class="ui button">搜索</button>
                </div>
            </form>
        </div>
        <!-- / 操作区域 -->

        <div class="content-wrap table-head-nowrap">
            <table class="ui center aligned table selectable unstackable">
                <thead>
                <tr>
                    <th>领料编号</th>
                    <th>出库仓库</th>
                    <th>物料名称</th>
                    <th>性能与技术参数</th>
                    <th>型号</th>
                    <th>生产厂家</th>
                    <th>单位</th>
                    <th>库存均价</th>
                    <th>领料数量</th>
                    <th>领料金额</th>
                    <th>项目编号</th>
                    <th>项目内容</th>
                    <th>项目经理</th>
                    <th>领料人</th>
                </tr>
                </thead>
                <tbody>
                @foreach($lists as $list)
                <tr>
                    <td>
                        <a href="javascript:_helper.fullWindow('{{url('stock/get/print')}}?id={{$list->record->id}}')">{{$list->record->number}}</a>
                    </td>
                    <td>{{$list->record->warehouse}}</td>
                    <td>{{$list->material->name}}</td>
                    <td>{{$list->material->param}}</td>
                    <td>{{$list->material->model}}</td>
                    <td>{{$list->material->factory}}</td>
                    <td>{{$list->material->unit}}</td>
                    <td>￥{{number_format($list->price,2)}} </td>
                    <td>{{$list->sum}}</td>
                    <td>￥{{number_format($list->cost,2)}} </td>
                    <td>{{$list->record->project_number}}</td>
                    <td class="table-content" title="{{$list->project->name}}">{{$list->project->name}}</td>
                    <td>{{$list->project->pm}}</td>
                    <td>{{$list->record->worker}}</td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        {{$lists->links()}}
    </div>
    <!-- /主体内容 === 不可复用 -->
@endsection
@section('pageJs')
    <script src="{{url('js/stock_get_list.js')}}"></script>
@endsection