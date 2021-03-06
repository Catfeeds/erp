@extends('layouts.main_no_nav')
@section('title','分包合同修改')
@section('content')

    <div class="normal-content print-no-padding">

        <div class="ui breadcrumb">
            <a class="section">验收与收款管理</a>
            <div class="divider"> / </div>
            <a class="section" href="{{url('check/list')}}" >验收与收款清单</a>
            <div class="divider"> / </div>
            <a class="section" href="{{url('check/detail?id=')}}{{$project->id}}" >项目明细 - 项目号 {{$project->number}}</a>
            <div class="divider"> / </div>
            <div class="active section">收款</div>
        </div>
        <input type="hidden" id="projectId" value="{{$project->id}}">

        <div class="invisible margin-top-20" id="checkCollect">
            <div class="ui top attached tabular menu" style="cursor:pointer;">
                <div class="item active" data-tab="tab-1">分包合同收款</div>
                {{--<div class="item" data-tab="tab-2">主合同收款</div>--}}
                {{----}}
                {{--<div class="item active" data-tab="tab-3">收回履约保证金</div>--}}
            </div>





            <!-- 分包合同收款 -->
            <div class="ui tab attached segment active collect-item" data-tab="tab-1">
                <h3 class="ui header center aligned">分包合同收款</h3>
                <form method="post" novalidate="true">
                <div class="ui form form-item">
                    <div class="ui three column doubling stackable grid">
                        <div class="column">
                            <div class="inline fields">
                                <label class="four wide field">项目编号</label>
                                <div class="twelve wide field">
                                    <div class="fake-input">{{$project->number}}</div>
                                </div>
                            </div>
                        </div>
                        <div class="column">
                            <div class="inline fields">
                                <label class="four wide field">项目内容</label>
                                <div class="twelve wide field">
                                    <div class="fake-input">{{$project->name}}</div>
                                </div>
                            </div>
                        </div>
                        <div class="column">
                            <div class="inline fields">
                                <label class="four wide field">付款单位</label>
                                <div class="twelve wide field">
                                    {{--<el-autocomplete popper-class="my-autocomplete" v-model="collectForm.subContract.payee" :fetch-suggestions="querySearchCompany"--}}
                                                     {{--placeholder="请选择付款单位" @select="handleSelectCompanyC">--}}
                                        {{--<i class="el-icon-edit el-input__icon" slot="suffix">--}}
                                        {{--</i>--}}
                                        {{--<template slot-scope="props">--}}
                                            {{--<div class="name">@{{ props.item }}</div>--}}
                                        {{--</template>--}}
                                    {{--</el-autocomplete>--}}
                                    <input name="payee" value="{{$collect->payee}}">
                                </div>
                            </div>
                        </div>
                        <div class="column">
                            <div class="inline fields">
                                <label class="four wide field">收款日期</label>
                                <div class="twelve wide field">
                                    <input name="date" value="{{$collect->date}}" type="date">
                                    {{--<el-date-picker type="date" placeholder="请选择收款日期" value-format="yyyy-MM-dd">--}}
                                    {{--</el-date-picker>--}}
                                </div>
                            </div>
                        </div>
                        <div class="column">
                            <div class="inline fields">
                                <label class="four wide field">收款金额</label>
                                <div class="twelve wide field icon input">
                                    <input name="price" value="{{$collect->price}}"  type="number" placeholder="请输入收款金额">
                                    <i class="yen icon"></i>
                                </div>
                            </div>
                        </div>
                        <div class="column">
                            <div class="inline fields">
                                <label class="four wide field">收款银行</label>
                                <div class="twelve wide field icon input">
                                    <input type="hidden" id="bank" value="{{$collect->bank}}" name="bank">
                                    <el-autocomplete popper-class="my-autocomplete" v-model="collectForm.subContract.bank" :fetch-suggestions="querySearchBank"
                                                     placeholder="请输入收款银行" @select="handleSelectBankC">
                                        <i class="el-icon-edit el-input__icon" slot="suffix">
                                        </i>
                                        <template slot-scope="props">
                                            <div class="name">@{{ props.item.name }}</div>
                                            <div class="addr">@{{ props.item.account }}</div>
                                        </template>
                                    </el-autocomplete>
                                </div>
                            </div>
                        </div>
                        <div class="column">
                            <div class="inline fields">
                                <label class="four wide field">银行账号</label>
                                <div class="twelve wide field icon input">
                                    <input name="account" id="account" type="hidden" value="{{$collect->account}}">
                                    <div class="fake-input">@{{ collectForm.subContract.account || '暂无' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="inline-center margin-top-20">
                    <button class="ui button green large" type="submit">
                        <i class="icon hand pointer"></i>
                        <span>提交</span>
                    </button>
                </div>
                </form>
            </div>

            <!-- / 分包合同收款 -->


        </div>
    </div>
    <!-- /主体内容 === 不可复用 -->
@endsection
@section('pageJs')
    <script src="{{url('js/check_sub.js')}}"></script>
@endsection