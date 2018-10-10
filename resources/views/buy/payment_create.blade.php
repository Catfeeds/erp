@extends('layouts.main_no_nav')
@section('title','已立项清单')
@section('content')
    <!-- 没有导航的单独窗口页面 -->
    <div class="normal-content print-no-padding">

        <div class="ui breadcrumb print-hide">
            <a class="section">采购管理</a>
            <div class="divider"> / </div>
            <a class="section" >采购付款清单</a>
            <div class="divider"> / </div>
            <a class="section" >采购付款查询 - {{$purchase->number}}</a>
            <div class="divider"> / </div>
            <div class="active section">付款申请</div>
        </div>
        <input id="projectId" type="hidden" value="{{$purchase->project_id}}">
        <input id="purchaseId" type="hidden" value="{{$purchase->id}}">
        <input id="createId" type="hidden" value="{{$id}}">
        <input id="hiddenDate" type="hidden" value="{{date('Y-m-d')}}">
        <input id="hiddenAmount" type="hidden" value="0">
        <h1 class="ui red header blue center aligned">付款申请</h1>
        <div id="paymentCreate">

            <!-- 基本信息 -->
            <div class="ui form form-item">
                <div class="ui three column doubling stackable grid">
                    <div class="column">
                        <div class="inline fields">
                            <label class="four wide field">付款申请日期</label>
                            <div class="twelve wide field">
                                <el-date-picker v-model="form.date" name="date" type="date" placeholder="付款申请日期" value-format="yyyy-MM-dd">
                                </el-date-picker>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="four wide field">供货商</label>
                            <div class="twelve wide field">
                                <div class="fake-input">{{$purchase->supplier}}</div>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="four wide field">供货商收款银行</label>
                            <div class="twelve wide field icon input">
                                <div class="fake-input">{{$purchase->bank}}</div>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="four wide field">供货商收款账号</label>
                            <div class="twelve wide field">
                                <div class="fake-input">{{$purchase->account}}</div>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="four wide field">付款金额</label>
                            <div class="twelve wide field">
                                <div class="ui icon input">
                                    <input type="number" v-model.number="form.price" name="amount" placeholder="请输入付款金额">
                                    <i class="yen icon"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /基本信息 -->
            <div class="inline-center margin-top-20">
                <button class="ui button green large" @click="submitForm">
                    <i class="icon hand pointer"></i>
                    <span>提交</span>
                </button>
            </div>

            <div class="ui page dimmer">
                <div class="simple dimmer content">
                    <div class="center">
                        <div class="buy_dialog">
                            <div class="dialog_header">选择复核人</div>
                            <div class="dialog_content">
                                <el-checkbox-group v-model="checkedMen" @change="handleCheckManChange">
                                    <el-checkbox v-for="man in menList" :label="man.id" :key="man.id">@{{man.name}}</el-checkbox>
                                </el-checkbox-group>
                            </div>
                            <div class="diolag_footer">
                                <button class="ui button primary" @click="confirmRecheck">确 定</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- /主体内容 === 不可复用 -->
@endsection
@section('pageJs')
    <script src="{{url('js/buy_payment_create.js')}}"></script>
@endsection