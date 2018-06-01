@extends('layouts.main_no_nav')
@section('title','已立项清单')
@section('content')
    <!-- 没有导航的单独窗口页面 -->
    <div class="normal-content print-no-padding">

        <div class="ui breadcrumb print-hide">
            <a class="section">报销与借款管理</a>
            <div class="divider"> / </div>
            <a class="section" href="../loan/loan_list.html">借款清单</a>
            <div class="divider"> / </div>
            <div class="active section">凭证 - {{$loan->number}}</div>
        </div>

        <h1 class="ui header center aligned">借款记帐凭证</h1>
        {{--<p style="text-align:right;font-size: 13px;padding-right:20px;"><b>记账凭证号：</b>1231231231232</p>--}}
        <table class="ui celled structured center aligned table">
            <thead>
            <tr>
                <th rowspan="3">借款信息</th>
                <th>借款申请日期</th>
                <th class="fake-td">{{$loan->apply_date}}</th>
                <th>借款金额</th>
                <th class="fake-td">{{number_format($loan->price,2)}}￥</th>
                <th>借款编号</th>
                <th class="fake-td">{{$loan->number}}</th>
            </tr>
            <tr>
                <th>借款原因</th>
                <th colspan="5" class="fake-td">{{$loan->reason}}</th>
            </tr>
            <tr>
                <th>借款人</th>
                <th colspan="2" class="fake-td">{{$loan->borrower}}</th>
                <th>审批人</th>
                <th colspan="2" class="fake-td">{{$loan->approver}}</th>
            </tr>
            <tr>
                <th rowspan="4">实际付款信息</th>
                <th>付款日期</th>
                <th colspan="2" class="fake-td">{{$loan->pay_date}}</th>
                <th>付款方式</th>
                <th colspan="2" class="fake-td">{{$loan->pay_type==1?'现金':'转账'}}</th>
            </tr>
            <tr>
                <th>银行及账户</th>
                <th colspan="5" class="fake-td">{{$loan->bank}} {{$loan->account}}</th>
            </tr>
            <tr>
                <th>付款经办人</th>
                <th colspan="5" class="fake-td">{{$loan->manager}}</th>
            </tr>
            <tr>
                <th>领款人签名</th>
                <th colspan="5"></th>
            </tr>
            </thead>
        </table>
        <div class="content-operation print-hide">
            <div class="flex-row flex-end">
                <a class="ui icon button primary" href="javascript:window.print();">
                    <i class="icon print"></i>
                    <span>打印</span>
                </a>
            </div>
        </div>

    </div>
    <!-- /主体内容 === 不可复用 -->
@endsection
@section('pageJs')
    {{--<script src="{{url('js/project_list.js')}}"></script>--}}
@endsection