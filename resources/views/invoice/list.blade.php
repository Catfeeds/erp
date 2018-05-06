@extends('layouts.main')
@section('title','已立项清单')
@section('content')
    <!-- 主体内容 === 不可复用 -->
    <div class="index-content print-no-padding">

        <div class="ui breadcrumb">
            <a class="section">数据维护</a>
            <div class="divider"> / </div>
            <div class="active section">发票类型</div>
        </div>

        <!-- 操作区域 -->
        <div class="content-operation">

            <form action="" class="ui form">
                <div class="flex-row flex-between flex-wrap">
                    <div>
                        <a class="ui primary button" href="javascript:_helper.fullWindow('{{url('invoice/create')}}')">
                            <i class="icon plus"></i>
                            <span>新增发票类型</span>
                        </a>
                    </div>
                </div>
            </form>
        </div>
        <!-- / 操作区域 -->

        <div class="content-wrap table-head-nowrap">

            <table class="ui center aligned table selectable unstackable">
                <thead>
                <tr>
                    <th>发票类型</th>
                    <th>税率</th>
                    <th>备注</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($invoices as $invoice)
                <tr>
                    <td>{{$invoice->name}}</td>
                    <td>{{$invoice->rate}}%</td>
                    <td>{{$invoice->remark}}</td>
                    <td>
                        <a class="ui mini button primary" href="javascript:_helper.fullWindow('{{url('invoice/create')}}?id={{$invoice->id}}')">修改</a>
                        <button class="ui mini button negative dataInvoiceDelete" data-id="{{$invoice->id}}">删除</button>
                    </td>
                </tr>
                @endforeach

                </tbody>
                {{$invoices->links()}}
            </table>
        </div>

    </div>
    <!-- /主体内容 === 不可复用 -->
@endsection
@section('pageJs')
    <script src="{{url('js/data_invoice_list.js')}}"></script>
@endsection