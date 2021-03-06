@extends('layouts.main')
@section('title','供应商列表')
@section('content')

    <!-- 主体内容 === 不可复用 -->
    <div class="index-content print-no-padding">

        <div class="ui breadcrumb">
            <a class="section">数据维护</a>
            <div class="divider"> / </div>
            <div class="active section">供应商列表</div>
        </div>

        <!-- 操作区域 -->
        <div class="content-operation">

            <form action="" class="ui form">
                <div class="flex-row flex-between">
                    <div>
                        <a class="ui primary button" href="javascript:_helper.fullWindow('{{url('supplier/create')}}')">
                            <i class="icon plus"></i>
                            <span>新增供应商</span>
                        </a>
                        <a class="ui green button" href="{{url('export/supplier')}}">
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
                                <div class="item" data-value="1">供应商名称</div>
                                <div class="item" data-value="2">银行名称</div>
                                <div class="item" data-value="3">银行账号</div>
                            </div>
                        </div>
                        <input name="name" type="text" placeholder="搜索内容" value="">
                        <button class="ui button">搜索</button>
                    </div>
                </div>
            </form>
        </div>
        <!-- / 操作区域 -->

        <div class="content-wrap">

            <table class="ui center aligned table selectable">
                <thead>
                <tr>
                    <th>供应商名称</th>
                    <th>收款银行</th>
                    <th>收款账号</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($suppliers as $supplier)
                <tr>
                    <td>{{$supplier->name}}</td>
                    <td>{{$supplier->bank}}</td>
                    <td>{{$supplier->account}}</td>
                    <td>
                        <a class="ui mini button primary" href="javascript:_helper.fullWindow('{{url('supplier/create')}}?id={{$supplier->id}}')">修改</a>
                        <button class="ui mini button negative dataSupplierDelete" data-id="{{$supplier->id}}">删除</button>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        {{$suppliers->appends(['name'=>$name,'search-type'=>$type])->links()}}
    </div>
    <!-- /主体内容 === 不可复用 -->
@endsection
@section('pageJs')
    <script src="{{url('js/data_supplier_list.js')}}"></script>
@endsection