@extends('layouts.main_no_nav')
@section('title','已立项清单')
@section('content')
    <!-- 没有导航的单独窗口页面 -->
    <div class="normal-content print-no-padding">

        <div class="ui breadcrumb">
            <a class="section">费用付款管理</a>
            <div class="divider"> / </div>
            <a class="section" >付款审批清单</a>
            <div class="divider"> / </div>
            <div class="active section">付款审批查询 - {{$apply->number}}</div>
        </div>
        <input type="hidden" id="payId" value="{{$apply->id}}">

        <h3 class="ui header center aligned">付款审批查询 -  {{$apply->number}}</h3>
        <table class="ui celled center aligned table unstackable">
            <thead>
            <tr>
                <th>付款编号</th>
                <th class="fake-td"> {{$apply->number}}</th>
                <th>付款金额</th>
                <th class="fake-td" colspan="2"> {{number_format($apply->price,2)}}￥</th>
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

        <div class="flex-row flex-center margin-top-50" id="paySingleBtn">
            @if($apply->state!=3)
            <button class="ui icon button negative" id="paySingleCancel" style="margin:0 20px;">
                <i class="icon delete"></i>
                <span>撤销</span>
            </button>
            @else
            @endif
            @if(checkRole('pay_pass',$apply->id)&&$apply->state==1)
            <button class="ui  icon button primary" id="paySingleCheck" style="margin:0 20px;">
                <i class="icon edit"></i>
                <span>审批</span>
            </button>
            @else
                @endif
            @if($apply->state==2)
            <a class="ui icon button primary" href="javascript:_helper.fullWindow('{{url('pay/pay')}}?id={{$apply->id}}')" style="margin:0 20px;">
                <i class="icon yen"></i>
                <span>付款</span>
            </a>
            @else
                @endif
            <a class="ui icon button positive" href="javascript:_helper.fullWindow('{{url('pay/print')}}?id={{$apply->id}}')" style="margin:0 20px;">
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