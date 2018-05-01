@extends('layouts.main')
@section('title','已立项清单')
@section('content')
    <!-- 没有导航的单独窗口页面 -->
    <div class="normal-content print-no-padding">

        <div class="ui breadcrumb">
            <a class="section">施工管理</a>
            <div class="divider"> / </div>
            <a class="section" href="../build/finish_list.html">完工请款清单</a>
            <div class="divider"> / </div>
            <div class="active section">新增请款</div>
        </div>

        <h4 class="ui dividing header blue">基本信息</h4>
        <div class="invisible" id="buildFinishAdd">

            <div class="ui form">
                <div class="ui three column doubling stackable grid">
                    <div class="column">
                        <div class="inline fields">
                            <label class="six wide field flex-center">施工队</label>
                            <div class="eleven wide field">
                                <el-autocomplete popper-class="my-autocomplete" v-model="buildFinishAdd.build_name" :fetch-suggestions="querySearchBuild"
                                                 placeholder="请输入施工队" @select="handleSelectBuild">
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
                                <div class="fake-input">@{{ buildFinishAdd.build_manager || '暂无' }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="six wide field flex-center">项目编号</label>
                            <div class="eleven wide field">
                                <el-autocomplete popper-class="my-autocomplete" v-model="buildFinishAdd.project_id" :fetch-suggestions="querySearchProjectId"
                                                 placeholder="请输入项目编号" @select="handleSelectProjectId">
                                    <i class="el-icon-edit el-input__icon" slot="suffix">
                                    </i>
                                    <template slot-scope="props">
                                        <div class="name">@{{ props.item.number }}</div>
                                        <span class="addr">@{{ props.item.pm }}</span>
                                    </template>
                                </el-autocomplete>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="six wide field flex-center">项目内容</label>
                            <div class="eleven wide field">
                                <el-autocomplete popper-class="my-autocomplete" v-model="buildFinishAdd.project_content" :fetch-suggestions="querySearchProjectContent"
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
                            <label class="six wide field flex-center">项目经理</label>
                            <div class="eleven wide field">
                                <div class="fake-input">@{{ buildFinishAdd.project_manager || '暂无' }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="six wide field flex-center">请款日期</label>
                            <div class="eleven wide field">
                                <el-date-picker v-model="buildFinishAdd.date" type="date" placeholder="请选择请款日期" value-format="yyyy-MM-dd">
                                </el-date-picker>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="six wide field flex-center">请款金额</label>
                            <div class="eleven wide field">
                                <input type="number" v-model.number="buildFinishAdd.price" placeholder="请选择请款金额">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <h4 class="ui dividing header blue">请款添加</h4>
            <h4 class="ui header center aligned">请款清单</h4>
            <div class="flex-row flex-end">
                <div class="ui mini button positive">Excel 导入</div>
                <div class="ui mini button positive" @click="addItem('list')">手工添加</div>
            </div>
            <h5 class="ui header right aligned">合计总额：@{{ sumAmount.toLocaleString('en-US') }} ￥</h5>
            <div class="ui form form-item">
                <div class="ui five column doubling stackable grid font-size-13">
                    <div class="two wide column form-thead">设备名称</div>
                    <div class="two wide column form-thead">性能参数</div>
                    <div class="two wide column form-thead">数量</div>
                    <div class="two wide column form-thead">单位</div>
                    <div class="two wide column form-thead">含税单价</div>
                    <div class="two wide column form-thead">含税总价</div>
                    <div class="two wide column form-thead">备注</div>
                    <div class="two wide column form-thead">操作</div>
                </div>
                <transition-group name="slide-down" tag="div" class="form-wrap special-form">
                    <div class="ui column doubling stackable grid center aligned" v-for="(item, index) in buildFinishAdd.lists" :key="item.id">
                        <div class="two wide column">
                            <input type="text" placeholder="设备名称" v-model="item.name">
                        </div>
                        <div class="two wide column">
                            <input type="text" placeholder="性能参数" v-model="item.para">
                        </div>
                        <div class="two wide column">
                            <input type="text" placeholder="数量" v-model.number="item.number">
                        </div>
                        <div class="two wide column">
                            <input type="text" placeholder="单位" v-model="item.unit">
                        </div>
                        <div class="two wide column">
                            <input type="number" v-model.number="item.price" placeholder="含税单价">
                        </div>
                        <div class="two wide column">
                            <input type="number" v-model.number="item.total" placeholder="含税总价">
                        </div>
                        <div class="two wide column">
                            <input type="text" placeholder="备注" v-model="item.remark">
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
    <script src="{{url('js/build_finish_add.js')}}"></script>
@endsection