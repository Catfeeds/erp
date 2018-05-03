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
            {{--<div class="active section">付款查询 - SGFK20171103001</div>--}}
        </div>

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
                        <label class="six wide field flex-center">施工经理</label>
                        <div class="eleven wide field">
                            <div class="fake-input">{{$projectTeam->manager}}</div>
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
            </div>
        </div>


        <h4 class="ui dividing header blue">完工请款</h4>

        <table class="ui celled center aligned table selectable unstackable">
            <thead>
            <tr>
                <th>请款编号</th>
                <th>请款日期</th>
                <th>请款金额</th>
                <th>经办人</th>
                <th>复核人</th>
                <th>审批人</th>
            </tr>
            </thead>
            <tbody>
            @foreach($lists as $list)
            <tr>
                <td>{{$list->number}}</td>
                <td>{{$list->request_date}}</td>
                <td>{{$list->price}} ￥</td>
                <td>{{$list->applier}}</td>
                <td>{{$list->checker}}</td>
                <td>{{$list->passer}}</td>
            </tr>
            @endforeach
            </tbody>
            <tfoot>
            <tr>
                <th colspan="2">合计</th>
                <th>{{$projectTeam->payments()->where('state','=',3)->sum('price')}} ￥</th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
            </tfoot>
        </table>

        <h4 class="ui dividing header blue">付款情况</h4>
        <div class="table-head-nowrap">
            <table class="ui celled center aligned table selectable unstackable">
                <thead>
                <tr>
                    <th colspan="8">申请付款</th>
                    <th colspan="5">实际付款</th>
                    <th>操作</th>
                </tr>
                <tr>
                    <th>付款编号</th>
                    <th>申请日期</th>
                    <th>申请金额</th>
                    <th>收款人</th>
                    <th>收款银行/账号</th>
                    <th>经办人</th>
                    <th>复核人</th>
                    <th>审批人</th>
                    <th>付款日期</th>
                    <th>付款金额</th>
                    <th>付款银行/账号</th>
                    <th>备注</th>
                    <th>经办人</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($applies as $apply)
                <tr>
                    <td>{{$apply->number}}</td>
                    <td>{{$apply->apply_date}}</td>
                    <td>{{$apply->apply_price}} ￥</td>
                    <td>{{$apply->payee}}</td>
                    <td>{{$apply->bank}}/{{$apply->account}}</td>
                    <td>{{$apply->worker}}</td>
                    <td>{{$apply->checker}}</td>
                    <td>{{$apply->passer}}</td>
                    @if($apply->state==4)
                    <td>{{$apply->pay_date}}</td>
                    <td>{{$apply->pay_price}} ￥</td>
                    <td>{{$apply->pay_bank}}/{{$apply->pay_account}}</td>
                    <td style="min-width:200px;">{{$apply->remark}}</td>
                    <td>{{$apply->pay_worker}}</td>
                    @else
                        <td colspan="5">暂未付款</td>
                    @endif
                    <td style="white-space:nowrap;">
                        <a class="ui mini button" href="javascript:_helper.fullWindow('../build/pay_apply.html?id=1')">修改</a>
                        <button class="ui mini button primary paySingleBtn" data-id="{{$apply->id}}">复核</button>
                        <button class="ui mini button primary payPassBtn" data-id="{{$apply->id}}">审批</button>
                        <a class="ui mini button primary" href="javascript:_helper.fullWindow('{{url('build/pay/add')}}?id={{$apply->id}}')">录入</a>
                    </td>
                </tr>

                    @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <th colspan="13">已付款合计</th>
                    <th>{{$projectTeam->pay_price}}￥</th>
                </tr>
                <tr>
                    <th colspan="13">剩余应付账款</th>
                    <th>{{$projectTeam->need_price}}￥</th>
                </tr>
                </tfoot>
            </table>
        </div>

        <div class="flex-row flex-center margin-top-50">
            <a class="ui icon button primary" href="javascript:_helper.fullWindow('{{url('build/pay/finish')}}?project_id={{$projectTeam->id}}')" style="margin-right:50px;">
                <i class="icon plus"></i>
                <span>新增付款申请</span>
            </a>
            <a class="ui icon button positive" href="javascript:_helper.fullWindow('{{url('build/pay/print')}}?id={{$projectTeam->id}}')">
                <i class="icon print"></i>
                <span>凭证</span>
            </a>
        </div>
    </div>

    <div id="buildPaySingle">
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
    <!-- /主体内容 === 不可复用 -->
@endsection
@section('pageJs')
    <script src="{{url('js/build_pay_single.js')}}"></script>
@endsection