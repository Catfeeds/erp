@extends('layouts.main')
@section('title','已立项清单')
@section('content')
    <!-- 没有导航的单独窗口页面 -->
    <div class="normal-content print-no-padding">

        <div class="ui breadcrumb">
            <a class="section">采购管理</a>
            <div class="divider"> / </div>
            <a class="section" href="../buy/project_list.html">采购立项清单</a>
            <div class="divider"> / </div>
            <div class="active section">预算外采购</div>
        </div>
        <div id="invoiceType" style="display:none">{{json_encode($invoice)}}</div>
        @if(isset($editData))
            <input type="hidden" id="getId" value="{{$editData['info']->id}}">
            <div id="editData" style="display:none">{{json_encode($editData)}}</div>
            @else
            @endif

        <h1 class="ui red header blue center aligned">预算外采购</h1>
        <div class="invisible" id="buyExtrabudgetary">

            <!-- 选择项目 -->
            <h4 class="ui dividing header blue">选择项目</h4>
            <div class="ui form form-item">
                <div class="ui three column doubling stackable grid">
                    <div class="column">
                        <div class="inline fields">
                            <label class="four wide field">项目编号</label>
                            <div class="twelve wide field">
                                <el-autocomplete popper-class="my-autocomplete" v-model="extrabudgetary.project_number" :fetch-suggestions="querySearchProjectId" placeholder="请输入项目编号"
                                                 @select="handleSelectProjectId">
                                    <i class="el-icon-edit el-input__icon" slot="suffix">
                                    </i>
                                    <template slot-scope="props">
                                        <div class="name" :title="props.item.name">@{{ props.item.number }}</div>
                                        <span class="addr" :title="props.item.name">@{{ props.item.name }}</span>
                                    </template>
                                </el-autocomplete>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="four wide field">项目内容</label>
                            <div class="twelve wide field">
                                <el-autocomplete popper-class="my-autocomplete" v-model="extrabudgetary.project_content" :fetch-suggestions="querySearchProjectContent" placeholder="请输入项目内容"
                                                 @select="handleSelectProjectContent">
                                    <i class="el-icon-edit el-input__icon" slot="suffix">
                                    </i>
                                    <template slot-scope="props">
                                        <div class="name" :title="props.item.name">@{{ props.item.name }}</div>
                                        <span class="addr" :title="props.item.name">@{{ props.item.number }}</span>
                                    </template>
                                </el-autocomplete>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /选择项目 -->

            <!-- 基本信息 -->
            <h4 class="ui dividing header blue">基本信息</h4>
            <div class="ui form form-item">
                <div class="ui three column doubling stackable grid">
                    <div class="column">
                        <div class="inline fields">
                            <label class="four wide field">采购日期</label>
                            <div class="twelve wide field">
                                <el-date-picker v-model="extrabudgetary.info.date" type="date" placeholder="请选择采购日期" value-format="yyyy-MM-dd">
                                </el-date-picker>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="four wide field">供货商名称</label>
                            <div class="twelve wide field">
                                <el-autocomplete popper-class="my-autocomplete" v-model="extrabudgetary.info.supplier_name" :fetch-suggestions="querySearchSupplier"
                                                 placeholder="请输入供货商名称" @select="handleSelectSupplier">
                                    <i class="el-icon-edit el-input__icon" slot="suffix">
                                    </i>
                                    <template slot-scope="props">
                                        <div class="name">@{{ props.item.name }}</div>
                                        <div class="addr">@{{ props.item.bank }}</div>
                                    </template>
                                </el-autocomplete>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="four wide field">供货商收款银行</label>
                            <div class="twelve wide field">
                                <div class="fake-input">@{{ extrabudgetary.info.bank || '暂无数据' }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="four wide field">供货商收款账号</label>
                            <div class="twelve wide field icon input">
                                <div class="fake-input">@{{ extrabudgetary.info.account || '暂无数据' }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="four wide field">付款条件</label>
                            <div class="twelve wide field">
                                <input v-model="extrabudgetary.info.condition" type="text" placeholder="请输入付款条件">
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="four wide field">发票条件</label>
                            <div class="twelve wide field">
                                <el-select v-model="extrabudgetary.info.content" placeholder="请选择内容">
                                    <el-option v-for="item in invoiceType" :key="item.id" :label="item.name" :value="item.id">
                                    </el-option>
                                </el-select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- / 基本信息 -->

            <!-- 采购物料清单 -->
            <h4 class="ui dividing header blue">采购物料清单</h4>
            <div class="flex-row" style="width:50%;">
                <div class="font-bold" style="white-space:nowrap;align-self:flex-end;margin-right:20px;">采购金额</div>
                <div class="fake-input inline-center">@{{ amount.toLocaleString('en-US') || 0 }} ￥</div>
            </div>
            <div class="flex-row flex-end margin-top-20 clearfix" style="justify-content: space-between">
                <div style="width:30%;">
                    <a class="ui button blue" href="{{url('excel/wuliao.xlsx')}}">导出物料清单标准格式</a>
                    <label class="ui button positive">批量导入物料
                        <input style="display:none;" type="file" @change="uploadMaterials($event)">
                    </label>
                </div>
                <div style="width:40%;">
                    <div class="ui action input" style="width:100%;">
                        {{--<el-autocomplete popper-class="my-autocomplete" v-model="newMaterial.name" @input="materialInput" :fetch-suggestions="querySearchMaterial"--}}
                                         {{--placeholder="请输入物料名称" @select="handleSelectMaterial">--}}
                            {{--<i class="el-icon-edit el-input__icon" slot="suffix">--}}
                            {{--</i>--}}
                            {{--<template slot-scope="props">--}}
                                {{--<div class="name">@{{ props.item.name }}</div>--}}
                                {{--<span class="addr">@{{ props.item.model }}</span>--}}
                            {{--</template>--}}
                        {{--</el-autocomplete>--}}
                        <el-autocomplete popper-class="my-autocomplete" v-model="newMaterial.name" @input="materialInput" :fetch-suggestions="querySearchMaterial"
                                         placeholder="请输入物料名称" @select="handleSelectMaterial">
                            <i class="el-icon-edit el-input__icon" slot="suffix">
                            </i>
                            <template slot-scope="props" style="cursor: not-allowed;">
                                <div class="name">@{{ props.item.name }}</div>
                                <span class="addr">@{{ props.item.model }} @{{ props.item.factory }}</span>
                                <div class="addr name" :title="props.item.param">@{{ props.item.param }}</div>
                            </template>
                        </el-autocomplete>
                        <button class="ui mini button positive" @click="addMaterial">添加物料</button>
                    </div>
                </div>
            </div>
            <h4 class="inline-center">采购物料清单</h4>
            <div class="ui form form-item">
                <div class="ui five column doubling stackable grid font-size-13">
                    <div class="two wide column form-thead">物料名称</div>
                    <div class="two wide column form-thead">性能及技术参数</div>
                    <div class="one wide column form-thead">品牌型号</div>
                    <div class="two wide column form-thead">生产厂家</div>
                    <div class="one wide column form-thead">单位</div>
                    <div class="one wide column form-thead">单价</div>
                    <div class="one wide column form-thead">数量</div>
                    <div class="one wide column form-thead">金额</div>
                    <div class="two wide column form-thead">保修截至日期</div>
                    <div class="two wide column form-thead">保修时间</div>
                    <div class="one wide column form-thead">操作</div>
                </div>
                <transition-group name="slide-down" tag="div" class="form-wrap special-form">
                    <div class="ui column doubling stackable grid center aligned" v-for="(item, index) in extrabudgetary.lists" :key="item.own_id">
                        <template v-if="item.__type === 'new'">
                            <div class="two wide column">
                                <input v-model="item.name" type="text" placeholder="物料名称">
                            </div>
                            <div class="two wide column">
                                <input v-model="item.param" type="text" placeholder="性能及技术参数">
                            </div>
                            <div class="one wide column">
                                <input v-model="item.model" type="text" placeholder="品牌型号">
                            </div>
                            <div class="two wide column">
                                <input v-model="item.factory" type="text" placeholder="生产厂家">
                            </div>
                            <div class="one wide column">
                                <input v-model="item.unit" type="text" placeholder="单位">
                            </div>
                            <div class="one wide column">
                                <input v-model.number="item.price" type="number" placeholder="单价">
                            </div>
                        </template>

                        <template v-else>
                            <div class="two wide column">
                                <div class="fake-input">@{{ item.material && item.material.name || '无'}}</div>
                            </div>
                            <div class="two wide column">
                                <div class="fake-input">@{{ item.material && item.material.param || '无'}}</div>
                            </div>
                            <div class="one wide column">
                                <div class="fake-input">@{{ item.material && item.material.model || '无'}}</div>
                            </div>
                            <div class="two wide column">
                                <div class="fake-input">@{{ item.material && item.material.factory || '无'}}</div>
                            </div>
                            <div class="one wide column">
                                <div class="fake-input">@{{ item.material && item.material.unit || '无'}}</div>
                            </div>

                        </template>
                        <div class="one wide column">
                            <input v-model.number="item.price" type="number" min="0" placeholder="单价">
                        </div>
                        <div class="one wide column">
                            <input v-model.number="item.number" type="number" min="0" placeholder="数量">
                        </div>
                        <div class="one wide column">
                            {{--<input v-model.number="item.cost" type="number" placeholder="金额">--}}
                            <div class="fake-input">@{{ ((item.price || 0)*(item.number || 0)).toLocaleString('en-US') }}</div>
                        </div>
                        <div class="two wide column">
                            <el-date-picker v-model="item.warranty_date" type="date" placeholder="截至日期" value-format="yyyy-MM-dd">
                            </el-date-picker>
                        </div>
                        <div class="two wide column">
                            <input v-model="item.warranty_time" type="text" placeholder="保修时间">
                        </div>
                        <div class="one wide column flex-row">
                            <div class="fake-input">
                                <i class="icon minus red" style="cursor:pointer;" @click="deleteItem('lists', item, index)"></i>
                            </div>
                        </div>
                    </div>
                </transition-group>
            </div>

            <!-- /采购物料清单 -->

            <!-- 合同 -->
            <h4 class="ui dividing header blue">合同</h4>
            <div class="flex-row flex-end">
                <label class="ui icon button positive">
                    <i class="icon upload"></i>
                    <span>添加合同</span>
                    <input style="display:none;" type="file" multiple @change="uploadContract($event)">
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
                    <div class="ui column doubling stackable grid center aligned" v-for="(item, index) in extrabudgetary.contracts" :key="item.id">
                        <div class="two wide column">
                            <div class="fake-input">@{{ index + 1 }}</div>
                        </div>
                        <div class="six wide column">
                            <div class="fake-input">@{{ item.name }}</div>
                        </div>
                        <div class="six wide column">
                            <div class="fake-input">
                                <a :href="item.href" target="_blank">@{{ item.href }}</a>
                            </div>
                        </div>
                        <div class="two wide column flex-row">
                            <div class="fake-input">
                                <i class="icon minus red" style="cursor:pointer;" @click="deleteItem('contracts', item, index)"></i>
                            </div>
                        </div>
                    </div>
                </transition-group>
            </div>
            <!-- /合同 -->
            <div class="inline-center margin-top-20">
                <button class="ui button green large" @click="submitForm">
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
    <script src="{{url('js/buy_extrabudgetary.js')}}"></script>
@endsection