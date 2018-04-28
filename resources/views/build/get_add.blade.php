@extends('layouts.main_no_nav')
@section('title','已立项清单')
@section('content')
    <!-- 没有导航的单独窗口页面 -->
    <div class="normal-content print-no-padding">

        <div class="ui breadcrumb">
            <a class="section">施工管理</a>
            <div class="divider"> / </div>
            <a class="section" href="../build/get_list.html">施工收票清单</a>
            <div class="divider"> / </div>
            <a class="section" href="../build/get_single.html?id=CG12512312521">施工收票查询 </a>
            <div class="divider"> / </div>
            <div class="active section">收票信息录入</div>
        </div>
        <h1 class="ui red header blue center aligned">收票信息录入</h1>

        <div id="invoiceType" style="display:none">{{json_encode($invoices)}}</div>

        <div class="invisible" id="buildGetAdd">

            <!-- 收票信息 -->
            <h4 class="ui dividing header blue">收票信息</h4>
            <div class="ui form form-item">
                <div class="ui three column doubling stackable grid">
                    <div class="column">
                        <div class="inline fields">
                            <label class="four wide field">收票日期</label>
                            <div class="twelve wide field">
                                <el-date-picker v-model="invoiceCreate.date" type="date" placeholder="请选择收票日期" value-format="yyyy-MM-dd">
                                </el-date-picker>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="four wide field">收票经办人</label>
                            <div class="twelve wide field">
                                <div class="fake-input">{{\Illuminate\Support\Facades\Auth::user()->username}}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /收票信息 -->

            <!-- 收票录入 -->
            <h4 class="ui dividing header blue">收票录入</h4>
            <div class="flex-row flex-end">
                <button class="ui icon button positive" @click="addItem">
                    <i class="icon plus"></i>
                    <span>添加发票</span>
                </button>
            </div>
            <h4 class="inline-center">发票清单</h4>
            <div class="ui form form-item margin-top-50">
                <div class="ui five column doubling stackable grid font-size-13">
                    <div class="one wide column form-thead">序号</div>
                    <div class="two wide column form-thead">开票日期</div>
                    <div class="three wide column form-thead">发票号码</div>
                    <div class="two wide column form-thead">发票类型</div>
                    <div class="two wide column form-thead">不含税金额</div>
                    <div class="two wide column form-thead">税额</div>
                    <div class="two wide column form-thead">含税金额</div>
                    <div class="two wide column form-thead">操作</div>
                </div>
                <transition-group name="slide-down" tag="div" class="form-wrap special-form">
                    <div class="ui column doubling stackable grid center aligned" v-for="(item, index) in invoiceCreate.lists" :key="item.id">
                        <div class="one wide column">
                            <div class="fake-input">@{{ index + 1 }}</div>
                        </div>
                        <div class="two wide column">
                            <el-date-picker v-model="item.date" type="date" placeholder="开票日期" value-format="yyyy-MM-dd">
                            </el-date-picker>
                        </div>
                        <div class="three wide column">
                            <input type="text" v-model="item.number" placeholder="发票号码">
                        </div>
                        <div class="two wide column">
                            <el-select v-model="item.type" placeholder="发票类型">
                                <el-option v-for="item in invoiceType" :key="item.id" :label="item.name" :value="item.id">
                                </el-option>
                            </el-select>
                        </div>
                        <div class="two wide column">
                            <input type="text" v-model.number="item.without_tax" placeholder="不含税">
                        </div>
                        <div class="two wide column">
                            <input type="text" v-model.number="item.tax" placeholder="税额">
                        </div>
                        <div class="two wide column">
                            <input type="text" v-model.number="item.with_tax" placeholder="含税金额">
                        </div>
                        <div class="two wide column">
                            <div class="fake-input">
                                <i class="icon minus red" style="cursor:pointer;" @click="deleteItem('lists', item, index)"></i>
                            </div>
                        </div>
                    </div>
                </transition-group>
            </div>
            <!-- /收票录入 -->
            <div class="inline-center margin-top-20">
                <button class="ui button green large" @click="submitForm">
                    <i class="icon hand pointer"></i>
                    <span>提交</span>
                </button>
            </div>
        </div>

    </div>
    <!-- /主体内容 === 不可复用 -->
@endsection
@section('pageJs')
    <script src="{{url('js/build_get_add.js')}}"></script>
@endsection