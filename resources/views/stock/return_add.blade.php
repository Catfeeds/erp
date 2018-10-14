@extends('layouts.main_no_nav')
@section('title','新增退料入库录入')
@section('content')
    <!-- 没有导航的单独窗口页面 -->
    <div class="normal-content print-no-padding">

        <div class="ui breadcrumb">
            <a class="section">库存管理</a>
            <div class="divider"> / </div>
            <a class="section" >退料入货清单</a>
            <div class="divider"> / </div>
            <div class="active section">新增退料入库录入</div>
        </div>

        <input type="hidden" id="returneeVal" value="{{\Illuminate\Support\Facades\Auth::user()->username}}">

        <h1 class="ui red header blue center aligned">新增退料入库录入</h1>
        <div class="invisible" id="returnAdd">
            <h4 class="ui dividing header blue">基本信息</h4>
            <div class="ui form">
                <div class="ui three column doubling stackable grid">
                    <div class="column">
                        <div class="inline fields">
                            <label class="four wide field flex-center">项目编号</label>
                            <div class="twelve wide field">
                                <el-autocomplete popper-class="my-autocomplete" v-model="stockReturnAdd.project_number" :fetch-suggestions="querySearch" placeholder="请输入项目编号"
                                                 @select="handleSelect">
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
                            <label class="four wide field flex-center">项目内容</label>
                            <div class="twelve wide field">
                                <el-autocomplete popper-class="my-autocomplete" v-model="stockReturnAdd.project_content" :fetch-suggestions="querySearchContent"
                                                 placeholder="请输入项目内容" @select="handleSelect">
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
                            <label class="four wide field flex-center">项目经理</label>
                            <div class="twelve wide field">
                                <div class="fake-input">@{{ stockReturnAdd.project_manger || '暂无' }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="four wide field flex-center">退料人</label>
                            <div class="twelve wide field">
                                <input type="text" v-model="stockReturnAdd.returnee" placeholder="请输入退料人">
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="four wide field flex-center">入库仓库</label>
                            <div class="twelve wide field">
                                <el-autocomplete popper-class="my-autocomplete" v-model="stockReturnAdd.warehouse_name" :fetch-suggestions="querySearchStock"
                                                 placeholder="请输入入库仓库" @select="handleSelectStock">
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
                            <label class="four wide field flex-center">收货人</label>
                            <div class="twelve wide field">
                                <input type="text" v-model="stockReturnAdd.worker" placeholder="请输入收货人">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <h4 class="ui dividing header blue">退料入库录入</h4>
            <div class="ui form">
                <div class="ui three column doubling stackable grid">
                    <div class="column wide">
                        <div class="inline fields">
                            <label class="four wide field flex-center">物料名称</label>
                            <div class="twelve wide field">
                                <el-autocomplete popper-class="my-autocomplete" v-model="currentMaterialName" :fetch-suggestions="querySearchMaterial" placeholder="请输入物料名称"
                                                 @select="handleSelectMaterial">
                                    <i class="el-icon-edit el-input__icon" slot="suffix">
                                    </i>
                                    <template slot-scope="props" style="cursor: not-allowed;">
                                        <div class="name">@{{ props.item.name }}</div>
                                        <span class="addr">@{{ props.item.model }} @{{ props.item.factory }}</span>
                                        <div class="addr name" :title="props.item.param">@{{ props.item.param }}</div>
                                    </template>
                                </el-autocomplete>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <button class="ui button positive" @click="addItem">添加</button>
                    </div>
                </div>
                <div class="ui three column doubling stackable grid">
                    <div class="column">
                        <div class="inline fields">
                            <label class="four wide field flex-center">物料名称</label>
                            <div class="twelve wide field">
                                <div class="fake-input">@{{ currentMaterial.name || '暂无'}}</div>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="four wide field flex-center">性能及参数</label>
                            <div class="twelve wide field">
                                <div class="fake-input">@{{ currentMaterial.param || '暂无'}}</div>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="four wide field flex-center">品牌型号</label>
                            <div class="twelve wide field">
                                <div class="fake-input">@{{ currentMaterial.model }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="four wide field flex-center">生产厂家</label>
                            <div class="twelve wide field">
                                <div class="fake-input">@{{ currentMaterial.factory || '暂无'}}</div>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="four wide field flex-center">单位</label>
                            <div class="twelve wide field">
                                <div class="fake-input">@{{ currentMaterial.unit || '暂无'}}</div>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <button class="ui button primary" @click="checkPrice">查询单价</button>
                    </div>
                </div>
            </div>
            <h4 class="ui header center aligned">退料入库清单</h4>
            <h5 class="ui header right aligned">合计总额：@{{ sumAmount.toLocaleString('en-US') }} ￥</h5>
            <div class="ui form form-item">
                <div class="ui five column doubling stackable grid font-size-13">
                    <div class="two wide column form-thead">序号</div>
                    <div class="two wide column form-thead">物料名称</div>
                    <div class="two wide column form-thead">品牌型号</div>
                    <div class="two wide column form-thead">单位</div>
                    <div class="two wide column form-thead">库存均价</div>
                    <div class="two wide column form-thead">退料数量</div>
                    <div class="two wide column form-thead">退料金额</div>
                    <div class="two wide column form-thead">操作</div>
                </div>
                <transition-group name="slide-down" tag="div" class="form-wrap special-form">
                    <div class="ui column doubling stackable grid center aligned" v-for="(item, index) in stockReturnAdd.lists" :key="item.id">
                        <div class="two wide column">
                            <div class="fake-input">@{{ index + 1}}</div>
                        </div>
                        <div class="two wide column">
                            <div class="fake-input">@{{ item.material && item.material.name || '无'}}</div>
                        </div>
                        <div class="two wide column">
                            <div class="fake-input">@{{ item.material && item.material.model || '无'}}</div>
                        </div>
                        <div class="two wide column">
                            <div class="fake-input">@{{ item.material && item.material.unit || '无'}}</div>
                        </div>
                        <div class="two wide column">
                            <input type="number" v-model.number="item.price" placeholder="退料单价">
                        </div>
                        <div class="two wide column">
                            <input type="number" v-model.number="item.number" placeholder="退料数量">
                        </div>
                        <div class="two wide column">
                            <div class="fake-input">@{{ item.number&&item.price?(item.number*item.price).toLocaleString('en-US'):0}} ￥</div>
                        </div>
                        <div class="two wide column flex-row">
                            <div class="fake-input">
                                <i class="icon minus red" style="cursor:pointer;" @click="deleteItem('lists', item, index)"></i>
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

            <el-dialog title="最近领料清单" :visible.sync="currentMaterialListDialog" width="90%" center>
                <template v-if="currentMaterialListLoader">
                    <div class="ui active inverted dimmer">
                        <div class="ui text loader">加载中</div>
                    </div>
                </template>
                <template v-else>
                    <table class="ui center aligned table selectable unstackable">
                        <thead>
                        <tr>
                            <th></th>
                            <th>领料编号</th>
                            <th>出库仓库</th>
                            <th>物料名称</th>
                            <th>性能及技术参数</th>
                            <th>品牌型号</th>
                            <th>生产厂家</th>
                            <th>单位</th>
                            <th>库存均价</th>
                            <th>领料数量</th>
                            <th>领料金额</th>
                            <th>项目编号</th>
                            <th>项目内容</th>
                            <th>项目经理</th>
                            <th>领料人</th>
                        </tr>
                        </thead>
                        <tbody>
                        <template v-if="currentMaterialList.length">
                            <tr v-for="(item, index) in currentMaterialList" :key="item.index">
                                <td>@{{ index+1 }}</td>
                                <td>@{{ item.number_id }}</td>
                                <td>@{{ item.warehouse }}</td>
                                <td>@{{ item.material.name }}</td>
                                <td>@{{ item.material.param }}</td>
                                <td>@{{ item.material.model }}</td>
                                <td>@{{ item.material.factory }}</td>
                                <td>@{{ item.material.unit }}</td>
                                <td>@{{ item.price.toLocaleString('en-US') }}</td>
                                <td>@{{ item.number.toLocaleString('en-US') }}</td>
                                <td>@{{ item.cost.toLocaleString('en-US') }}</td>
                                <td>@{{ item.project_number }}</td>
                                <td>@{{ item.project_content }}</td>
                                <td>@{{ item.project_manager }}</td>
                                <td>@{{ item.worker }}</td>
                            </tr>
                        </template>
                        <template v-else>
                            <tr>
                                <td colspan="15">暂无数据</td>
                            </tr>
                        </template>
                        </tbody>
                    </table>
                </template>
            </el-dialog>
        </div>
    </div>
    <!-- /主体内容 === 不可复用 -->
@endsection
@section('pageJs')
    <script src="{{url('js/stock_return_add.js')}}"></script>
@endsection