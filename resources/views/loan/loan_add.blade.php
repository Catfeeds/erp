@extends('layouts.main')
@section('title','新增借款申请')
@section('content')
    <!-- 没有导航的单独窗口页面 -->
    <div class="normal-content print-no-padding">

        <div class="ui breadcrumb">
            <a class="section">报销与借款管理</a>
            <div class="divider"> / </div>
            <a class="section" >借款清单</a>
            <div class="divider"> / </div>
            <div class="active section">新增借款申请</div>
        </div>

        <input type="hidden" id="loanUser" value="{{\Illuminate\Support\Facades\Auth::user()->username}}">

        <h1 class="ui header blue aligned center">新增借款申请</h1>
        <div id="loanLoanAdd">
            <h4 class="ui dividing header blue">信息录入</h4>
            <div class="ui form">
                <div class="ui three column doubling stackable grid">
                    <div class="column">
                        <div class="inline fields">
                            <label class="six wide field flex-center">借款人</label>
                            <div class="eleven wide field">
                                <input type="text" v-model="loanForm.loan_user" placeholder="请输入借款人">
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="six wide field flex-center">申请日期</label>
                            <div class="eleven wide field">
                                <el-date-picker v-model="loanForm.date" type="date" placeholder="请选择申请日期" value-format="yyyy-MM-dd">
                                </el-date-picker>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="six wide field flex-center">借款金额</label>
                            <div class="eleven wide field">
                                <input type="number" v-model.number="loanForm.preice" placeholder="请选择借款金额">
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="six wide field flex-center">借款原因</label>
                            <div class="eleven wide field">
                                <input type="text" v-model="loanForm.reason" placeholder="请选择借款原因">
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

            <div class="ui page dimmer">
                <div class="simple dimmer content">
                    <div class="center">
                        <div class="buy_dialog">
                            <div class="dialog_header">选择审批人</div>
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
    <script src="{{url('js/loan_loan_add.js')}}"></script>
@endsection