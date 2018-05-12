@extends('layouts.main')
@section('title','新建立项')
@section('content')
    <!-- 没有导航的单独窗口页面 -->
    <div class="normal-content print-no-padding">

        <div class="ui breadcrumb">
            <a class="section">项目立项管理</a>
            <div class="divider"> / </div>
            <a class="section" href="../project/list.html">已立项清单</a>
            <div class="divider"> / </div>
            <div class="active section">新建立项</div>
        </div>

        <div style="display:none;" id="contractContent">
            {{json_encode($types)}}
        </div>


        <div style="display:none;" id="projectData">
            {{--@if(!empty($project))--}}
            {{--{{json_encode($project)}}--}}
            {{--@else--}}
                {{--@endif--}}
            @if(!empty($project))
            {"project":{{json_encode($project)}},"mainContracts":{{json_encode($project->mainContract()->get())}},"outContracts":{{json_encode($project->outContract()->get())}},"situations":{{json_encode($situations)}},"bails":{{json_encode($project->bail()->get())}},"receipts":{{json_encode($project->receipt()->get())}},"pictures":{{json_encode($project->picture()->get())}}}
            @else
            @endif
        </div>
        <h1 class="ui red header blue center aligned">项目立项</h1>

        <div class="invisible" id="projectCreate">
            <!-- 项目基本信息 -->
            <h4 class="ui dividing header blue">项目基本信息</h4>
            <div class="ui form form-item">
                <div class="ui three column doubling stackable grid">
                    <div class="column">
                        <div class="inline fields">
                            <label class="four wide field">立项日期</label>
                            <div class="twelve wide field">
                                <el-date-picker v-model="project.project.signDate" type="date" placeholder="请选择日期" value-format="yyyy-MM-dd">
                                </el-date-picker>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="four wide field">项目内容</label>
                            <div class="twelve wide field">
                                <input v-model="project.project.name" type="text" placeholder="请输入项目内容">
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="four wide field">甲方</label>
                            <div class="twelve wide field">
                                <input v-model="project.project.partyA" type="text" placeholder="请输入甲方">
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="four wide field">项目合同金额</label>
                            <div class="twelve wide field icon input">
                                <input v-model="project.project.amount" type="number" placeholder="请输入项目合同金额">
                                <i class="yen icon"></i>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="four wide field">预计完工日期</label>
                            <div class="twelve wide field">
                                <el-date-picker v-model="project.project.completeDate" type="date" placeholder="请选择完工日期" value-format="yyyy-MM-dd">
                                </el-date-picker>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="four wide field">项目经理</label>
                            <div class="twelve wide field">
                                <input v-model="project.project.manager" type="text" placeholder="请输入项目经理">
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="four wide field">维护要求</label>
                            <div class="twelve wide field">
                                <input v-model="project.project.maintain" type="text" placeholder="请输入维护要求">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- / 项目基本信息 -->

            <!-- 主合同中标情况 -->
            <h4 class="ui dividing header blue">主合同中标情况</h4>
            <div class="flex-row flex-end">
                <button class="ui positive icon button" @click="addFirstItem('masterCompany')">
                    <i class="icon plus"></i>
                    <span>新增</span>
                </button>
            </div>
            <div class="ui form form-item">
                <div class="ui five column doubling stackable grid">
                    <div class="one wide column form-thead">序号</div>
                    <div class="four wide column form-thead">单位名称</div>
                    <div class="four wide column form-thead">金额</div>
                    <div class="six wide column form-thead">备注</div>
                    <div class="one wide column form-thead">操作</div>
                </div>
                <transition-group name="slide-down" tag="div" class="form-wrap special-form">
                    <div class="ui three column doubling stackable grid center aligned" v-for="(item,index) in project.masterCompany" :key="item.id">
                        <div class="one wide column">
                            <div class="fake-input">@{{index + 1}}</div>
                        </div>
                        <div class="four wide column">
                            <input v-model="item.name" type="text" placeholder="请输入中标单位">
                        </div>
                        <div class="four wide column">
                            <div class="block ui icon input">
                                <input v-model="item.amount" type="number" placeholder="请输入中标金额">
                                <i class="yen icon"></i>
                            </div>
                        </div>
                        <div class="six wide column">
                            <input type="text" v-model="item.remark" placeholder="请输入备注">
                        </div>
                        <div class="one wide column">
                            <div class="fake-input">
                                <i class="icon minus red" style="cursor:pointer;" @click="deleteFirstItem('masterCompany', item, index)"></i>
                            </div>
                        </div>
                    </div>
                </transition-group>
            </div>
            <!-- / 主合同中标情况 -->

            <!-- 分包情况 -->
            <h4 class="ui dividing header blue">分包情况</h4>
            <div class="flex-row flex-end">
                <button class="ui positive icon button" @click="addFirstItem('subCompany')">
                    <i class="icon plus"></i>
                    <span>新增</span>
                </button>
            </div>
            <div class="ui form form-item">
                <div class="ui five column doubling stackable grid">
                    <div class="one wide column form-thead">序号</div>
                    <div class="four wide column form-thead">分包单位</div>
                    <div class="four wide column form-thead">分包金额</div>
                    <div class="six wide column form-thead">备注</div>
                    <div class="one wide column form-thead">操作</div>
                </div>
                <transition-group name="slide-down" tag="div" class="form-wrap special-form">
                    <div class="ui three column doubling stackable grid center aligned" v-for="(item,index) in project.subCompany" :key="item.id">
                        <div class="one wide column">
                            <div class="fake-input">@{{index + 1}}</div>
                        </div>
                        <div class="four wide column">
                            <input v-model="item.name" type="text" placeholder="请输入分包单位">
                        </div>
                        <div class="four wide column">
                            <div class="block ui icon input">
                                <input v-model="item.amount" type="number" placeholder="请输入分包金额">
                                <i class="yen icon"></i>
                            </div>
                        </div>
                        <div class="six wide column">
                            <input type="text" v-model="item.remark" placeholder="请输入备注">
                        </div>
                        <div class="one wide column">
                            <div class="fake-input">
                                <i class="icon minus red" style="cursor:pointer;" @click="deleteFirstItem('subCompany', item, index)"></i>
                            </div>
                        </div>
                    </div>
                </transition-group>
            </div>
            <!-- / 分包情况 -->

            <!-- 项目实际情况 -->
            <h4 class="ui dividing header blue">项目实际情况</h4>
            <!-- 主合同 -->
            <transition-group name="slide-down" tag="div">
                <div v-for="(item, index) in project.masterContract" :key="item.id">
                    <div class="flex-row flex-between">
                        <div class="ui form form-head">
                            <div class="inline fields">
                                <label>@{{index === 0?"主合同金额":"后期追加或减少金额"}}</label>
                                <div class="ui icon input">
                                    <input v-model="item.amount" type="number" placeholder="请输入主合同金额" style="min-width: 300px;">
                                    <i class="yen icon"></i>
                                </div>
                            </div>
                        </div>
                        <div>
                            <button class="ui positive icon button" @click="addSecondItem('masterContract', index)">
                                <i class="icon plus"></i>
                                <span>新增</span>
                            </button>
                            <button v-if="index > 0" class="ui negative icon button" @click="deleteFirstItem('masterContract', item, index)">
                                <i class="icon minus"></i>
                                <span>删除该追加</span>
                            </button>
                        </div>
                    </div>
                    <div class="ui form form-item">
                        <div class="ui five column doubling stackable grid">
                            <div class="one wide column form-thead">序号</div>
                            <div class="four wide column form-thead">内容名称</div>
                            <div class="two wide column form-thead">税率</div>
                            <div class="two wide column form-thead">金额</div>
                            <div class="six wide column form-thead">备注</div>
                            <div class="one wide column form-thead">操作</div>
                        </div>
                        <transition-group name="slide-down" tag="div" class="form-wrap special-form">
                            <div class="ui three column doubling stackable grid center aligned" v-for="(subItem, subIndex) in item.details" :key="subIndex">
                                <div class="one wide column">
                                    <div class="fake-input">@{{subIndex + 1}}</div>
                                </div>
                                <div class="four wide column">
                                    <el-select v-model="subItem.name" placeholder="请选择内容">
                                        <el-option v-for="item in contractContent" :key="item.id" :label="item.name+' '+item.rate+'%'" :value="item.id">
                                        </el-option>
                                    </el-select>
                                </div>
                                {{--<div class="two wide column">--}}
                                    {{----}}
                                    {{--<el-select v-model="subItem.tax" placeholder="请选择税率">--}}
                                        {{--<el-option v-for="item in contractTax" :key="item.id" :label="item.name" :value="item.id">--}}
                                        {{--</el-option>--}}
                                    {{--</el-select>--}}
                                {{--</div>--}}
                                <div class="two wide column">
                                    <div class="fake-input">@{{ TaxIDMap[subItem.name]?TaxIDMap[subItem.name] + '%':'暂无'}}</div>
                                </div>
                                <div class="two wide column">
                                    <div class="block ui icon input">
                                        <input v-model="subItem.amount" type="number" placeholder="请输入金额">
                                        <i class="yen icon"></i>
                                    </div>
                                </div>
                                <div class="six wide column">
                                    <input type="text" v-model="subItem.remark" placeholder="请输入备注">
                                </div>
                                <div class="one wide column">
                                    <div class="fake-input">
                                        <i class="icon minus red" style="cursor:pointer;" @click="deleteSecondItem('masterContract', index, subIndex, item)"></i>
                                    </div>
                                </div>
                            </div>
                        </transition-group>
                    </div>
                </div>
            </transition-group>
            <div class="inline-center">
                <button class="ui button primary iocn" @click="addFirstItem('masterContract')">
                    <i class="icon plus"></i>
                    <span>新增后期追加</span>
                </button>
            </div>
            <h4 class="ui horizontal divider header">
                <i class="icon file text"></i>
                <span class="ho_span">主合同</span>
            </h4>
            <!-- / 主合同 -->
            <!-- 分包合同 -->
            <transition-group name="slide-down" tag="div">
                <div v-for="(item, index) in project.subContract" :key="item.id">
                    <div class="flex-row flex-between">
                        <div class="ui form form-head">
                            <div class="inline fields">
                                <label>@{{index === 0?"分包合同金额":"后期追加或减少金额"}}</label>
                                <div class="ui icon input">
                                    <input v-model="item.amount" type="number" placeholder="请输入分包合同金额" style="min-width: 300px;">
                                    <i class="yen icon"></i>
                                </div>
                            </div>
                        </div>
                        <div>
                            <button class="ui positive icon button" @click="addSecondItem('subContract', index)">
                                <i class="icon plus"></i>
                                <span>新增</span>
                            </button>
                            <button v-if="index > 0" class="ui negative icon button" @click="deleteFirstItem('subContract', item, index)">
                                <i class="icon minus"></i>
                                <span>删除该追加</span>
                            </button>
                        </div>
                    </div>
                    <div class="ui form form-item">
                        <div class="ui five column doubling stackable grid">
                            <div class="one wide column form-thead">序号</div>
                            <div class="four wide column form-thead">内容名称</div>
                            <div class="two wide column form-thead">税率</div>
                            <div class="two wide column form-thead">金额</div>
                            <div class="six wide column form-thead">备注</div>
                            <div class="one wide column form-thead">操作</div>
                        </div>
                        <transition-group name="slide-down" tag="div" class="form-wrap special-form">
                            <div class="ui three column doubling stackable grid center aligned" v-for="(subItem, subIndex) in item.details" :key="subIndex">
                                <div class="one wide column">
                                    <div class="fake-input">@{{subIndex + 1}}</div>
                                </div>
                                <div class="four wide column">
                                    <el-select v-model="subItem.name" placeholder="请选择内容">
                                        <el-option v-for="item in contractContent" :key="item.id" :label="item.name+' '+item.rate+'%'" :value="item.id">
                                        </el-option>
                                    </el-select>
                                </div>
                                {{--<div class="two wide column">--}}
                                    {{--<el-select v-model="subItem.tax" placeholder="请选择税率">--}}
                                        {{--<el-option v-for="item in contractTax" :key="item.id" :label="item.name" :value="item.id">--}}
                                        {{--</el-option>--}}
                                    {{--</el-select>--}}
                                {{--</div>--}}
                                <div class="two wide column">
                                    <div class="fake-input">@{{ TaxIDMap[subItem.name]?TaxIDMap[subItem.name] + '%':'暂无'}}</div>
                                </div>
                                <div class="two wide column">
                                    <div class="block ui icon input">
                                        <input v-model="subItem.amount" type="number" placeholder="请输入金额">
                                        <i class="yen icon"></i>
                                    </div>
                                </div>
                                <div class="six wide column">
                                    <input type="text" v-model="subItem.remark" placeholder="请输入备注">
                                </div>
                                <div class="one wide column flex-row flex-end">
                                    <div class="fake-input">
                                        <i class="icon minus red" style="cursor:pointer;" @click="deleteSecondItem('subContract', index, subIndex, item)"></i>
                                    </div>
                                </div>
                            </div>
                        </transition-group>
                    </div>
                </div>
            </transition-group>
            <div class="inline-center">
                <button class="ui button primary iocn" @click="addFirstItem('subContract')">
                    <i class="icon plus"></i>
                    <span>新增后期追加</span>
                </button>
            </div>
            <h4 class="ui horizontal divider header">
                <i class="icon file text"></i>
                <span class="ho_span">分包合同</span>
            </h4>
            <!-- / 分包合同 -->

            <!-- 合计 -->
            <h3 class="inline-center">项目金额统计清单</h3>
            <div class="ui two column doubling stackable grid">
                <div class="column">
                    <h4 class="inline-center">综合统计</h4>
                    <table class="ui celled table">
                        <thead>
                        <tr>
                            <th>类型</th>
                            <th>金额</th>
                        </tr>
                        </thead>
                        <tbody>
                        <template v-if="sumAmount.result.length === 0">
                            <tr class="center aligned">
                                <td>\</td>
                                <td>\</td>
                            </tr>
                        </template>
                        <template v-else>
                            <tr v-for="(item, index) in sumAmount.result" :key="item.id">
                                <template v-if="item.type == 'm'">
                                    <td>主合同@{{ item.head == true?'':'追加' }}金额</td>
                                    <td>@{{item.amount}}￥</td>
                                </template>
                                <template v-else>
                                    <td>分包合同@{{ item.head?'':'追加' }}金额</td>
                                    <td>@{{item.amount}}￥</td>
                                </template>
                            </tr>
                        </template>
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>合计</th>
                            <th>@{{sumAmount&&sumAmount.sum || 0}} ￥</th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="column">
                    <h4 class="inline-center">细节统计</h4>
                    <table class="ui celled table">
                        <thead>
                        <tr>
                            <th>内容</th>
                            <th>税率</th>
                            <th>金额</th>
                        </tr>
                        </thead>
                        <tbody>
                        <template v-if="sumContent && sumContent.result.length > 0">
                            <tr v-for="(item, index) in sumContent.result" :key="item.name">
                                <td>@{{item.name}}</td>
                                <td>@{{item.tax}} %</td>
                                <td>@{{item.amount.toLocaleString('en-US')}} ￥</td>
                            </tr>
                        </template>
                        <template v-else>
                            <tr class="center aligned">
                                <td>\</td>
                                <td>\</td>
                                <td>\</td>
                            </tr>
                        </template>
                        </tbody>
                        <tfoot>
                        <tr>
                            <th colspan="2">合计</th>
                            <th>@{{sumContent&&sumContent.sum.toLocaleString('en-US') || 0}} ￥</th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <!-- /合计 -->

            <!-- / 项目实际情况 -->

            <!-- 履约保证金情况 -->
            <h4 class="ui dividing header blue">履约保证金情况</h4>
            <div class="flex-row flex-end">
                <button class="ui positive icon button" @click="addFirstItem('margins')">
                    <i class="icon plus"></i>
                    <span>新增</span>
                </button>
            </div>
            <div class="ui form form-item">
                <transition-group name="slide-down" tag="div" class="form-wrap bg-hover" id="margins">
                    <div class="relative" style="padding: 20px 10px;" v-for="(item, index) in project.margins" :key="item.id">
                        <div class="ui horizontal divider violet hor-divider">分割线</div>
                        <div class="ui four column doubling stackable grid">
                            <div class="column">
                                <div class="inline fields">
                                    <label class="four wide field">开具单位</label>
                                    <div class="twelve wide field">
                                        <input v-model="item.guarantee_company" type="text" placeholder="请输入开具单位">
                                    </div>
                                </div>
                            </div>
                            <div class="column">
                                <div class="inline fields">
                                    <label class="four wide field">金额</label>
                                    <div class="twelve wide field">
                                        <input v-model.enter="item.guarantee_amount" type="number" placeholder="请输入金额">
                                    </div>
                                </div>
                            </div>
                            <div class="column">
                                <div class="inline fields">
                                    <label class="four wide field">期限</label>
                                    <div class="twelve wide field">
                                        <el-date-picker v-model="item.guarantee_date" type="date" placeholder="请选择期限" value-format="yyyy-MM-dd">
                                        </el-date-picker>
                                    </div>
                                </div>
                            </div>
                            <div class="column">
                                <div class="inline fields">
                                    <label class="four wide field">费用</label>
                                    <div class="twelve wide field icon input">
                                        <input v-model.enter="item.guarantee_cost" type="number" placeholder="请输入费用">
                                        <i class="yen icon"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="column">
                                <div class="inline fields">
                                    <label class="four wide field">其他</label>
                                    <div class="twelve wide field">
                                        <input v-model="item.guarantee_others" type="text" placeholder="请输入其他">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="ui vertical divider margin-divider">
                            <span>保函 — 付款</span>
                        </div>
                        <div class="ui four column doubling stackable grid">
                            <div class="column">
                                <div class="inline fields">
                                    <label class="four wide field">支付日期</label>
                                    <div class="twelve wide field">
                                        <el-date-picker v-model="item.payment_date" type="date" placeholder="请选择支付日期" value-format="yyyy-MM-dd">
                                        </el-date-picker>
                                    </div>
                                </div>
                            </div>
                            <div class="column">
                                <div class="inline fields">
                                    <label class="four wide field">支付金额</label>
                                    <div class="twelve wide field icon input">
                                        <input v-model.enter="item.payment_amount" type="number" placeholder="请输入支付金额">
                                        <i class="yen icon"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="column">
                                <div class="inline fields">
                                    <label class="four wide field">收款人</label>
                                    <div class="twelve wide field">
                                        <input v-model="item.payment_payee" type="text" placeholder="请输入收款人">
                                    </div>
                                </div>
                            </div>
                            <div class="column">
                                <div class="inline fields">
                                    <label class="four wide field">银行</label>
                                    <div class="twelve wide field">
                                        <input v-model="item.payment_bank" type="text" placeholder="请输入银行">
                                    </div>
                                </div>
                            </div>
                            <div class="column">
                                <div class="inline fields">
                                    <label class="four wide field">银行账号</label>
                                    <div class="twelve wide field">
                                        <input v-model.enter="item.payment_account" type="number" placeholder="请输入银行账号">
                                    </div>
                                </div>
                            </div>
                            <div class="column">
                                <div class="inline fields">
                                    <label class="four wide field">回收条件</label>
                                    <div class="twelve wide field">
                                        <input v-model="item.payment_recycle" type="text" placeholder="请输入回收条件">
                                    </div>
                                </div>
                            </div>
                            <button class="ui negative icon button margin-delete" @click="deleteFirstItem('margins', item, index)">
                                <i class="icon minus"></i>
                                <span>删除</span>
                            </button>
                        </div>
                    </div>
                </transition-group>

                <table class="ui celled table center aligned">
                    <thead>
                    <tr>
                        <th colspan="3">合计</th>
                    </tr>
                    <tr>
                        <th>保函总金额</th>
                        <th>保函总费用</th>
                        <th>付款支付总金额</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>@{{ sumMargins.sumGuaranteeAmount.toLocaleString('en-US') }} ￥</td>
                        <td>@{{ sumMargins.sumGuaranteeCost.toLocaleString('en-US') }} ￥</td>
                        <td>@{{ sumMargins.sumPaymentCost.toLocaleString('en-US') }} ￥</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <!-- / 履约保证金情况 -->

            <!-- 收款比例 -->
            <h4 class="ui dividing header blue">收款比例</h4>
            <div class="flex-row flex-end">
                <button class="ui positive icon button" @click="addFirstItem('paymentConditions')">
                    <i class="icon plus"></i>
                    <span>新增</span>
                </button>
            </div>
            <h5 class="ui header right aligned">合计总额：@{{ sumPaymentConditions.toLocaleString('en-US') }} ￥</h5>
            <div class="ui form form-item">
                <div class="ui five column doubling stackable grid">
                    <div class="one wide column form-thead">序号</div>
                    <div class="three wide column form-thead">收款比例</div>
                    <div class="three wide column form-thead">预计金额</div>
                    <div class="eight wide column form-thead">收款条件</div>
                    <div class="one wide column form-thead">操作</div>
                </div>
                <transition-group name="slide-down" tag="div" class="form-wrap special-form">
                    <div class="ui three column doubling stackable grid center aligned" v-for="(item, index) in project.paymentConditions" :key="item.id">
                        <div class="one wide column">
                            <div class="fake-input">@{{index + 1}}</div>
                        </div>
                        <div class="three wide column">
                            <div class="block ui icon input">
                                <input v-model="item.rate" type="number" placeholder="请输入收款比例">
                                <i class="icon percent"></i>
                            </div>
                        </div>
                        <div class="three wide column">
                            <div class="block ui icon input">
                                <input v-model="item.expected" type="number" placeholder="请输入预计金额">
                                <i class="yen icon"></i>
                            </div>
                        </div>
                        <div class="eight wide column">
                            <input type="text" v-model="item.condition" placeholder="请输入收款条件">
                        </div>
                        <div class="one wide column flex-row flex-end">
                            <div class="fake-input">
                                <i class="icon minus red" style="cursor:pointer;" @click="deleteFirstItem('paymentConditions', item, index)"></i>
                            </div>
                        </div>
                    </div>
                </transition-group>
            </div>
            <!-- / 收款比例 -->

            <!-- 合同 -->
            <h4 class="ui dividing header blue">合同</h4>
            <div class="flex-row flex-end">
                <label for="contractUpload" class="ui positive icon button">
                    <i class="icon upload"></i>
                    <span>选择合同文件</span>
                    <input style="display:none;" type="file" id="contractUpload" multiple @change="fileUpload($event)">
                </label>
            </div>
            <div class="ui form form-item">
                <div class="ui five column doubling stackable grid">
                    <div class="one wide column form-thead">序号</div>
                    <div class="fourteen wide column form-thead">名称</div>
                    <div class="one wide column form-thead">操作</div>
                </div>
                <transition-group name="slide-down" tag="div" class="form-wrap special-form">
                    <div class="ui three column doubling stackable grid center aligned" v-for="(item, index) in project.contracts" :key="index">
                        <div class="one wide column">
                            <div class="fake-input">@{{index + 1}}</div>
                        </div>
                        <div class="fourteen wide column">
                            <div class="fake-input">@{{ item.name }}</div>
                        </div>
                        <div class="one wide column flex-row flex-end">
                            <div class="fake-input">
                                <i class="icon minus red" style="cursor:pointer;" @click="deleteFirstItem('contracts', item, index)"></i>
                            </div>
                        </div>
                    </div>
                </transition-group>
            </div>
            <!-- /合同 -->
            <div class="inline-center margin-top-20" @click="submit">
                <button class="ui button green large">
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
    <script src="{{url('js/project_create.js')}}"></script>
@endsection