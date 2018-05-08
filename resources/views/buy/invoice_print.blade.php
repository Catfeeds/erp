@extends('layouts.main')
@section('title','已立项清单')
@section('content')
    <!-- 没有导航的单独窗口页面 -->
    <div class="normal-content print-no-padding">

        <div class="ui breadcrumb print-hide">
            <a class="section">采购管理</a>
            <div class="divider"> / </div>
            <a class="section" href="../buy/charge_list.html">采购收票清单</a>
            <div class="divider"> / </div>
            <a class="section" href="../buy/invoice_list.html?id=CG12512312521">采购收票查询 - {{$purchase->number}}</a>
            <div class="divider"> / </div>
            <div class="active section">凭证</div>
        </div>

        <h1 class="ui header center aligned">采购收票记账凭证</h1>
        <p style="text-align:right;font-size: 13px;padding-right:25px;">记账凭证号：</p>
        <p style="text-align:right;font-size: 13px;padding-right:25px;">附件：
            <span style="margin-right:60px;"></span> 张</p>
        <table class="ui celled center aligned table selectable">
            <thead>
            <tr>
                <th class="bg-white">采购编号</th>
                <th class="font-normal bg-white" colspan="4">{{$purchase->number}}</th>
                <th class="bg-white">采购日期</th>
                <th class="font-normal bg-white" colspan="3">{{$purchase->date}}</th>
            </tr>
            <tr>
                <th class="bg-white">供货商名称</th>
                <th class="font-normal bg-white" colspan="4">{{$purchase->supplier}}</th>
                <th class="bg-white">发票条件</th>
                <th class="font-normal bg-white" colspan="3">{{$purchase->content}}</th>
            </tr>
            <tr>
                <th class="bg-white">项目编号</th>
                <th class="font-normal bg-white" colspan="2">{{\App\Models\Project::find($purchase->project_id)->number}}</th>
                <th class="bg-white">项目内容</th>
                <th class="font-normal bg-white" colspan="2">{{\App\Models\Project::find($purchase->project_id)->name}}</th>
                <th class="bg-white">项目经理</th>
                <th class="font-normal bg-white" colspan="2">{{\App\Models\Project::find($purchase->project_id)->pm}}</th>
            </tr>
            <tr>
                <th class="bg-white">采购金额</th>
                <th class="font-normal bg-white" colspan="4">{{number_format($purchase->lists()->sum('cost'))}} ￥</th>
                <th class="bg-white">未收票</th>
                <th class="font-normal bg-white" colspan="3">{{number_format($purchase->lists()->sum('cost')-$purchase->invoices()->sum('with_tax'))}} ￥</th>
            </tr>
            <tr>
                <th colspan="9">收票记录</th>
            </tr>
            <tr>
                <th></th>
                <th>收票日期</th>
                <th>开票日期</th>
                <th>发票号码</th>
                <th>发票类型</th>
                <th>不含税金额</th>
                <th>税额</th>
                <th>含税金额</th>
                <th>收票经办人</th>
            </tr>
            </thead>
            <tbody>
            @for($i=0;$i<count($invoices);$i++)
                <tr>
                    <td>{{$i+1}}</td>
                    <td>{{$invoices[$i]->date}}</td>
                    <td>{{$invoices[$i]->invoice_date}}</td>
                    <td>{{$invoices[$i]->number}}</td>
                    <td>{{\App\Models\Invoice::find($invoices[$i]->type)->name}}</td>
                    <td>{{$invoices[$i]->without_tax}} ￥</td>
                    <td>{{$invoices[$i]->tax}} ￥</td>
                    <td>{{$invoices[$i]->with_tax}}￥</td>
                    <td>{{\App\User::find($invoices[$i]->worker)->name}}</td>
                </tr>
            @endfor

            </tbody>
            <tfoot>
            <tr>
                <th colspan="5">合计</th>
                <th>{{number_format($purchase->invoices()->sum('without_tax'))}} ￥</th>
                <th>{{number_format($purchase->invoices()->sum('tax'))}} ￥</th>
                <th>{{number_format($purchase->invoices()->sum('with_tax'))}} ￥</th>
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