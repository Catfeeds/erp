@extends('layouts.main')
@section('title','已立项清单')
@section('content')
    <!-- 主体内容 === 不可复用 -->
    <div class="index-content print-no-padding">

        <div class="ui breadcrumb">
            <a class="section">报销与借款管理</a>
            <div class="divider"> / </div>
            <div class="active section">借款清单</div>
        </div>

        <!-- 操作区域 -->
        <div class="content-operation">
            <a class="ui primary button" href="javascript:_helper.fullWindow('../loan/loan_add.html')">
                <i class="icon plus"></i>
                <span>新增借款申请</span>
            </a>
        </div>
        <!-- / 操作区域 -->

        <div class="content-wrap table-head-nowrap">
            <table class="ui center aligned table selectable unstackable">
                <thead>
                <tr>
                    <th>借款编号</th>
                    <th>借款金额</th>
                    <th>借款原因</th>
                    <th>借款人</th>
                    <th>审批人</th>
                    <th>付款日期</th>
                    <th>付款方式</th>
                    <th>银行及账号</th>
                    <th>付款经办人</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($lists as $list)
                <tr>
                    <td>{{$list->number}}</td>
                    <td>{{$list->price}}￥</td>
                    <td style="max-width:300px">{{$list->reason}}</td>
                    <td>{{$list->borrower}}</td>
                    @if($list->approver==0)
                    <td>未审批</td>
                    @else
                        <td>{{\App\User::find($list->approver)->name}}</td>
                    @endif
                    @if(!$list->pay_date)
                    <td colspan="4">暂无数据</td>
                    @else
                        <td>{{$list->pay_date}}</td>
                        <td>{{$list->pay_type==1?'现金':'转账'}}</td>
                        <td>{{$list->bank}} {{$list->account}}</td>
                        <td>{{$list->manager}}</td>
                        @endif
                    <td style="white-space:nowrap;">
                        <button class="ui mini button negative loanLoanListCancel">撤销</button>
                        <button class="ui mini button positive loanLoanListCheck">审批</button>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>

    </div>
    <!-- /主体内容 === 不可复用 -->
@endsection
@section('pageJs')
    <script src="{{url('js/loan_loan_list.js')}}"></script>
@endsection