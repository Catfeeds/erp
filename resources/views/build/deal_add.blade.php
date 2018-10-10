@extends('layouts.main')
@section('title','已立项清单')
@section('content')
    <!-- 没有导航的单独窗口页面 -->
    <div class="normal-content print-no-padding">

        <div class="ui breadcrumb">
            <a class="section">施工管理</a>
            <div class="divider"> / </div>
            <a class="section" >备案合同清单</a>
            <div class="divider"> / </div>
            <div class="active section">录入合同</div>
        </div>

        <h1 class="ui red header blue center aligned">录入合同</h1>
        <div class="invisible" id="buildDealAdd">
            <h4 class="ui dividing header blue">基本信息</h4>
            <div class="ui form">
                <div class="ui three column doubling stackable grid">
                    <div class="column">
                        <div class="inline fields">
                            <label class="six wide field flex-center">合同日期</label>
                            <div class="eleven wide field">
                                <el-date-picker v-model="buildDealAdd.date" type="date" placeholder="请选择合同日期" value-format="yyyy-MM-dd">
                                </el-date-picker>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="six wide field flex-center">施工队</label>
                            <div class="eleven wide field">
                                <el-autocomplete popper-class="my-autocomplete" v-model="buildDealAdd.build_name" :fetch-suggestions="querySearchBuild" placeholder="请输入施工队"
                                                 @select="handleSelectBuild">
                                    <i class="el-icon-edit el-input__icon" slot="suffix">
                                    </i>
                                    <template slot-scope="props">
                                        <div class="name">@{{ props.item.name }}</div>
                                        <span class="addr">@{{ props.item.manager }}</span>
                                    </template>
                                </el-autocomplete>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="six wide field flex-center">施工经理</label>
                            <div class="eleven wide field">
                                <div class="fake-input">@{{ buildDealAdd.build_manager || '暂无' }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="six wide field flex-center">项目编号</label>
                            <div class="eleven wide field">
                                <el-autocomplete popper-class="my-autocomplete" v-model="buildDealAdd.project_number" :fetch-suggestions="querySearchProjectId"
                                                 placeholder="请输入项目编号" @select="handleSelectProjectId">
                                    <i class="el-icon-edit el-input__icon" slot="suffix">
                                    </i>
                                    <template slot-scope="props">
                                        <div class="name" :title="props.item.name">@{{ props.item.number }}</div>
                                        <span class="addr" :title="props.item.name">@{{ props.item.pm }}</span>
                                    </template>
                                </el-autocomplete>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="six wide field flex-center">项目内容</label>
                            <div class="eleven wide field">
                                <el-autocomplete popper-class="my-autocomplete" v-model="buildDealAdd.project_content" :fetch-suggestions="querySearchProjectContent"
                                                 placeholder="请输入项目内容" @select="handleSelectProjectContent">
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
                    <div class="column">
                        <div class="inline fields">
                            <label class="six wide field flex-center">项目经理</label>
                            <div class="eleven wide field">
                                <div class="fake-input">@{{ buildDealAdd.project_manager || '暂无' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <h4 class="ui dividing header blue">合同录入</h4>
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
                    <div class="ui column doubling stackable grid center aligned" v-for="(item, index) in buildDealAdd.list" :key="item.id">
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
                                <i class="icon minus red" style="cursor:pointer;" @click="deleteItem('list', item, index)"></i>
                            </div>
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
        </div>

    </div>
    <!-- /主体内容 === 不可复用 -->
@endsection
@section('pageJs')
    <script src="{{url('js/build_deal_add.js')}}"></script>
@endsection