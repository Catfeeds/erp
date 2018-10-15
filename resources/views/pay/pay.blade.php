@extends('layouts.main_no_nav')
@section('title','付款')
@section('content')
    <!-- 没有导航的单独窗口页面 -->
    <div class="normal-content print-no-padding">

        <div class="ui breadcrumb">
            <a class="section">费用付款管理</a>
            <div class="divider"> / </div>
            <a class="section"  href="{{url('pay/list')}}" >付款审批清单</a>
            <div class="divider"> / </div>
            <a class="section" href="{{url('pay/single?id=')}}{{$apply->id}}"   >付款审批查询 - {{$apply->number}}</a>
            <div class="divider"> / </div>
            <div class="active section">付款</div>
        </div>
        <input type="hidden" id="payId" value="{{$apply->id}}">
        <input type="hidden" id="manager" value="{{\Illuminate\Support\Facades\Auth::user()->username}}">
        <div style="display: none;" id="bankList">{{json_encode($bankList)}}</div>
        <h1 class="ui header blue aligned center">付款</h1>
        <div id="payPay">
            <h4 class="ui dividing header blue">信息录入</h4>
            <div class="ui form">
                <div class="ui three column doubling stackable grid">
                    <div class="column">
                        <div class="inline fields">
                            <label class="six wide field flex-center">付款日期</label>
                            <div class="eleven wide field">
                                <el-date-picker v-model="payForm.date" type="date" placeholder="请选择付款日期" value-format="yyyy-MM-dd">
                                </el-date-picker>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="six wide field flex-center">现金</label>
                            <div class="eleven wide field">
                                <input type="number" v-model.number="payForm.cash" placeholder="请输入现金">
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="six wide field flex-center">转账金额</label>
                            <div class="eleven wide field">
                                <input type="number" v-model.number="payForm.amount" placeholder="请输入转账金额">
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="six wide field flex-center">其他金额</label>
                            <div class="eleven wide field">
                                <input type="number" v-model.number="payForm.other" placeholder="请输入其他金额">
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="six wide field flex-center">转账银行</label>
                            <div class="eleven wide field">
                                <el-select v-model="payForm.bankIndex" placeholder="请选择转账银行" @change="selectBank">
                                    <el-option v-for="(item, index) in bankList" :key="item.id" :label="item.name + item.account" :value="index">
                                    </el-option>
                                </el-select>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="six wide field flex-center">转账账户</label>
                            <div class="eleven wide field">
                                <div class="fake-input">@{{ payForm.account || '无' }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="six wide field flex-center">付款经办人</label>
                            <div class="eleven wide field">
                                <input type="text" v-model="payForm.people" placeholder="请输入付款经办人">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="inline-center margin-top-20">
                <button class="ui button primary large" @click="submit">
                    <i class="icon hand pointer"></i>
                    <span>提交</span>
                </button>
            </div>

        </div>
    </div>
    <!-- /主体内容 === 不可复用 -->
@endsection
@section('pageJs')
    <script src="{{url('js/pay_pay.js')}}"></script>
@endsection