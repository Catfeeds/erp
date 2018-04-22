@extends('layouts.main')
@section('title','已立项清单')
@section('content')
    <!-- 没有导航的单独窗口页面 -->
    <div class="normal-content print-no-padding">

        <div class="ui breadcrumb">
            <a class="section">验收与收款管理</a>
            <div class="divider"> / </div>
            <a class="section" href="../check/list.html">验收与收款清单</a>
            <div class="divider"> / </div>
            <a class="section" href="../check/detail.html">项目明细 - 项目号 {{$project->number}}</a>
            <div class="divider"> / </div>
            <div class="active section">开票</div>
        </div>

        <input type="hidden" id="projectId" value="{{$project->id}}">
        <div id="invoiceType" style="display:none">{{json_encode($invoice)}}</div>

        <h1 class="ui red header blue center aligned">开票</h1>
        <div class="invisible" id="checkInvoice">
            <!-- 基本信息 -->
            <h4 class="ui dividing header blue">基本信息</h4>
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
                                <el-autocomplete popper-class="my-autocomplete" v-model="invoiceForm.payee" :fetch-suggestions="querySearchCompany" placeholder="请输入付款单位"
                                                 @select="handleSelectCompany">
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
                            <label class="four wide field">开票日期</label>
                            <div class="twelve wide field">
                                <el-date-picker v-model="invoiceForm.date" type="date" placeholder="请选择开票日期" value-format="yyyy-MM-dd">
                                </el-date-picker>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="four wide field">税率</label>
                            <div class="twelve wide field">
                                <el-select v-model="invoiceForm.rate" placeholder="请选择税率">
                                    <el-option v-for="item in invoiceType" :key="item.id" :label="item.value + '%'" :value="item.id">
                                    </el-option>
                                </el-select>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="four wide field">开票金额</label>
                            <div class="twelve wide field icon input">
                                <input v-model.enter="invoiceForm.price" type="number" placeholder="请输入开票金额">
                                <i class="yen icon"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- / 基本信息 -->

            <!-- 发票录入 -->
            <h4 class="ui dividing header blue">发票录入</h4>
            <div class="flex-row flex-end">
                <button class="ui positive icon button" @click="addItem('lists')">
                    <i class="icon plus"></i>
                    <span>新增</span>
                </button>
            </div>
            <div class="ui form form-item">
                <div class="ui six column doubling stackable grid">
                    <div class="one wide column form-thead">序号</div>
                    <div class="three wide column form-thead">发票号码</div>
                    <div class="two wide column form-thead">含税销售额</div>
                    <div class="three wide column form-thead">税额</div>
                    <div class="three wide column form-thead">不含税销售额</div>
                    <div class="three wide column form-thead">摘要</div>
                    <div class="one wide column form-thead">操作</div>
                </div>
                <transition-group name="slide-down" tag="div" class="form-wrap special-form">
                    <div class="ui six column doubling stackable grid center aligned" v-for="(item,index) in invoiceForm.lists" :key="item.id">
                        <div class="one wide column">
                            <div class="fake-input">@{{index + 1}}</div>
                        </div>
                        <div class="three wide column">
                            <input v-model="item.number" type="text" placeholder="请输入发票号码">
                        </div>
                        <div class="two wide column">
                            <div class="block ui icon input">
                                <input v-model.number="item.with_tax" type="number" placeholder="请输入含税销售额">
                                <i class="yen icon"></i>
                            </div>
                        </div>
                        <div class="three wide column">
                            <div class="block ui icon input">
                                <input v-model.number="item.tax" type="number" placeholder="请输入税额">
                                <i class="yen icon"></i>
                            </div>
                        </div>
                        <div class="three wide column">
                            <div class="block ui icon input">
                                <input v-model.number="item.without_tax" type="number" placeholder="请输入不含税销售额">
                                <i class="yen icon"></i>
                            </div>
                        </div>
                        <div class="three wide column">
                            <input type="text" v-model="item.remark" placeholder="请输入备注">
                        </div>
                        <div class="one wide column flex-row flex-end">
                            <div class="fake-input">
                                <i class="icon minus red" style="cursor:pointer;" @click="deleteItem('lists', item, index)"></i>
                            </div>
                        </div>
                    </div>
                </transition-group>
            </div>
            <!-- / 发票录入 -->


            <div class="inline-center margin-top-20">
                <button class="ui button green large" @click="submit">
                    <i class="icon hand pointer"></i>
                    <span>提交</span>
                </button>
            </div>
        </div>

    </div>
    <!-- /主体内容 === 不可复用 -->
@endsection
@section('pageJs')
    <script src="{{url('js/check_invoice.js')}}"></script>
@endsection