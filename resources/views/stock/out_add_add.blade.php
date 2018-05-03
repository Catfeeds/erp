@extends('layouts.main_no_nav')
@section('title','已立项清单')
@section('content')
    <div class="ui breadcrumb">
        <a class="section">库存管理</a>
        <div class="divider"> / </div>
        <a class="section" href="../stock/out_list.html">退货出库清单</a>
        <div class="divider"> / </div>
        <a class="section" href="../stock/out_add.html">新增退货出库</a>
        <div class="divider"> / </div>
        <div class="active section">退货出库</div>
    </div>

    <input type="hidden" id="purchaseId" value="">

    <h1 class="ui red header blue center aligned">退货出库</h1>
    <div class="invisible" id="outAddAdd">
        <h4 class="ui dividing header blue">基本信息</h4>
        <div class="ui form">
            <div class="ui three column doubling stackable grid">
                <div class="column">
                    <div class="inline fields">
                        <label class="four wide field flex-center">采购编号</label>
                        <div class="twelve wide field">
                            <div class="fake-input">CG210231322</div>
                        </div>
                    </div>
                </div>
                <div class="column">
                    <div class="inline fields">
                        <label class="four wide field flex-center">采购日期</label>
                        <div class="twelve wide field">
                            <div class="fake-input">2018-02-12</div>
                        </div>
                    </div>
                </div>
                <div class="column">
                    <div class="inline fields">
                        <label class="four wide field flex-center">采购商名称</label>
                        <div class="twelve wide field">
                            <div class="fake-input">xxx采购商</div>
                        </div>
                    </div>
                </div>
                <div class="column">
                    <div class="inline fields">
                        <label class="four wide field flex-center">项目编号</label>
                        <div class="twelve wide field">
                            <div class="fake-input">XM232132132</div>
                        </div>
                    </div>
                </div>
                <div class="column">
                    <div class="inline fields">
                        <label class="four wide field flex-center">项目内容</label>
                        <div class="twelve wide field">
                            <div class="fake-input">这是项目内容</div>
                        </div>
                    </div>
                </div>
                <div class="column">
                    <div class="inline fields">
                        <label class="four wide field flex-center">项目经理</label>
                        <div class="twelve wide field">
                            <div class="fake-input">陈经理</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <h4 class="ui dividing header blue">信息录入</h4>
        <div class="ui form">
            <div class="ui three column doubling stackable grid">
                <div class="column">
                    <div class="inline fields">
                        <label class="four wide field flex-center">出库日期</label>
                        <div class="twelve wide field">
                            <el-date-picker v-model="stockOutAdd.date" type="date" placeholder="出库日期" value-format="yyyy-MM-dd">
                            </el-date-picker>
                        </div>
                    </div>
                </div>
                <div class="column">
                    <div class="inline fields">
                        <label class="four wide field flex-center">仓库</label>
                        <div class="twelve wide field">
                            <el-autocomplete popper-class="my-autocomplete" v-model="current.stock.name" :fetch-suggestions="querySearchStock" placeholder="请输入物料名称"
                                             @select="handleSelectStock">
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
                        <label class="four wide field flex-center">退货原因</label>
                        <div class="twelve wide field">
                            <input type="text" v-model="stockOutAdd.reason">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <template v-if="current.stock.name">

            <h4 class="ui dividing header blue">选择物料</h4>
            <div class="ui form">
                <div class="ui three column doubling stackable grid">
                    <div class="column wide">
                        <div class="inline fields">
                            <label class="four wide field flex-center">物料名称</label>
                            <div class="twelve wide field">
                                <el-autocomplete popper-class="my-autocomplete" v-model="current.material.name" :fetch-suggestions="querySearchMaterial"
                                                 placeholder="请输入物料名称" @select="handleSelectMaterial">
                                    <i class="el-icon-edit el-input__icon" slot="suffix">
                                    </i>
                                    <template slot-scope="props">
                                        <div class="name">@{{ props.item.name }}</div>
                                        <span class="addr">@{{ props.item.model }}</span>
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
                                <div class="fake-input">@{{ current.material.material.name || '暂无'}}</div>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="four wide field flex-center">性能及参数</label>
                            <div class="twelve wide field">
                                <div class="fake-input">@{{ current.material.material.param || '暂无'}}</div>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="four wide field flex-center">品牌型号</label>
                            <div class="twelve wide field">
                                <div class="fake-input">@{{ current.material.material.model }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="four wide field flex-center">生产厂家</label>
                            <div class="twelve wide field">
                                <div class="fake-input">@{{ current.material.material.factory || '暂无'}}</div>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="four wide field flex-center">单位</label>
                            <div class="twelve wide field">
                                <div class="fake-input">@{{ current.material.material.unit || '暂无'}}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
        <h4 class="ui header center aligned">退货出库清单</h4>
        <div class="ui form form-item">
            <div class="ui five column doubling stackable grid font-size-13">
                <div class="two wide column form-thead">物料名称</div>
                <div class="two wide column form-thead">品牌型号</div>
                <div class="two wide column form-thead">单位</div>
                <div class="two wide column form-thead">单价</div>
                <div class="two wide column form-thead">采购数量</div>
                <div class="two wide column form-thead">采购金额</div>
                <div class="two wide column form-thead">出库数量</div>
                <div class="two wide column form-thead">操作</div>
            </div>
            <transition-group name="slide-down" tag="div" class="form-wrap special-form">
                <div class="ui column doubling stackable grid center aligned" v-for="(item, index) in stockOutAdd.lists" :key="item.id">
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
                        <div class="fake-input">@{{ item.material && item.material.price.toLocaleString('en-US') || 0}} ￥</div>
                    </div>
                    <div class="two wide column">
                        <div class="fake-input">@{{ item.material && item.material.buy_number.toLocaleString('en-US') || 0}}</div>
                    </div>
                    <div class="two wide column">
                        <div class="fake-input">@{{ item.material && item.material.cost.toLocaleString('en-US') || 0}} ￥</div>
                    </div>
                    <div class="two wide column">
                        <input type="number" v-model="item.number" placeholder="出货数量">
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
    </div>
@endsection
@section('pageJs')
    <script src="{{url('js/stock_out_add_add.js')}}"></script>
@endsection