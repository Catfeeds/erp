@extends('layouts.main_no_nav')
@section('title','费用申请录入')
@section('content')
    <!-- 没有导航的单独窗口页面 -->
    <div class="normal-content print-no-padding">

        <div class="ui breadcrumb">
            <a class="section">费用付款管理</a>
            <div class="divider"> / </div>
            <a class="section" >付款审批清单</a>
            <div class="divider"> / </div>
            <div class="active section">费用申请</div>
        </div>

        <input type="hidden" value="{{\Illuminate\Support\Facades\Auth::user()->username}}" id="applyUser">
        <div id="invoiceType" style="display: none">{{json_encode($types)}}</div>
        <div id="addEdit" style="display: none">{{json_encode($data)}}</div>
        <h1 class="ui header blue aligned center">费用申请</h1>
        <div id="payAdd">
            <h4 class="ui dividing header blue">信息录入</h4>

            <div class="ui form">
                <div class="ui three column doubling stackable grid">
                    <div class="column">
                        <div class="inline fields">
                            <label class="six wide field flex-center">申请日期</label>
                            <div class="eleven wide field">
                                <el-date-picker v-model="payForm.apply_date" type="date" placeholder="请选择申请日期" value-format="yyyy-MM-dd">
                                </el-date-picker>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="six wide field flex-center">付款金额</label>
                            <div class="eleven wide field">
                                <input type="number" v-model.number="payForm.apply_price" placeholder="请输入付款金额">
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="six wide field flex-center">收款人</label>
                            <div class="eleven wide field">
                                <el-autocomplete popper-class="my-autocomplete" v-model="payForm.payee" :fetch-suggestions="querySearchPayee" placeholder="请输入收款人"
                                                 @select="handleSelectPayee">
                                    <i class="el-icon-edit el-input__icon" slot="suffix">
                                    </i>
                                    <template slot-scope="props">
                                        <div class="name">@{{ props.item.name }}</div>
                                        <span class="addr">@{{ props.item.bank }} @{{ props.item.account }}</span>
                                    </template>
                                </el-autocomplete>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="six wide field flex-center">收款银行</label>
                            <div class="eleven wide field">
                                <div class="fake-input">@{{ currentSupplier.bank || '无' }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="six wide field flex-center">收款账号</label>
                            <div class="eleven wide field">
                                <div class="fake-input">@{{ currentSupplier.account || '无' }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="six wide field flex-center">费用类型</label>
                            <div class="eleven wide field">
                                <el-select :value="payForm.pay_type" @change="handlePayTypeChange" placeholder="费用类型">
                                    <el-option v-for="item in payType" :key="item.id" :label="item.title" :value="item.id">
                                    </el-option>
                                </el-select>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="six wide field flex-center">具体事项</label>
                            <div class="eleven wide field">
                                <el-select v-model="payForm.pay_detail" placeholder="具体事项">
                                    <el-option v-for="item in payDetail" :key="item.id" :label="item.title" :value="item.id">
                                    </el-option>
                                </el-select>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="six wide field flex-center">用途</label>
                            <div class="eleven wide field">
                                <input type="text" v-model="payForm.application" placeholder="请输入用途">
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="six wide field flex-center">备注</label>
                            <div class="eleven wide field">
                                <input type="text" v-model="payForm.remark" placeholder="请输入备注">
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="six wide field flex-center">项目编号</label>
                            <div class="eleven wide field">
                                <el-autocomplete popper-class="my-autocomplete" v-model="payForm.project_number" :fetch-suggestions="querySearchProjectId"
                                                 placeholder="请输入项目编号" @select="handleSelectProjectId">
                                    <i class="el-icon-edit el-input__icon" slot="suffix">
                                    </i>
                                    <template slot-scope="props">
                                        <div class="name">@{{ props.item.number }}</div>
                                        <span class="addr">@{{ props.item.name }}</span>
                                    </template>
                                </el-autocomplete>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="six wide field flex-center">项目内容</label>
                            <div class="eleven wide field">
                                <el-autocomplete popper-class="my-autocomplete" v-model="payForm.project_content" :fetch-suggestions="querySearchProjectContent"
                                                 placeholder="请输入项目内容" @select="handleSelectProjectContent">
                                    <i class="el-icon-edit el-input__icon" slot="suffix">
                                    </i>
                                    <template slot-scope="props">
                                        <div class="name">@{{ props.item.name }}</div>
                                        <span class="addr">@{{ props.item.number }}</span>
                                    </template>
                                </el-autocomplete>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="six wide field flex-center">付款方式</label>
                            <div class="eleven wide field">
                                <el-select v-model="payForm.type" placeholder="付款方式">
                                    <el-option v-for="item in [{id:1,name:'现金'},{id:2,name:'转账'}]" :key="item.id" :label="item.name" :value="item.id">
                                    </el-option>
                                </el-select>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="six wide field flex-center">发票类型</label>
                            <div class="eleven wide field">
                                <el-select v-model="payForm.invoice_type" placeholder="发票类型">
                                    <el-option v-for="item in invoiceType" :key="item.id" :label="item.name" :value="item.id">
                                    </el-option>
                                </el-select>
                            </div>
                        </div>
                    </div>
                </div>

                <h4 class="ui dividing header blue">合同录入</h4>
                <div class="flex-row flex-end">
                    <label class="ui icon button positive" for="upload">
                        <i class="icon upload"></i>
                        <span>添加合同</span>
                        <input style="display:none;" id="upload" accept="image/jpg,image/jpeg,application/pdf" type="file"  @change="uploadContract($event)">
                    </label>
                </div>
                <h4 class="inline-center">合同清单</h4>
                <div class="ui form form-item">
                    <div class="ui five column doubling stackable grid font-size-13">
                        <div class="two wide column form-thead">序号</div>
                        <div class="six wide column form-thead">合同名称</div>
                        <div class="six wide column form-thead">访问地址</div>
                        <div class="two wide column form-thead">操作</div>
                    </div>
                    <transition-group name="slide-down" tag="div" class="form-wrap special-form">
                        <div class="ui column doubling stackable grid center aligned" v-for="(item, index) in payForm.pictures" :key="item.id">
                            <div class="two wide column">
                                <div class="fake-input">@{{ index + 1 }}</div>
                            </div>
                            <div class="six wide column">
                                <div class="fake-input">@{{ item.name }}</div>
                            </div>
                            <div class="six wide column">
                                <div class="fake-input">
                                    <a :href="item.url" target="_blank">@{{ item.url }}</a>
                                </div>
                            </div>
                            <div class="two wide column flex-row">
                                <div class="fake-input">
                                    <i class="icon minus red" style="cursor:pointer;" @click="deleteItem(index)"></i>
                                </div>
                            </div>
                        </div>
                    </transition-group>
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
    <script src="{{url('js/new_pay_add.js')}}"></script>
@endsection