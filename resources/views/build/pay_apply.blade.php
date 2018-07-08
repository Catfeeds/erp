@extends('layouts.main_no_nav')
@section('title','已立项清单')
@section('content')
    <!-- 没有导航的单独窗口页面 -->
    <div class="normal-content print-no-padding">

        <div class="ui breadcrumb">
            <a class="section">施工管理</a>
            <div class="divider"> / </div>
            <a class="section" href="../build/pay_list.html">施工付款款清单</a>
            <div class="divider"> / </div>
            <a class="section" href="../build/pay_single.html?id=SGFK20171103001">付款查询 - {{$pay->number}}</a>
            <div class="divider"> / </div>
            <div class="active section">付款申请录入</div>
        </div>

        <input type="hidden" id="projectId" value="{{$projectTeam->id}}">
        <input type="hidden" id="teamId" value="{{$pay->id}}">
        <div id="teamInfo" style="display: none">{{json_encode($team)}}</div>

        <h1 class="ui header blue aligned center">付款申请录入</h1>
        <div id="buildPayApply">
            <h4 class="ui dividing header blue">基本信息</h4>
            <div class="ui form">
                <div class="ui three column doubling stackable grid">
                    <div class="column">
                        <div class="inline fields">
                            <label class="six wide field flex-center">施工队</label>
                            <div class="eleven wide field">
                                <div class="fake-input">{{$projectTeam->team}}</div>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="six wide field flex-center">开户银行</label>
                            <div class="eleven wide field">
                                <div class="fake-input">{{$team->bank}}</div>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="six wide field flex-center">账号</label>
                            <div class="eleven wide field">
                                <div class="fake-input">{{$team->account}}</div>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="six wide field flex-center">施工经理</label>
                            <div class="eleven wide field">
                                <div class="fake-input">{{$projectTeam->manager}}</div>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="six wide field flex-center">项目编号</label>
                            <div class="eleven wide field">
                                <div class="fake-input">{{$projectTeam->project_number}}</div>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="six wide field flex-center">项目内容</label>
                            <div class="eleven wide field">
                                <div class="fake-input">{{$projectTeam->project_content}}</div>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="six wide field flex-center">项目经理</label>
                            <div class="eleven wide field">
                                <div class="fake-input">{{$projectTeam->project_manager}}</div>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="six wide field flex-center">已完工请款</label>
                            <div class="eleven wide field">
                                <div class="fake-input">{{number_format($projectTeam->payments()->where('state','=',3)->sum('price'),2)}} ￥</div>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="six wide field flex-center">已申请付款</label>
                            <div class="eleven wide field">
                                <div class="fake-input">{{number_format($projectTeam->applies()->where('state','>=',3)->sum('apply_price'),2)}} ￥</div>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="six wide field flex-center">已付款</label>
                            <div class="eleven wide field">
                                <div class="fake-input">{{number_format($projectTeam->applies()->where('state','=',4)->sum('apply_price'),2)}} ￥</div>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="six wide field flex-center">剩余应付账款</label>
                            <div class="eleven wide field">
                                <div class="fake-input">{{number_format($projectTeam->payments()->where('state','=',3)->sum('price')-$projectTeam->applies()->where('state','=',4)->sum('apply_price'),2)}} ￥</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <h4 class="ui dividing header blue">信息录入</h4>
            <div class="ui form">
                <div class="ui three column doubling stackable grid">
                    <div class="column">
                        <div class="inline fields">
                            <label class="six wide field flex-center">申请付款日期</label>
                            <div class="eleven wide field">
                                <el-date-picker v-model="applyForm.date" type="date" placeholder="请选择申请付款日期" value-format="yyyy-MM-dd">
                                </el-date-picker>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="six wide field flex-center">付款金额</label>
                            <div class="eleven wide field">
                                <input type="number" v-model.number="applyForm.price" placeholder="请输入付款金额">
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="six wide field flex-center">收款人</label>
                            <div class="eleven wide field">
                                <input type="text" v-model="applyForm.payee" placeholder="请输入收款人">
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="six wide field flex-center">收款银行</label>
                            <div class="eleven wide field">
                                <input type="text" v-model="applyForm.bank" placeholder="请输入收款银行">
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="six wide field flex-center">收款账号</label>
                            <div class="eleven wide field">
                                <input type="text" v-model.number="applyForm.account" placeholder="请输入收款账号">
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
    <script src="{{url('js/build_pay_apply.js')}}"></script>
@endsection