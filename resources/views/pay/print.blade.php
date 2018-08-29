@extends('layouts.main_no_nav')
@section('title','已立项清单')
@section('content')
    <!-- 没有导航的单独窗口页面 -->
    <div class="normal-content print-no-padding">

        <div class="ui breadcrumb print-hide">
            <a class="section">费用付款管理</a>
            <div class="divider"> / </div>
            <a class="section" href="../pay/list.html">付款审批清单</a>
            <div class="divider"> / </div>
            <a class="section" href="../pay/single.html?id=FK20171103001">付款审批查询 - {{$apply->number}}</a>
            <div class="divider"> / </div>
            <div class="active section">凭证</div>
        </div>

        <h1 class="ui header center aligned">付款审批单</h1>
        <p style="text-align:right;font-size: 13px;padding-right:20px;">
            {{--<b>记账凭证号：</b>123123123123213</p>--}}
        <p style="text-align:right;font-size: 13px;padding-right:20px;">
            <b>附件：</b>
            <span style="padding:0 20px;"></span>
            <b>张</b>
        </p>
        <table class="ui celled structured center aligned table">
            <thead>
            <tr>
                <th>付款编号</th>
                <th class="fake-td">{{$apply->number}}</th>
                <th>付款金额</th>
                <th class="fake-td" colspan="2">{{number_format($apply->price,2)}}￥</th>
            </tr>
            <tr>
                <th>用途</th>
                <th colspan="4" class="fake-td">{{$apply->use}}</th>
            </tr>
            <tr>
                <th>项目编号</th>
                <th class="fake-td">{{$apply->project_id==0?'':\App\Models\Project::find($apply->project_id)->number}}</th>
                <th>项目内容</th>
                <th colspan="2" class="fake-td">{{$apply->project_id==0?'':\App\Models\Project::find($apply->project_id)->name}}</th>
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
                <th colspan="2" class="fake-td">{{number_format($apply->cash+$apply->transfer+$apply->other,2)}}￥</th>
            </tr>
            <tr>
                <th colspan="5">付款方式</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>1</td>
                <td>现金</td>
                <td colspan="3">{{number_format($apply->cash,2)}}￥</td>
            </tr>
            <tr>
                <td>2</td>
                <td>转账</td>
                <td>{{number_format($apply->transfer,2)}}￥</td>
                <td>银行及账号</td>
                <td>{{$apply->bank}} {{$apply->account}}</td>
            </tr>
            <tr>
                <td>3</td>
                <td>其他</td>
                <td colspan="3">{{number_format($apply->other,2)}}</td>
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