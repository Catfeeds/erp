@extends('layouts.main_no_nav')
@section('title','已立项清单')
@section('content')
    <!-- 没有导航的单独窗口页面 -->
    <div class="normal-content print-no-padding">

        <div class="ui breadcrumb print-hide">
            <a class="section">采购管理</a>
            <div class="divider"> / </div>
            <a class="section" href="../buy/pay_list.html">采购付款清单</a>
            <div class="divider"> / </div>
            <div class="active section">凭证</div>
        </div>

        <h1 class="ui header center aligned">采购付款记帐凭证</h1>
        <p style="text-align:right;font-size: 13px;padding-right:25px;">记账凭证号：</p>
        <p style="text-align:right;font-size: 13px;padding-right:25px;">附件：
            <span style="margin-right:60px;"></span> 张</p>
        <table class="ui celled center aligned table selectable">
            <thead>
            <tr>
                <th class="bg-white">采购编号</th>
                <th class="font-normal bg-white" colspan="3">{{$purchase->number}}</th>
                <th class="bg-white">采购日期</th>
                <th class="font-normal bg-white" colspan="6">{{$purchase->date}}</th>
            </tr>
            <tr>
                <th class="bg-white">供货商名称</th>
                <th class="font-normal bg-white" colspan="3">{{$purchase->supplier}}</th>
                <th class="bg-white">供应商收款银行</th>
                <th class="font-normal bg-white" colspan="3">{{$purchase->bank}}</th>
                <th class="bg-white">供货商收款账号</th>
                <th class="font-normal bg-white" colspan="3">{{$purchase->account}}</th>
            </tr>
            <tr>
                <th class="bg-white">项目编号</th>
                <th class="font-normal bg-white" colspan="3">{{$purchase->project_id==0?'':\App\Models\Project::find($purchase->project_id)->number}}</th>
                <th class="bg-white">项目内容</th>
                <th class="font-normal bg-white" colspan="3">{{$purchase->project_id==0?'':\App\Models\Project::find($purchase->project_id)->name}}</th>
                <th class="bg-white">项目经理</th>
                <th class="font-normal bg-white" colspan="3">{{$purchase->project_id==0?'':\App\Models\Project::find($purchase->project_id)->pm}}</th>
            </tr>
            <tr>
                <th class="bg-white">付款条件</th>
                <th class="font-normal bg-white" colspan="10">{{$purchase->condition}}</th>
            </tr>
            <tr>
                <th class="bg-white">采购金额</th>
                <th class="font-normal bg-white" colspan="3">{{number_format($purchase->lists()->sum('cost'))}} ￥</th>
                <th class="bg-white">应付账款余额</th>
                <th class="font-normal bg-white" colspan="6">{{number_format($purchase->lists()->sum('cost')-$purchase->payments()->sum('pay_price'))}} ￥</th>
            </tr>
            <tr>
                <th colspan="11">付款记录</th>
            </tr>
            <tr>
                <th></th>
                <th colspan="4">付款申请</th>
                <th colspan="6">实际付款</th>
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
            </tr>
            </thead>
            <tbody>
            @for($i=0;$i<count($lists);$i++)
                <tr>
                    <td>{{$i+1}}</td>
                    <td>{{$lists[$i]->date}}</td>
                    <td>{{number_format($lists[$i]->price)}} ￥</td>
                    <td>{{\App\User::find($lists[$i]->apply_id)->username}}</td>
                    <td>{{$lists[$i]->check==0?'':\App\User::find($lists[$i]->check)->name}}</td>
                    @if($lists[$i]->worker_id==0)
                        <td colspan="6">暂无数据</td>
                    @else
                        <td>{{$lists[$i]->pay_date}}</td>
                        <td>{{number_format($lists[$i]->pay_price)}} ￥</td>
                        <td>{{\App\Models\BankAccount::find($lists[$i]->bank_id)->name}}</td>
                        <td>{{\App\Models\BankAccount::find($lists[$i]->bank_id)->account}}</td>
                        <td class="table-content">{{$lists[$i]->remark}}</td>
                        <td>{{$lists[$i]->worker}}</td>
                    @endif


                </tr>
            @endfor
            </tbody>
            <tfoot>
            <tr>
                <th colspan="2">合计</th>
                <th>{{number_format($purchase->payments()->sum('price'))}} ￥</th>
                <th></th>
                <th></th>
                <th></th>
                <th>{{number_format($purchase->payments()->sum('pay_price'))}} ￥</th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
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
{{--    <script src="{{url('js/project_list.js')}}"></script>--}}
@endsection