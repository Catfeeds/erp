@extends('layouts.main')
@section('title','预算录入')
@section('content')
    <!-- 没有导航的单独窗口页面 -->
    <div class="normal-content print-no-padding">

        <div class="ui breadcrumb">
            <a class="section">预算管理</a>
            <div class="divider"> / </div>
            <a class="section" href="{{url('budget/list')}}" >预算清单</a>
            <div class="divider"> / </div>
            <a class="section" href="{{url('budget/detail?id=')}}{{$project->id}}" >查看预算 - 项目号 {{$project->number}}</a>
            <div class="divider"> / </div>
            <div class="active section">预算录入 - 项目号 {{$project->number}}</div>
        </div>

        <h1 class="ui header blue center aligned">预算录入 - 项目号 {{$project->number}}</h1>

        <div class="invisible" id="budgetCreate" data-id="{{$project->id}}">

            <!-- 操作 -->
            <form method="post" enctype="multipart/form-data" action="{{url('import/budget')}}?project_id={{$project->id}}">
            <div class="content-operation">
                <label for="contractUpload" class="ui positive icon button">
                    <i class="icon download"></i>

                    <input type="file" name="file" >
                   <button type="submit">导入</button>
                </label>
            </div>
            </form>
            <!-- / 操作 -->


            <h4 class="ui dividing header blue margin-top-50">物料检索添加</h4>
            <div class="ui form form-item">
                <div class="ui three column doubling stackable grid">
                    <div class="column">
                        <div class="inline fields">
                            <label class="four wide field">物料名称</label>
                            <div class="twelve wide field">
                                <el-autocomplete popper-class="my-autocomplete" v-model="newMaterial.name" :fetch-suggestions="querySearchMaterial" placeholder="请输入物料名称"
                                                 @select="handleSelectMaterial">
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
                        <div class="inline fields">
                            <label class="four wide field">性能及技术参数</label>
                            <div class="twelve wide field">
                                <div class="fake-input">@{{ newMaterial.param || '暂无参数' }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="four wide field">品牌型号</label>
                            <div class="twelve wide field">
                                <div class="fake-input">@{{ newMaterial.model || '暂无参数' }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="four wide field">生产厂家</label>
                            <div class="twelve wide field icon input">
                                <div class="fake-input">@{{ newMaterial.factory || '暂无参数' }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="four wide field">单位</label>
                            <div class="twelve wide field">
                                <div class="fake-input">@{{ newMaterial.unit || '暂无参数' }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="four wide field">单价</label>
                            <div class="twelve wide field">
                                <input v-model.number="newMaterial.price" type="number" placeholder="单价">
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="four wide field">数量</label>
                            <div class="twelve wide field">
                                <input v-model.number="newMaterial.number" type="number" placeholder="数量">
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="four wide field">金额</label>
                            <div class="twelve wide field">
                                {{--<input v-model.number="newMaterial.cost" type="number" placeholder="金额">--}}
                                <div class="fake-input">@{{ (newMaterial.price * newMaterial.number || 0).toLocaleString('en-US') }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="four wide field">类型</label>
                            <div class="twelve wide field">
                                <el-select v-model="newMaterial.type" placeholder="类型">
                                    <el-option v-for="item in budgetType" :key="item.id" :label="item.name" :value="item.id">
                                    </el-option>
                                </el-select>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <button class="ui positive icon button" @click="addOriginMaterial">
                                <i class="icon plus"></i>
                                <span>添加</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <h4 class="ui dividing header blue margin-top-50">新增物料添加</h4>
            <!-- 添加表单 -->
            <div class="ui form form-item">
                <div class="ui eleven column doubling stackable grid">
                    <div class="two wide column form-thead">物料名称</div>
                    <div class="two wide column form-thead">性能及技术参数</div>
                    <div class="two wide column form-thead">品牌型号</div>
                    <div class="two wide column form-thead">生产厂家</div>
                    <div class="one wide column form-thead">单位</div>
                    <div class="one wide column form-thead">单价</div>
                    <div class="two wide column form-thead">数量</div>
                    <div class="two wide column form-thead">金额</div>
                    <div class="one wide column form-thead">类型</div>
                    <div class="one wide column form-thead">操作</div>
                </div>
                <div class="form-wrap special-form">
                    <div class="ui eleven column doubling stackable grid center aligned">
                        <div class="two wide column">
                            <input v-model="newBudget.name" type="text" placeholder="请输入物料名称">
                        </div>
                        <div class="two wide column">
                            <input type="text" v-model="newBudget.param" placeholder="请输入性能及技术参数">
                        </div>
                        <div class="two wide column">
                            <input v-model="newBudget.model" type="text" placeholder="请输入品牌型号">
                        </div>
                        <div class="two wide column">
                            <input v-model="newBudget.factory" type="text" placeholder="请输入生产厂家">
                        </div>
                        <div class="one wide column">
                            <input v-model="newBudget.unit" type="text" placeholder="单位">
                        </div>
                        <div class="one wide column">
                            <input v-model.number="newBudget.price" type="number" placeholder="单价">
                        </div>
                        <div class="two wide column">
                            <input v-model.number="newBudget.number" type="number" placeholder="数量">
                        </div>
                        <div class="two wide column">
                            <div class="fake-input">@{{ (newBudget.price * newBudget.number || 0).toLocaleString('en-US') }}</div>
                            {{--<input v-model.number="newBudget.cost" type="number" placeholder="金额">--}}
                        </div>
                        <div class="one wide column">
                            <el-select v-model="newBudget.type" placeholder="类型">
                                <el-option v-for="item in budgetType" :key="item.id" :label="item.name" :value="item.id">
                                </el-option>
                            </el-select>
                        </div>
                        <div class="one wide column">
                            <div class="fake-input">
                                <i class="icon plus green" style="cursor:pointer;" @click="addNewBudget"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- / 添加表单 -->

            <!-- 录入结果 -->
            <h4 class="ui dividing header blue">预算录入结果</h4>
            <div class="ui form form-item">
                <div class="ui eleven column doubling stackable grid">
                    <div class="two wide column form-thead">物料名称</div>
                    <div class="two wide column form-thead">性能及技术参数</div>
                    <div class="two wide column form-thead">品牌型号</div>
                    <div class="two wide column form-thead">生产厂家</div>
                    <div class="one wide column form-thead">单位</div>
                    <div class="one wide column form-thead">单价</div>
                    <div class="two wide column form-thead">数量</div>
                    <div class="two wide column form-thead">金额</div>
                    <div class="one wide column form-thead">类型</div>
                    <div class="one wide column form-thead">操作</div>
                </div>

                <transition-group name="slide-down" tag="div" class="form-wrap special-form">
                    <div class="ui eleven column doubling stackable grid center aligned" v-for="(item, index) in budgetForm" :key="item.id">
                        <div class="two wide column">
                            <div class="fake-input">@{{ item.name }}</div>
                        </div>
                        <div class="two wide column">
                            <div class="fake-input">@{{ item.param }}</div>
                        </div>
                        <div class="two wide column">
                            <div class="fake-input">@{{ item.model }}</div>
                        </div>
                        <div class="two wide column">
                            <div class="fake-input">@{{ item.factory }}</div>
                        </div>
                        <div class="one wide column">
                            <div class="fake-input">@{{ item.unit }}</div>
                        </div>
                        <div class="one wide column">
                            <div class="fake-input">￥@{{ item.price.toLocaleString('en-US') }} </div>
                        </div>
                        <div class="two wide column">
                            <div class="fake-input">@{{ item.number.toLocaleString('en-US')}}</div>
                        </div>
                        <div class="two wide column">
                            {{--<div class="fake-input">@{{item.cost.toLocaleString('en-US')}} ￥</div>--}}
                            <div class="fake-input"> ￥@{{(item.price * item.number).toLocaleString('en-US')}}</div>
                        </div>
                        <div class="one wide column">
                            <div class="fake-input">@{{budgetType[item.type * 1 - 1].name}}</div>
                        </div>
                        <div class="one wide column">
                            <div class="fake-input">
                                <i class="icon minus red" style="cursor:pointer;" @click="deleteBudget(item, index)"></i>
                            </div>
                        </div>
                    </div>
                </transition-group>
            </div>
            <!-- / 录入结果 -->

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
    <script src="{{url('js/budget_create.js')}}"></script>
@endsection