@extends('layouts.main')
@section('title','物料列表')
@section('content')
    <!-- 主体内容 === 不可复用 -->
    <div class="index-content print-no-padding">

        <div class="ui breadcrumb">
            <a class="section">数据维护</a>
            <div class="divider"> / </div>
            <div class="active section">物料列表</div>
        </div>

        <!-- 操作区域 -->
        <div class="content-operation">

            <form action="" class="ui form">
                <div class="flex-row flex-between flex-wrap">
                    <div>
                        <a class="ui primary button" href="javascript:_helper.fullWindow('{{url('material/create')}}')">
                            <i class="icon plus"></i>
                            <span>新增物料</span>
                        </a>
                        <a class="ui green button" href="{{url('export/material')}}">
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
                                <div class="item" data-value="2">物料名称</div>
                                <div class="item" data-value="3">品牌型号</div>
                                <div class="item" data-value="4">生产厂家</div>
                            </div>
                        </div>
                        <input name="value" type="text" placeholder="搜索内容" value="">
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
                    <th>物料名称</th>
                    <th style="min-width:300px;">性能与技术参数</th>
                    <th>品牌型号</th>
                    <th>生产厂家</th>
                    <th>单位</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($materials as $material)
                <tr>
                    <td>{{$material->name}}</td>
                    <td style="max-width: 300px;">{{$material->param}}</td>
                    <td>{{$material->model}}</td>
                    <td>{{$material->factory}}</td>
                    <td>{{$material->unit}}</td>
                    <td style="white-space:nowrap;">
                        <a class="ui mini button primary" href="javascript:_helper.fullWindow('{{url('material/create')}}?id={{$material->id}}')">修改</a>
                        <button class="ui mini button negative dataMaterialDelete" data-id="{{$material->id}}">删除</button>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
            {{ $materials->links() }}
        </div>

    </div>
    <!-- /主体内容 === 不可复用 -->
@endsection
@section('pageJs')
    <script src="{{url('js/data_material_list.js')}}"></script>
@endsection