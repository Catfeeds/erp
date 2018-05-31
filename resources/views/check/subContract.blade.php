@extends('layouts.main_no_nav')
@section('title','分包合同修改')
@section('content')
    <div class="normal-content print-no-padding">

        <div class="ui breadcrumb">
            <a class="section">验收与收款管理</a>
            <div class="divider"> / </div>
            <a class="section" href="{{url('check/list')}}">验收与收款清单</a>
            <div class="divider"> / </div>
            <a class="section" href="{{url('check/detail')}}?id={{$project->id}}">项目明细 - 项目号 {{$project->number}}</a>
            <div class="divider"> / </div>
            <div class="active section">收款</div>
        </div>
        <input type="hidden" id="projectId" value="{{$project->id}}">

        <div class=" margin-top-20"  style="cursor:pointer;">
                {{--<div class="item" >分包合同收款</div>--}}
            {{--</div>t">--}}
            {{--<div class="ui top attached tabular men--}}





            <!-- 分包合同收款 -->
            <div class="ui tab attached segment " >
                <h3 class="ui header center aligned">分包合同收款</h3>
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
                                    <el-autocomplete popper-class="my-autocomplete" v-model="collectForm.subContract.payee" :fetch-suggestions="querySearchCompany"
                                                     placeholder="请选择付款单位" @select="handleSelectCompanyC">
                                        <i class="el-icon-edit el-input__icon" slot="suffix">
                                        </i>
                                        <template slot-scope="props">
                                            <div class="name">@{{ props.item }}</div>
                                        </template>
                                    </el-autocomplete>
                                </div>
                            </div>
                        </div>
                        <div class="column">
                            <div class="inline fields">
                                <label class="four wide field">收款日期</label>
                                <div class="twelve wide field">
                                    <el-date-picker v-model="collectForm.subContract.pay_date" type="date" placeholder="请选择收款日期" value-format="yyyy-MM-dd">
                                    </el-date-picker>
                                </div>
                            </div>
                        </div>
                        <div class="column">
                            <div class="inline fields">
                                <label class="four wide field">收款金额</label>
                                <div class="twelve wide field icon input">
                                    <input v-model.number="collectForm.subContract.price" type="number" placeholder="请输入收款金额">
                                    <i class="yen icon"></i>
                                </div>
                            </div>
                        </div>
                        <div class="column">
                            <div class="inline fields">
                                <label class="four wide field">收款银行</label>
                                <div class="twelve wide field icon input">
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
                                    <div class="fake-input">@{{ collectForm.subContract.account || '暂无' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="inline-center margin-top-20">
                    <button class="ui button green large" @click="checkSubmit('subContract')">
                        <i class="icon hand pointer"></i>
                        <span>提交</span>
                    </button>
                </div>
            </div>
            <!-- / 分包合同收款 -->


        </div>
    </div>
    <!-- /主体内容 === 不可复用 -->
@endsection
@section('pageJs')
    {{--<script src="{{url('js/project_list.js')}}"></script>--}}
@endsection