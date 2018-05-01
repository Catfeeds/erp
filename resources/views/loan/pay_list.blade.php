@extends('layouts.main')
@section('title','已立项清单')
@section('content')
    <!-- 主体内容 === 不可复用 -->
    <div class="index-content print-no-padding">

        <div class="ui breadcrumb">
            <a class="section">报销与借款管理</a>
            <div class="divider"> / </div>
            <div class="active section">报销付款清单</div>
        </div>

        <!-- 操作区域 -->
        <div class="content-operation flex-row flex-between flex-wrap">
            <div>
                <a class="ui primary button" href="javascript:_helper.fullWindow('{{url('loan/pay/add')}}')">
                    <i class="icon plus"></i>
                    <span>新增报销付款</span>
                </a>
                <a href="{{url('export/loan/pay/list')}}" class="ui positive button">
                    <i class="icon print"></i>
                    <span>导出</span>
                </a>
            </div>
            <form action="/views/buy/project_list.html" class="ui form flex-fluid">
                <div class="ui left action right input fluid">
                    <div class="ui button white dropdown ">
                        <input name="seartch-type" type="hidden">
                        <div class="text">请选中搜索内容</div>
                        <i class="dropdown icon"></i>
                        <div class="menu">
                            <div class="item" data-value="1">付款编号</div>
                            <div class="item" data-value="2">报销人</div>
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
                    <th>报销付款编号</th>
                    <th>报销人</th>
                    <th>付款金额</th>
                    <th>借款抵扣</th>
                    <th>现金付款</th>
                    <th>银行转账</th>
                    <th>付款银行及账号</th>
                    <th>报销编号</th>
                    <th>经办人</th>
                </tr>
                </thead>
                <tbody>
                @foreach($lists as $list)
                <tr>
                    <td>
                        <a href="javascript:_helper.fullWindow('../loan/pay_single.html?id=1')">{{$list->number}}</a>
                    </td>
                    <td>{{$list->applier}}</td>
                    <td>{{$list->price}}￥</td>
                    <td>{{$list->deduction}}￥</td>
                    <td>{{$list->cash}}￥</td>
                    <td>{{$list->transfer}}￥</td>
                    <td>{{$list->bank}} {{$list->account}}</td>
                    <td>{{$list->BXNumber}}</td>
                    <td>{{\App\User::find($list->worker)->username}}</td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>

    </div>
    <!-- /主体内容 === 不可复用 -->
@endsection
@section('pageJs')
    <script src="{{url('js/loan_pay_list.js')}}"></script>
@endsection