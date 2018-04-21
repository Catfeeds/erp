@extends('layouts.main_no_nav')
@section('title','已立项清单')
@section('content')
    <!-- 没有导航的单独窗口页面 -->
    <div class="normal-content print-no-padding">

        <div class="ui breadcrumb">
            <a class="section">采购管理</a>
            <div class="divider"> / </div>
            <a class="section" href="../buy/pay_list.html">采购付款清单</a>
            <div class="divider"> / </div>
            <div class="active section">采购付款查询 - {{$purchase->number}}</div>
        </div>

        <h3 class="ui header center aligned">采购付款查询</h3>
        <div class="table-head-nowrap">
            <table class="ui celled center aligned table selectable unstackable">
                <thead>
                <tr>
                    <th class="bg-white">采购编号</th>
                    <th class="font-normal bg-white" colspan="3">{{$purchase->number}}</th>
                    <th class="bg-white">采购日期</th>
                    <th class="font-normal bg-white" colspan="7">{{$purchase->date}}</th>
                </tr>
                <tr>
                    <th class="bg-white">供货商名称</th>
                    <th class="font-normal bg-white" colspan="3">{{$purchase->supplier}}</th>
                    <th class="bg-white">供应商收款银行</th>
                    <th class="font-normal bg-white" colspan="4">{{$purchase->bank}}</th>
                    <th class="bg-white">供货商收款账号</th>
                    <th class="font-normal bg-white" colspan="2">{{$purchase->account}}</th>
                </tr>
                <tr>
                    <th class="bg-white">项目编号</th>
                    <th class="font-normal bg-white" colspan="3">{{\App\Models\Project::find($purchase->project_id)->number}}</th>
                    <th class="bg-white">项目内容</th>
                    <th class="font-normal bg-white" colspan="4">{{\App\Models\Project::find($purchase->project_id)->name}}</th>
                    <th class="bg-white">项目经理</th>
                    <th class="font-normal bg-white" colspan="2">{{\App\Models\Project::find($purchase->project_id)->pm}}</th>
                </tr>
                <tr>
                    <th class="bg-white">付款条件</th>
                    <th class="font-normal bg-white" colspan="11">这是付款条件xxx</th>
                </tr>
                <tr>
                    <th class="bg-white">采购金额</th>
                    <th class="font-normal bg-white" colspan="3">1,000,000 ￥</th>
                    <th class="bg-white">应付账款余额</th>
                    <th class="font-normal bg-white" colspan="7">50,231 ￥</th>
                </tr>
                <tr>
                    <th colspan="12">付款记录</th>
                </tr>
                <tr>
                    <th></th>
                    <th colspan="4">付款申请</th>
                    <th colspan="6">实际付款</th>
                    <th>操作</th>
                </tr>
                <tr>
                    <th></th>
                    <th>付款申请日期</th>
                    <th>付款申请金额</th>
                    <th>申请人</th>
                    <th>复核人</th>
                    <th>实际付款日期</th>
                    <th>实际付款金额</th>
                    <th>付款银行</th>
                    <th>付款账号</th>
                    <th>备注</th>
                    <th>付款经办人</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($lists as $list)
                <tr>
                    <td>{{$list->id}}</td>
                    <td>{{$list->date}}</td>
                    <td>{{$list->price}} ￥</td>
                    <td>{{\App\User::find($list->apply_id)->username}}</td>
                    <td>{{$list->check==0?'':\App\User::find($list->check)->name}}</td>
                    @if($list->worker_id==0)
                    <td colspan="6">暂无数据</td>
                    @else
                        <td>{{$list->pay_date}}</td>
                        <td>{{$list->pay_price}} ￥</td>
                        <td>{{\App\Models\BankAccount::find($list->bank_id)->name}}</td>
                        <td>{{\App\Models\BankAccount::find($list->bank_id)->account}}</td>
                        <td class="table-content">{{$list->remark}}</td>
                        <td>{{$list->worker}}</td>
                    @endif
                    <td style="white-space:nowrap;">
                        <a class="ui mini button" href="javascript:_helper.fullWindow('{{url('buy/edit/payment')}}?id={{$list->id}}')" title="修改付款申请">修改</a>
                        <a class="ui mini positive button" href="#" data-id="{{$list->id}}" title="复核">复核</a>
                        <a class="ui mini primary button" href="javascript:_helper.fullWindow('{{url('purchase/payment/finish')}}?id={{$list->id}}')" title="录入/修改实际付款">录入</a>
                    </td>
                    @endforeach
                </tr>
                </tbody>
                <tfoot>
                <tr>
                    <th colspan="2">合计</th>
                    <th>{{$purchase->payments()->sum('price')}} ￥</th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th>{{$purchase->payments()->sum('pay_price')}}  ￥</th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
                </tfoot>
            </table>
        </div>
        <div class="flex-row flex-center margin-top-50">
            <a class="ui icon button primary" href="javascript:_helper.fullWindow('{{url('buy/payment/create')}}?purchase_id={{$purchase->id}}')" style="margin:0 10px;">
                <i class="icon yen"></i>
                <span>付款申请</span>
            </a>
            <a class="ui icon button positive" href="javascript:_helper.fullWindow('../buy/payment_print.html')" style="margin:0 10px;">
                <i class="icon print"></i>
                <span>凭证</span>
            </a>
        </div>

    </div>
    <!-- /主体内容 === 不可复用 -->
@endsection
@section('pageJs')
    <script src="{{url('js/buy_payment_list.js')}}"></script>
@endsection