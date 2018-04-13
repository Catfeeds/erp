@extends('layouts.main')
@section('title','已立项清单')
@section('content')
    <!-- 没有导航的单独窗口页面 -->
    <div class="normal-content print-no-padding">

        <div class="ui breadcrumb">
            <a class="section">验收与收款管理</a>
            <div class="divider"> / </div>
            <a class="section" href="{{url('check/list')}}">验收与收款清单</a>
            <div class="divider"> / </div>
            <a class="section" href="{{url('check/detail')}}?id={{$project->id}}">项目明细 - 项目号 15823910212</a>
            <div class="divider"> / </div>
            <div class="active section">收款提示</div>
        </div>

        <h1 class="ui red header blue center aligned">收款提示</h1>
        <div class="invisible" id="checkCreateTips">
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
                            <label class="four wide field">验收日期</label>
                            <div class="twelve wide field">
                                <div class="fake-input">{{$project->acceptance_date}}</div>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="four wide field">履约保证金余额</label>
                            <div class="twelve wide field">
                                <div class="fake-input">{{$project->bail()->sum('price')}}￥</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- / 基本信息 -->

            <!-- 预计收回履约保证金 -->
            <h4 class="ui dividing header blue">预计收回履约保证金</h4>
            <div class="flex-row flex-end">
                <button class="ui positive icon button" @click="addItem('margins')">
                    <i class="icon plus"></i>
                    <span>新增</span>
                </button>
            </div>
            <div class="ui form form-item">
                <div class="ui six column doubling stackable grid">
                    <div class="one wide column form-thead">序号</div>
                    <div class="three wide column form-thead">预计回收日期</div>
                    <div class="two wide column form-thead">预计回收金额</div>
                    <div class="three wide column form-thead">付款人</div>
                    <div class="six wide column form-thead">备注</div>
                    <div class="one wide column form-thead">操作</div>
                </div>
                <transition-group name="slide-down" tag="div" class="form-wrap special-form">
                    <div class="ui six column doubling stackable grid center aligned" v-for="(item,index) in tipsForm.margins" :key="item.id">
                        <div class="one wide column">
                            <div class="fake-input">@{{index + 1}}</div>
                        </div>
                        <div class="three wide column">
                            <el-date-picker v-model="item.pay_date" type="date" placeholder="请选择预计回收日期" value-format="yyyy-MM-dd">
                            </el-date-picker>
                        </div>
                        <div class="two wide column">
                            <div class="block ui icon input">
                                <input v-model.enter="item.price" type="number" placeholder="请输入预计回收金额">
                                <i class="yen icon"></i>
                            </div>
                        </div>
                        <div class="three wide column">
                            <input v-model="item.payee" type="text" placeholder="请输入付款人">
                        </div>
                        <div class="six wide column">
                            <input type="text" v-model="item.remark" placeholder="请输入备注">
                        </div>
                        <div class="one wide column">
                            <div class="fake-input">
                                <i class="icon minus red" style="cursor:pointer;" @click="deleteItem('margins', item, index)"></i>
                            </div>
                        </div>
                    </div>
                </transition-group>
            </div>
            <!-- / 预计收回履约保证金 -->

            <!-- 预计请款 -->
            <h4 class="ui dividing header blue">预计请款</h4>
            <div class="flex-row flex-end">
                <button class="ui positive icon button" @click="addItem('requirepayment')">
                    <i class="icon plus"></i>
                    <span>新增</span>
                </button>
            </div>
            <div class="ui form form-item">
                <div class="ui six column doubling stackable grid">
                    <div class="one wide column form-thead">序号</div>
                    <div class="three wide column form-thead">请款日期</div>
                    <div class="two wide column form-thead">请款金额</div>
                    <div class="three wide column form-thead">付款单位</div>
                    <div class="six wide column form-thead">备注</div>
                    <div class="one wide column form-thead">操作</div>
                </div>
                <transition-group name="slide-down" tag="div" class="form-wrap special-form">
                    <div class="ui six column doubling stackable grid center aligned" v-for="(item,index) in tipsForm.requirepayment" :key="item.id">
                        <div class="one wide column">
                            <div class="fake-input">@{{index + 1}}</div>
                        </div>
                        <div class="three wide column">
                            <el-date-picker v-model="item.pay_date" type="date" placeholder="请选择请款日期" value-format="yyyy-MM-dd">
                            </el-date-picker>
                        </div>
                        <div class="two wide column">
                            <div class="block ui icon input">
                                <input v-model.number="item.price" type="number" placeholder="请输入请款金额">
                                <i class="yen icon"></i>
                            </div>
                        </div>
                        <div class="three wide column">
                            <input v-model="item.payee" type="text" placeholder="请输入付款单位">
                        </div>
                        <div class="six wide column">
                            <input type="text" v-model="item.remark" placeholder="请输入备注">
                        </div>
                        <div class="one wide column">
                            <div class="fake-input">
                                <i class="icon minus red" style="cursor:pointer;" @click="deleteItem('requirepayment', item, index)"></i>
                            </div>
                        </div>
                    </div>
                </transition-group>
            </div>
            <!-- / 预计请款 -->

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
    <script src="{{url('js/check_createTips.js')}}"></script>
@endsection