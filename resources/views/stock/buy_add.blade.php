@extends('layouts.main')
@section('title','收货入库')
@section('content')
    <!-- 没有导航的单独窗口页面 -->
    <div class="normal-content print-no-padding">

        <div class="ui breadcrumb">
            <a class="section">库存管理</a>
            <div class="divider"> / </div>
            <a class="section">采购收购清单</a>
            <div class="divider"> / </div>
            <a class="section" >采购收货查询 - {{$purchase->number}}</a>
            <div class="divider"> / </div>
            <div class="active section">收货入库</div>
        </div>

        <input type="hidden" id="projectId" value="">
        <input type="hidden" id="purchaseId" value="{{$purchase->id}}">
        <input type="hidden" id="stockReceiver" value="{{\Illuminate\Support\Facades\Auth::user()->name}}">
        <div style="display: none;" id="buyMaterials">{{json_encode($lists)}}</div>

        <h1 class="ui red header blue center aligned">收货入库</h1>
        <div class="invisible" id="stockBuyAdd">
            <h4 class="ui dividing header blue">基本信息</h4>
            <div class="ui form">
                <div class="ui three column doubling stackable grid">
                    <div class="column">
                        <div class="inline fields">
                            <label class="six wide field flex-center">采购编号</label>
                            <div class="eleven wide field">
                                <div class="fake-input">{{$purchase->number}}</div>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="six wide field flex-center">采购日期</label>
                            <div class="eleven wide field">
                                <div class="fake-input">{{$purchase->date}}</div>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="six wide field flex-center">供货商名称</label>
                            <div class="eleven wide field">
                                <div class="fake-input">{{$purchase->supplier}}</div>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="six wide field flex-center">采购金额</label>
                            <div class="eleven wide field">
                                <div class="fake-input">{{number_format($purchase->lists()->sum('cost'),2)}} ￥</div>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="six wide field flex-center">项目编号</label>
                            <div class="eleven wide field">
                                <div class="fake-input">{{$purchase->project_id==0?'':\App\Models\Project::find($purchase->project_id)->number}}</div>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="six wide field flex-center">项目内容</label>
                            <div class="eleven wide field">
                                <div class="fake-input">{{$purchase->project_id==0?'':\App\Models\Project::find($purchase->project_id)->name}}</div>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="six wide field flex-center">项目经理</label>
                            <div class="eleven wide field">
                                <div class="fake-input">{{$purchase->project_id==0?'':\App\Models\Project::find($purchase->project_id)->pm}}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <h4 class="ui dividing header blue">操作信息</h4>
            <div class="ui form">
                <div class="ui three column doubling stackable grid">
                    <div class="column">
                        <div class="inline fields">
                            <label class="six wide field flex-center">入库日期</label>
                            <div class="eleven wide field">
                                <el-date-picker v-model="stockBuyAdd.date" type="date" placeholder="入库日期" value-format="yyyy-MM-dd">
                                </el-date-picker>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="six wide field flex-center">收货人</label>
                            <div class="eleven wide field">
                                <input type="text" v-model="stockBuyAdd.worker" placeholder="收货人">
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="six wide field flex-center">仓库</label>
                            <div class="eleven wide field">
                                <div class="fake-input" v-if="stockBuyAdd.projectId">@{{ stockBuyAdd.projectId }}</div>
                                <el-autocomplete v-else popper-class="my-autocomplete" v-model="stockBuyAdd.warehouse_name" :fetch-suggestions="querySearch" placeholder="请输入仓库"
                                                 @select="handleSelect">
                                    <i class="el-icon-edit el-input__icon" slot="suffix">
                                    </i>
                                    <template slot-scope="props">
                                        <div class="name">@{{ props.item.name }}</div>
                                        <span class="addr">@{{ props.item.address }}</span>
                                    </template>
                                </el-autocomplete>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <h4 class="ui dividing header blue">收货入库</h4>
            <div class="ui form">
                <div class="ui three column doubling stackable grid">
                    <div class="column six wide">
                        <div class="inline fields">
                            <label class="four wide field flex-center">筛选物料</label>
                            <div class="twelve wide field">
                                <el-select v-model="currentMaterial" placeholder="请选择筛选物料">
                                    <el-option v-for="(item, index) in materials" :key="item.id" :label="item.material.name" :value="index">
                                    </el-option>
                                </el-select>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <button class="ui button positive" @click="addItem">添加</button>
                        <button class="ui button blue" @click="addAll">全部添加</button>
                    </div>
                </div>
            </div>
            <h4 class="ui header center aligned">采购收货入库清单</h4>
            <div class="ui form form-item">
                <div class="ui five column doubling stackable grid font-size-13">
                    <div class="two wide column form-thead">物料名称</div>
                    <div class="two wide column form-thead">性能与技术参数</div>
                    <div class="two wide column form-thead">品牌型号</div>
                    <div class="two wide column form-thead">生产厂家</div>
                    <div class="one wide column form-thead">单位</div>
                    <div class="one wide column form-thead">单价</div>
                    <div class="one wide column form-thead">采购数量</div>
                    <div class="one wide column form-thead">采购金额</div>
                    <div class="one wide column form-thead">已收货数量</div>
                    <div class="one wide column form-thead">剩余未收货数量</div>
                    <div class="one wide column form-thead">本次入库数量</div>
                    <div class="one wide column form-thead">操作</div>
                </div>
                <transition-group name="slide-down" tag="div" class="form-wrap special-form">
                    <div class="ui column doubling stackable grid center aligned" v-for="(item, index) in stockBuyAdd.lists" :key="item.id">
                        <div class="two wide column">
                            <div class="fake-input">@{{ item.material && item.material.material.name || '无'}}</div>
                        </div>
                        <div class="two wide column">
                            <div class="fake-input">@{{ item.material && item.material.material.param || '无'}}</div>
                        </div>
                        <div class="two wide column">
                            <div class="fake-input">@{{ item.material && item.material.material.model || '无'}}</div>
                        </div>
                        <div class="two wide column">
                            <div class="fake-input">@{{ item.material && item.material.material.factory || '无'}}</div>
                        </div>
                        <div class="one wide column">
                            <div class="fake-input">@{{ item.material && item.material.material.unit || '无'}}</div>
                        </div>
                        <div class="one wide column">
                            <div class="fake-input">@{{ item.material && item.material.price.toLocaleString('en-US') + ' ￥' || '无'}}</div>
                        </div>
                        <div class="one wide column">
                            <div class="fake-input">@{{ item.material && item.material.number.toLocaleString('en-US') || '无'}}</div>
                        </div>
                        <div class="one wide column">
                            <div class="fake-input">@{{ item.material && item.material.cost.toLocaleString('en-US') + ' ￥' || '无'}}</div>
                        </div>
                        <div class="one wide column">
                            <div class="fake-input">@{{ item.material && item.material.received.toLocaleString('en-US') || '无'}}</div>
                        </div>
                        <div class="one wide column">
                            <div class="fake-input">@{{ item.material && item.material.need.toLocaleString('en-US') || '无'}}</div>
                        </div>
                        <div class="one wide column">
                            <input v-model.number="item.number" :min="0" :max="item.material.need" type="number" placeholder="本次入库数量">
                        </div>
                        <div class="one wide column flex-row">
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
                    <span>确定</span>
                </button>
            </div>
        </div>

    </div>
    <!-- /主体内容 === 不可复用 -->
@endsection
@section('pageJs')
    <script src="{{url('js/stock_buy_add.js')}}"></script>
@endsection