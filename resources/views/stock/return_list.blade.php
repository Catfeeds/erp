@extends('layouts.main')
@section('title','已立项清单')
@section('content')
    <!-- 主体内容 === 不可复用 -->
    <div class="index-content print-no-padding">

        <div class="ui breadcrumb">
            <a class="section">库存管理</a>
            <div class="divider"> / </div>
            <div class="active section">退料入货清单</div>
        </div>

        <!-- 操作区域 -->
        <div class="content-operation flex-row flex-between flex-wrap">
            <div>
                <a href="javascript:_helper.fullWindow('{{url('stock/return/add')}}')" class="ui primary button">
                    <i class="icon plus"></i>
                    <span>新增退料入库</span>
                </a>
                <a href="{{url('export/stock/return/list')}}" class="ui positive button">
                    <i class="icon print"></i>
                    <span>导出</span>
                </a>
            </div>
            <form method="get" class="ui form flex-fluid">
                <div class="ui left action right input fluid">
                    <div class="ui button white dropdown ">
                        <input name="seartch-type" type="hidden">
                        <div class="text">请选中搜索内容</div>
                        <i class="dropdown icon"></i>
                        <div class="menu">
                            <div class="item" data-value="1">退料编号</div>
                            <div class="item" data-value="2">物料名称</div>
                            <div class="item" data-value="3">项目编号</div>
                            <div class="item" data-value="4">项目内容</div>
                            <div class="item" data-value="5">项目经理</div>
                            <div class="item" data-value="6">退料人</div>
                            <div class="item" data-value="7">仓库</div>
                        </div>
                    </div>
                    <input name="value" type="text" placeholder="搜索内容" value="">
                    <button class="ui button">搜索</button>
                </div>
            </form>
        </div>
        <!-- / 操作区域 -->

        <div class="content-wrap table-head-nowrap">
            <table class="ui center aligned table selectable unstackable">
                <thead>
                <tr>
                    <th>退料编号</th>
                    <th>物料名称</th>
                    <th>性能与技术参数</th>
                    <th>型号</th>
                    <th>生产厂家</th>
                    <th>单位</th>
                    <th>退料数量</th>
                    <th>退料单价</th>
                    <th>退料金额</th>
                    <th>项目编号</th>
                    <th>项目内容</th>
                    <th>项目经理</th>
                    <th>退料人</th>
                    <th>入库仓库</th>
                    <th>收货人</th>
                </tr>
                </thead>
                <tbody>
                @foreach($lists as $list)
                <tr>
                    <td>
                        <a href="javascript:_helper.fullWindow('{{url('stock/return/print')}}?id={{$list->record->id}}')">{{$list->record->number}}</a>
                    </td>
                    <td>{{$list->material->name}}</td>
                    <td>{{$list->material->param}}</td>
                    <td>{{$list->material->model}}</td>
                    <td>{{$list->material->factory}}</td>
                    <td>{{$list->material->unit}}</td>
                    <td>{{$list->sum}}</td>
                    <td>{{number_format($list->price,2)}} ￥</td>
                    <td>{{number_format($list->cost,2)}} ￥</td>
                    <td>{{$list->record->project_number}}</td>
                    <td>{{$list->record->project_content}}</td>
                    <td>{{$list->record->project_manager}}</td>
                    <td>{{$list->record->worker}}</td>
                    <td>{{$list->record->warehouse}}</td>
                    <td>{{$list->record->returnee}}</td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>


    </div>
@endsection
@section('pageJs')
    <script src="{{url('js/stock_return_list.js')}}"></script>
@endsection