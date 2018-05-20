@extends('layouts.main_no_nav')
@section('title','已立项清单')
@section('content')
    <!-- 没有导航的单独窗口页面 -->
    <div class="normal-content print-no-padding">

        <div class="ui breadcrumb">
            <a class="section">报销与借款管理</a>
            <div class="divider"> / </div>
            <a class="section" href="../pay/pay_list.html">报销付款清单</a>
            <div class="divider"> / </div>
            <div class="active section">新增报销付款</div>
        </div>

        <div style="display: none" id="banks">{{json_encode($bank)}}</div>

        <h1 class="ui header blue aligned center">新增报销付款</h1>
        <div id="loanPayAdd" class="invisible">
            <h4 class="ui dividing header blue">信息录入</h4>

            <div class="ui form">
                <div class="ui three column doubling stackable grid">
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
                            <label class="six wide field flex-center">报销人</label>
                            <div class="eleven wide field">
                                <el-autocomplete popper-class="my-autocomplete" v-model="loanForm.name" :fetch-suggestions="querySearchMen" placeholder="请输入报销人"
                                                 @select="handleSelectMen">
                                    <i class="el-icon-edit el-input__icon" slot="suffix">
                                    </i>
                                    <template slot-scope="props">
                                        <div class="name">@{{ props.item.name }}</div>
                                    </template>
                                </el-autocomplete>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <h4 class="inline-center">未付款报销清单</h4>
            <h5 class="ui header right aligned">合计总额：@{{ listAmount.toLocaleString('en-US') }} ￥</h5>
            <div class="ui form form-item">
                <div class="ui five column doubling stackable grid font-size-13">
                    <div class="two wide column form-thead">未支付报销单</div>
                    <div class="three wide column form-thead">报销编号</div>
                    <div class="three wide column form-thead">报销金额</div>
                    <div class="three wide column form-thead">复核人</div>
                    <div class="three wide column form-thead">审批人</div>
                    <div class="two wide column form-thead">操作</div>
                </div>
                <template v-if="currentList.length">
                    <transition-group name="slide-down" tag="div" class="form-wrap special-form">
                        <div class="ui column doubling stackable grid center aligned" v-for="(item, index) in currentList" :key="item.id">
                            <div class="two wide column">
                                <div class="fake-input">@{{ index + 1 }}</div>
                            </div>
                            <div class="three wide column">
                                <div class="fake-input">@{{ item.number }}</div>
                            </div>
                            <div class="three wide column">
                                <div class="fake-input">@{{ item.price.toLocaleString('en-US') }}￥</div>
                            </div>
                            <div class="three wide column">
                                <div class="fake-input">@{{ item.checker }}</div>
                            </div>
                            <div class="three wide column">
                                <div class="fake-input">@{{ item.passer }}</div>
                            </div>
                            <div class="two wide column">
                                <div class="fake-input" style="margin-top:-2px;">
                                    <el-checkbox v-model="item.checked">付款</el-checkbox>
                                </div>
                            </div>
                        </div>
                    </transition-group>
                </template>
                <template v-else>
                    <div class="form-wrap special-form">
                        <div class="sixteen wide column flex-row">
                            <div class="fake-input inline-center">暂无数据</div>
                        </div>
                    </div>
                </template>
            </div>

            <div class="inline-center margin-top-20">
                <button class="ui button primary large" @click="confirmList">
                    <i class="icon hand pointer"></i>
                    <span>确定</span>
                </button>
            </div>


            <el-dialog title="确认信息" :visible.sync="submitConfirmDialog" width="90%" center>

                <div class="ui form">
                    <div class="ui three column doubling stackable grid">
                        <div class="column">
                            <div class="inline fields">
                                <label class="six wide field flex-center">付款日期</label>
                                <div class="eleven wide field">
                                    <div class="fake-input">@{{ loanForm.date }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="column">
                            <div class="inline fields">
                                <label class="six wide field flex-center">报销人</label>
                                <div class="eleven wide field">
                                    <div class="fake-input">@{{ loanForm.name }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="column">
                            <div class="inline fields">
                                <label class="six wide field flex-center">借款余额</label>
                                <div class="eleven wide field">
                                    <div class="fake-input">@{{ current_count.toLocaleString('en-US') }}￥</div>
                                </div>
                            </div>
                        </div>
                        <div class="column">
                            <div class="inline fields">
                                <label class="six wide field flex-center">抵扣借款金额</label>
                                <div class="eleven wide field">
                                    <input type="number" v-model.number="loanForm.daduction" placeholder="抵扣借款金额">
                                </div>
                            </div>
                        </div>
                        <div class="column">
                            <div class="inline fields">
                                <label class="six wide field flex-center">现金付款金额</label>
                                <div class="eleven wide field">
                                    <input type="number" v-model.number="loanForm.cash" placeholder="现金付款金额">
                                </div>
                            </div>
                        </div>
                        <div class="column">
                            <div class="inline fields">
                                <label class="six wide field flex-center">银行转账金额</label>
                                <div class="eleven wide field">
                                    <input type="number" v-model.number="loanForm.transfer" placeholder="银行转账金额">
                                </div>
                            </div>
                        </div>
                        <div class="column">
                            <div class="inline fields">
                                <label class="six wide field flex-center">付款银行</label>
                                <div class="eleven wide field">
                                    <el-select v-model="loanForm.bank_index" placeholder="请输入转账银行" @change="bankChange">
                                        <el-option v-for="(item, index) in bankList" :key="item.id" :label="item.name" :value="index">
                                        </el-option>
                                    </el-select>
                                </div>
                            </div>
                        </div>
                        <div class="column">
                            <div class="inline fields">
                                <label class="six wide field flex-center">转账账号</label>
                                <div class="eleven wide field">
                                    <div class="fake-input">@{{ loanForm.account || '暂无' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <h5 class="ui header right aligned">合计总额：@{{ checkAmount.toLocaleString('en-US') }} ￥</h5>
                <div class="ui form form-item">
                    <div class="ui five column doubling stackable grid font-size-13">
                        <div class="three wide column form-thead">未支付报销单</div>
                        <div class="four wide column form-thead">报销编号</div>
                        <div class="three wide column form-thead">报销金额</div>
                        <div class="three wide column form-thead">复核人</div>
                        <div class="three wide column form-thead">审批人</div>
                    </div>
                    <transition-group name="slide-down" tag="div" class="form-wrap special-form">
                        <div class="ui column doubling stackable grid center aligned" v-for="(item, index) in currentCheckedList" :key="item.value.id">
                            <div class="three wide column">
                                <div class="fake-input">@{{ index + 1 }}</div>
                            </div>
                            <div class="four wide column">
                                <div class="fake-input">@{{ item.value.number }}</div>
                            </div>
                            <div class="three wide column">
                                <div class="fake-input">@{{ item.value.price.toLocaleString('en-US') }}￥</div>
                            </div>
                            <div class="three wide column">
                                <div class="fake-input">@{{ item.value.checker }}</div>
                            </div>
                            <div class="three wide column">
                                <div class="fake-input">@{{ item.value.passer }}</div>
                            </div>
                        </div>
                    </transition-group>
                </div>
                <div class="inline-center margin-top-20">
                    <button class="ui button primary large" @click="submit">
                        <i class="icon hand pointer"></i>
                        <span>提交</span>
                    </button>
                </div>
            </el-dialog>

        </div>
    </div>
    <!-- /主体内容 === 不可复用 -->
@endsection
@section('pageJs')
    <script src="{{url('js/loan_pay_add.js')}}"></script>
@endsection