@extends('layouts.main')
@section('title','已立项清单')
@section('content')
    <!-- 没有导航的单独窗口页面 -->
    <div class="normal-content print-no-padding">

        <div class="ui breadcrumb">
            <a class="section">数据维护</a>
            <div class="divider"> / </div>
            <a class="section" href="../data/supplier_list.html">供应商列表</a>
            <div class="divider"> / </div>
            <div class="active section">新增供应商</div>
        </div>

        <h4 class="ui dividing header blue">信息录入</h4>
        <div id="dataSupplierAdd">
            <div class="ui form">
                <div class="ui three column doubling stackable grid">
                    <div class="column">
                        <div class="inline fields">
                            <label class="six wide field flex-center">供应商名称</label>
                            <div class="eleven wide field">
                                <input type="hidden" id="supplierName" value="xxx">
                                <input type="text" v-model="supplierForm.name" placeholder="请输入供应商名称">
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="six wide field flex-center">收款银行</label>
                            <div class="eleven wide field">
                                <input type="hidden" id="supplierBank" value="中国银行">
                                <input type="text" v-model="supplierForm.bank" placeholder="请输入收款银行">
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="six wide field flex-center">收款账号</label>
                            <div class="eleven wide field">
                                <input type="hidden" id="supplierAccount" value="63234234234234234234">
                                <input type="text" v-model="supplierForm.account" placeholder="请输入收款账号">
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
    <script src="{{url('js/data_supplier_add.js')}}"></script>
@endsection