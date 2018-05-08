@extends('layouts.main')
@section('title','已立项清单')
@section('content')
    <!-- 主体内容 === 不可复用 -->
    <div class="index-content print-no-padding">

        <div class="ui breadcrumb">
            <a class="section">库存管理</a>
            <div class="divider"> / </div>
            <div class="active section">采购收货入库清单</div>
        </div>

        <!-- 操作区域 -->
        <div class="content-operation">

            <form action="" class="ui form">
                <div class="inline fields" style="justify-content:flex-end;">
                    <label>系统状态：</label>
                    <div class="field">
                        <div class="ui radio checkbox">
                            <input type="radio" name="system" value="1">
                            <label>已结清</label>
                        </div>
                    </div>
                    <div class="field">
                        <div class="ui radio checkbox">
                            <input type="radio" name="system" value="0">
                            <label>未结清</label>
                        </div>
                    </div>
                </div>
                <div class="flex-row flex-between flex-wrap">
                    <div>
                        <a class="ui green button" href="#">
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
                                <div class="item" data-value="1">采购编号</div>
                                <div class="item" data-value="2">供货商</div>
                                <div class="item" data-value="3">项目编号</div>
                                <div class="item" data-value="4">项目内容</div>
                                <div class="item" data-value="5">项目经理</div>
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
                    <th>采购编号</th>
                    <th>供货商</th>
                    <th>采购金额</th>
                    <th>项目编号</th>
                    <th>项目内容</th>
                    <th>项目经理</th>
                    <th>已收货</th>
                    <th>未收货</th>
                    <th>系统状态</th>
                </tr>
                </thead>
                <tbody>
                @foreach($lists as $list)
                <tr>
                    <td>
                        <a href="javascript:_helper.fullWindow('{{url('store/buy_check')}}?id={{$list->id}}')">{{$list->number}}</a>
                    </td>
                    <td>{{$list->supplier}}</td>
                    <td>{{$list->lists()->sum('cost')}} ￥</td>
                    <td>{{\App\Models\Project::find($list->project_id)->number}}</td>
                    <td class="table-content">{{\App\Models\Project::find($list->project_id)->name}}</td>
                    <td>{{\App\Models\Project::find($list->project_id)->pm}}</td>
                    <td>{{$list->lists()->pluck('price')->first() * $list->lists()->sum('received')}} ￥</td>
                    <td>{{$list->lists()->pluck('price')->first() * $list->lists()->sum('need')}} ￥</td>
                    <td>{{$list->lists()->sum('need')==0?'已结清':'未结清'}}</td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>

    </div>
    <!-- /主体内容 === 不可复用 -->
@endsection
@section('pageJs')
    <script src="{{url('js/stock_buy_list.js')}}"></script>
@endsection