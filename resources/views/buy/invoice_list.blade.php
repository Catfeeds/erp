@extends('layouts.main_no_nav')
@section('title','采购收票查询')
@section('content')
    <!-- 没有导航的单独窗口页面 -->
    <div class="normal-content print-no-padding">

        <div class="ui breadcrumb">
            <a class="section">采购管理</a>
            <div class="divider"> / </div>
            <a class="section" href="{{url('purchase/charge/list')}}" >采购收票清单</a>
            <div class="divider"> / </div>
            <div class="active section">采购收票查询 - {{$purchase->number}}</div>
        </div>


        <h3 class="ui header center aligned">采购收票查询</h3>
        <div class="table-head-nowrap">
            <table class="ui celled center aligned table selectable unstackable">
                <thead>
                <tr>
                    <th class="bg-white">采购编号</th>
                    <th class="font-normal bg-white" colspan="4">{{$purchase->number}}</th>
                    <th class="bg-white">采购日期</th>
                    <th class="font-normal bg-white" colspan="4">{{$purchase->date}}</th>
                </tr>
                <tr>
                    <th class="bg-white">供货商名称</th>
                    <th class="font-normal bg-white" colspan="4">{{$purchase->supplier}}</th>
                    <th class="bg-white">发票条件</th>
                    <th class="font-normal bg-white" colspan="4">{{$purchase->content}}</th>
                </tr>
                <tr>
                    <th class="bg-white">项目编号</th>
                    <th class="font-normal bg-white" colspan="2">{{$purchase->project_id==0?"":\App\Models\Project::find($purchase->project_id)->number}}</th>
                    <th class="bg-white">项目内容</th>
                    <th class="font-normal bg-white" colspan="3">{{$purchase->project_id==0?"":\App\Models\Project::find($purchase->project_id)->name}}</th>
                    <th class="bg-white">项目经理</th>
                    <th class="font-normal bg-white" colspan="2">{{$purchase->project_id==0?"":\App\Models\Project::find($purchase->project_id)->pm}}</th>
                </tr>
                <tr>
                    <th class="bg-white">采购金额</th>
                    <th class="font-normal bg-white" colspan="4">{{number_format($purchase->lists()->sum('cost'),2)}} ￥</th>
                    <th class="bg-white">未收票</th>
                    <th class="font-normal bg-white" colspan="4">{{number_format($purchase->lists()->sum('cost')-$purchase->invoices()->sum('with_tax'),2)}} ￥</th>
                </tr>
                <tr>
                    <th colspan="10">收票记录</th>
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
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @for($i=0;$i<count($invoices);$i++)
                    {{--{{dd($invoices)}}--}}
{{--                @foreach($purchase->invoices as $invoice)--}}
                <tr>
                    <td>{{$i+1}}</td>
                    <td>{{$invoices[$i]->date}}</td>
                    <td>{{$invoices[$i]->invoice_date}}</td>
                    <td>{{$invoices[$i]->number}}</td>
                    <td>{{is_numeric($invoices[$i]->type)?\App\Models\Invoice::find($invoices[$i]->type)->name:''}}</td>
                    <td>{{number_format($invoices[$i]->without_tax,2)}} ￥</td>
                    <td>{{number_format($invoices[$i]->tax,2)}} ￥</td>
                    <td>{{number_format($invoices[$i]->with_tax,2)}}￥</td>
                    <td>{{\App\User::find($invoices[$i]->worker)->name}}</td>
                    <td style="white-space:nowrap">
                        <a class="ui mini button" href="javascript:_helper.fullWindow('{{url('buy/edit/invoice')}}?id={{$invoices[$i]->id}}')" title="修改">修改</a>
                    </td>
                </tr>
                    {{--@endforeach--}}
                    @endfor
                </tbody>
                <tfoot>
                <tr>
                    <th colspan="5">合计</th>
                    <th>{{number_format($purchase->invoices()->sum('without_tax'),2)}} ￥</th>
                    <th>{{number_format($purchase->invoices()->sum('tax'),2)}} ￥</th>
                    <th>{{number_format($purchase->invoices()->sum('with_tax'),2)}} ￥</th>
                    <th></th>
                    <th></th>
                </tr>
                </tfoot>
            </table>
        </div>
        <div class="flex-row flex-center margin-top-50">
            <a class="ui icon button primary" href="javascript:_helper.fullWindow('{{url('buy/create/invoice')}}?purchase_id={{$purchase->id}}')" style="margin:0 10px;">
                <i class="icon yen"></i>
                <span>收票</span>
            </a>
            <a class="ui icon button positive" href="javascript:_helper.fullWindow('{{url('buy/print/invoice')}}?id={{$purchase->id}}')" style="margin:0 10px;">
                <i class="icon print"></i>
                <span>凭证</span>
            </a>
        </div>

    </div>
    <!-- /主体内容 === 不可复用 -->
@endsection
@section('pageJs')
    <script src="{{url('js/buy_invoice_list.js')}}"></script>
@endsection