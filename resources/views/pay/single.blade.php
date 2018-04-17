@extends('layouts.main_no_nav')
@section('title','已立项清单')
@section('content')
    <!-- 没有导航的单独窗口页面 -->
    <div class="normal-content print-no-padding">

        <div class="ui breadcrumb">
            <a class="section">费用付款管理</a>
            <div class="divider"> / </div>
            <a class="section" href="../pay/list.html">付款审批清单</a>
            <div class="divider"> / </div>
            <div class="active section">付款审批查询 - {{$apply->number}}</div>
        </div>

        <h3 class="ui header center aligned">付款审批查询 -  {{$apply->number}}</h3>
        <table class="ui celled center aligned table unstackable">
            <thead>
            <tr>
                <th>付款编号</th>
                <th class="fake-td"> {{$apply->number}}</th>
                <th>付款金额</th>
                <th class="fake-td" colspan="2"> {{$apply->price}}￥</th>
            </tr>
            <tr>
                <th>用途</th>
                <th colspan="4" class="fake-td">{{$apply->use}}</th>
            </tr>
            <tr>
                <th>项目编号</th>
                <th class="fake-td">{{$apply->project_number}}</th>
                <th>项目内容</th>
                <th colspan="2" class="fake-td">{{$apply->project_content}}</th>
            </tr>
            <tr>
                <th>申请人</th>
                <th class="fake-td">{{$apply->proposer}}</th>
                <th>审批人</th>
                <th class="fake-td" colspan="2">{{$apply->approver}}</th>
            </tr>
            <tr>
                <th colspan="5">付款信息</th>
            </tr>
            <tr>
                <th>付款日期</th>
                <th class="fake-td">{{$apply->pay_date}}</th>
                <th>付款金额</th>
                <th colspan="2" class="fake-td">{{$apply->cash+$apply->transfer+$apply->other}}￥</th>
            </tr>
            <tr>
                <th colspan="5">付款方式</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>1</td>
                <td>现金</td>
                <td colspan="3">{{$apply->cash}}￥</td>
            </tr>
            <tr>
                <td>2</td>
                <td>转账</td>
                <td>{{$apply->transfer}}￥</td>
                <td>银行及账号</td>
                <td>{{$apply->bank}} {{$apply->account}}</td>
            </tr>
            <tr>
                <td>3</td>
                <td>其他</td>
                <td colspan="3">{{$apply->other}}</td>
            </tr>
            </tbody>
            <tfoot>
            <tr>
                <th>备注</th>
                <th class="fake-td" colspan="4">{{$apply->remark}}</th>
            </tr>
            <tr>
                <th>付款经办人</th>
                <th class="fake-td" colspan="4">{{$apply->manager}}</th>
            </tr>
            </tfoot>
        </table>

        <div class="flex-row flex-center margin-top-50" id="paySingleBtn">
            <button class="ui icon button negative" id="paySingleCancel" style="margin:0 20px;">
                <i class="icon delete"></i>
                <span>撤销</span>
            </button>
            <button class="ui icon button primary" id="paySingleCheck" style="margin:0 20px;">
                <i class="icon edit"></i>
                <span>审批</span>
            </button>
            <a class="ui icon button primary" href="javascript:_helper.fullWindow('{{url('pay/pay')}}?id={{$apply->id}}')" style="margin:0 20px;">
                <i class="icon yen"></i>
                <span>付款</span>
            </a>
            <a class="ui icon button positive" href="javascript:_helper.fullWindow('../pay/print.html?id=1')" style="margin:0 20px;">
                <i class="icon print"></i>
                <span>凭证</span>
            </a>
        </div>


    </div>
    <!-- /主体内容 === 不可复用 -->
@endsection
@section('pageJs')
    <script src="{{url('js/pay_single.js')}}"></script>
@endsection