@extends('layouts.main')
@section('title','新增发票类型')
@section('content')
    <!-- 没有导航的单独窗口页面 -->
    <div class="normal-content print-no-padding">

        <div class="ui breadcrumb">
            <a class="section" href="{{url('')}}">数据维护</a>
            <div class="divider"> / </div>
            <a class="section" href="{{url('invoice/list')}}">发票列表</a>
            <div class="divider"> / </div>
            <div class="active section">新增发票类型</div>
        </div>
        <input type="hidden" id="invoiceId" value="{{$invoice->id}}">
        <input type="hidden" id="invoiceName" value="{{$invoice->name}}">
        <input type="hidden" id="invoiceRate" value="{{$invoice->rate}}">
        <h1 class="ui header blue aligned center">新增发票类型</h1>
        <div id="dataInvoiceAdd">
            <h4 class="ui dividing header blue">信息录入</h4>
            <div class="ui form">
                <div class="ui three column doubling stackable grid">
                    <div class="column">
                        <div class="inline fields">
                            <label class="six wide field flex-center">发票类型名称</label>
                            <div class="eleven wide field">

                                <input type="text" v-model="invoiceForm.name" placeholder="请输入发票类型名称">
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="six wide field flex-center">税率</label>
                            <div class="eleven wide field">

                                <input type="text" v-model="invoiceForm.rate" placeholder="请输入税率">%
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="six wide field flex-center">备注</label>
                            <div class="eleven wide field">
                                <input type="hidden" id="invoiceRemark" value="{{$invoice->remark}}">
                                <input type="text" v-model="invoiceForm.remark" placeholder="请输入备注">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="inline-center margin-top-20">
                <button class="ui button primary large" @click="submit">
                    <i class="icon hand pointer"></i>
                    <span>确定</span>
                </button>
            </div>

        </div>
    </div>
    <!-- /主体内容 === 不可复用 -->
@endsection
@section('pageJs')
    <script src="{{url('js/data_invoice_add.js')}}"></script>
@endsection