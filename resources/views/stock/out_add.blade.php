@extends('layouts.main_no_nav')
@section('title','已立项清单')
@section('content')
    <!-- 没有导航的单独窗口页面 -->
    <div class="normal-content print-no-padding">

        <div class="ui breadcrumb">
            <a class="section">库存管理</a>
            <div class="divider"> / </div>
            <a class="section" href="../stock/out_list.html">退货出库清单</a>
            <div class="divider"> / </div>
            <div class="active section">新增退货出库</div>
        </div>


        <!-- 操作区域 -->
        <div class="content-operation">

            <form method="get" class="ui form">
                {{--<div class="inline fields" style="justify-content:flex-end;">--}}
                    {{--<label>系统状态：</label>--}}
                    {{--<div class="field">--}}
                        {{--<div class="ui radio checkbox">--}}
                            {{--<input type="radio" name="system" value="1">--}}
                            {{--<label>已结清</label>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="field">--}}
                        {{--<div class="ui radio checkbox">--}}
                            {{--<input type="radio" name="system" value="0">--}}
                            {{--<label>未结清</label>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
                <div class="ui left action right input fluid flex-fluid">
                    <div class="ui button white dropdown ">
                        <input name="seartch-type" type="hidden">
                        <div class="text">请选中搜索内容</div>
                        <i class="dropdown icon"></i>
                        <div class="menu">
                            <div class="item" data-value="1">采购编号</div>
                            <div class="item" data-value="2">供货商</div>
                            <div class="item" data-value="3">项目编号</div>
                            <div class="item" data-value="4">项目内容</div>
                            <div class="item" data-value="5">项目经理</div>
                        </div>
                    </div>
                    <input name="search" type="text" placeholder="搜索内容" value="">
                    <button class="ui button">搜索</button>
                </div>
            </form>
        </div>
        <!-- / 操作区域 -->

        <div class="content-wrap table-head-nowrap">

            <table class="ui center aligned table selectable unstackable">
                <thead>
                <tr>
                    <th>采购编号</th>
                    <th>供货商</th>
                    <th>采购金额</th>
                    <th>项目编号</th>
                    <th>项目内容</th>
                    <th>项目经理</th>
                    <th>已收货</th>
                    <th>未收货</th>
                    <th>系统状态</th>
                </tr>
                </thead>
                <tbody>
                @foreach($lists as $list)
                <tr>
                    <td>
                        <a class="stockOutItem" data-id="{{$list->id}}">{{$list->number}}</a>
                    </td>
                    <td>{{$list->supplier}}</td>
                    <td>{{$list->lists()->sum('cost')}} ￥</td>
                    @if($list->project_id!=0)
                    <td>{{\App\Models\Project::find($list->project_id)->number}}</td>
                    <td class="table-content">{{\App\Models\Project::find($list->project_id)->name}}</td>
                    <td>{{\App\Models\Project::find($list->project_id)->pm}}</td>
                    @else
                        <td></td>
                        <td></td>
                        <td></td>
                    @endif
                    <td>{{$list->receivedPrice}} </td>
                    <td>{{$list->needPrice}} </td>
                    <td>{{$list->lists()->sum('need')==$list->lists()->sum('received')?'已结清':'未结清'}}</td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>


        <el-dialog :title="'采购收货查询 - '+ (singleData.purchase.number || '无')" :visible.sync="stockCheckDialog" width="90%" center id="stockOutAdd"
                   style="white-space:nowrap;">
            <template v-if="loader">
                <div class="ui segment">
                    <div class="ui active inverted dimmer">
                        <div class="ui text loader">加载中</div>
                    </div>
                    <p></p>
                </div>
            </template>

            <template v-else>
                <div class="flex-row flex-between table-head-nowrap" id="stockBuyCheck">

                    <template v-if="singleData.purchase && singleData.purchase.project">
                        <table class="ui celled structured table center aligned unstackable" style="width:65%;">
                            <thead>
                            <tr>
                                <th>采购编号</th>
                                <th class="fake-td" colspan="3">@{{ singleData.purchase.number }}</th>
                                <th>采购日期</th>
                                <th class="fake-td" colspan="3">@{{ singleData.purchase.date }}</th>
                                <th>收货入库记录</th>
                            </tr>
                            <tr>
                                <th>项目编号</th>
                                <th class="fake-td" colspan="3">@{{ singleData.purchase.project.number }}</th>
                                <th>项目内容</th>
                                <th class="fake-td" colspan="3">@{{ singleData.purchase.project.name }}</th>
                                <th>收货入库编号</th>
                            </tr>
                            <tr>
                                <th>采购商</th>
                                <th class="fake-td" colspan="7">@{{ singleData.purchase.supplier }}</th>
                                <th>入库日期</th>
                            </tr>
                            <tr>
                                <th>项目经理</th>
                                <th class="fake-td" colspan="3">@{{ singleData.purchase.project.pm }}</th>
                                <th>采购金额</th>
                                <th class="fake-td" colspan="3">@{{ singleData.purchase.price }}</th>
                                <th>收货人</th>
                            </tr>
                            <tr>
                                <th colspan="8">采购物料清单</th>
                                <th>仓库</th>
                            </tr>
                            <tr>
                                <th>序号</th>
                                <th>物料名称</th>
                                <th>性能及技术参数</th>
                                <th>品牌型号</th>
                                <th>生产厂家</th>
                                <th>单位</th>
                                <th>单价</th>
                                <th>采购数量</th>
                                <th>采购金额</th>
                            </tr>
                            </thead>
                            <tbody>
                            <template v-if="singleData.purchaseList && singleData.purchaseList.length">
                                <tr v-for="(item, index) in singleData.purchaseList" :key="item.id">
                                    <td>@{{ index + 1 }}</td>
                                    <td>@{{ item.material.name }}</td>
                                    <td>@{{ item.material.param }}</td>
                                    <td>@{{ item.material.model }}</td>
                                    <td>@{{ item.material.factory }}</td>
                                    <td>@{{ item.material.unit }}</td>
                                    <td>@{{ item.price.toLocaleString('en-US') }} ￥</td>
                                    <td>@{{ item.number.toLocaleString('en-US') }}</td>
                                    <td>@{{ item.cost.toLocaleString('en-US') }} ￥</td>
                                </tr>
                            </template>
                            <template v-else>
                                <tr>
                                    <td colspan="9">暂无数据</td>
                                </tr>
                            </template>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th colspan="8">合计</th>
                                <th>@{{ singleData.purchase.price.toLocaleString('en-US') || 0 }}￥ </th>
                            </tr>
                            </tfoot>
                        </table>

                        <div class="flex-row" style="overflow:auto; flex: 1;">

                            <template v-if="singleData.record && singleData.record.length > 0">
                                <div class="scorll-table table-head-nowrap" v-for="(item, index) in singleData.record" :key="item.id">
                                    <table class="ui celled structured table center aligned unstackable">
                                        <thead>
                                        <tr>
                                            <td colspan="4">@{{ index + 1 }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="4">@{{ item.number }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="4">@{{ item.date }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="4">@{{ item.worker }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="4">@{{ item.warehouse }}</td>
                                        </tr>
                                        <tr>
                                            <th>收货数量</th>
                                            <th>收货金额</th>
                                            <th>剩余数量</th>
                                            <th>剩余金额</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <template v-if="item.list && item.list.length" v-for="(subItem, subIndex) in item.list" :key="subItem.id">
                                            <tr v-if="subItem.id">
                                                <td>@{{ subItem.sum.toLocaleString('en-US') || 0 }}</td>
                                                <td>@{{ subItem.cost.toLocaleString('en-US') || 0 }} ￥</td>
                                                <td>@{{ subItem.need_sum.toLocaleString('en-US') || 0 }}</td>
                                                <td>@{{ subItem.need_cost.toLocaleString('en-US') || 0 }} ￥</td>
                                            </tr>
                                            <tr v-else>
                                                <td colspan="4">暂无记录</td>
                                            </tr>
                                        </template>
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <th></th>
                                            <th>@{{ item.get_cost.toLocaleString('en-US') || 0 }}￥</th>
                                            <th></th>
                                            <th>@{{ item.need_cost.toLocaleString('en-US') || 0 }} ￥</th>
                                        </tr>
                                        <tr>
                                            <td colspan="4">
                                                <a class="ui mini button primary" :href="'javascript:_helper.fullWindow(\'../stock/buy_print?id='+ item.id + '\');'">收货凭证</a>
                                            </td>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </template>

                            <template v-else>
                                <div class="scorll-table table-head-nowrap">
                                    <table class="ui celled structured table center aligned unstackable">
                                        <tbody>
                                        <tr>
                                            <td colspan="4" rowspan="5">暂无数据</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </template>

                        </div>
                    </template>
                </div>
                <div class="inline-center margin-top-20">
                    <a :href="href" class="ui button primary large">
                        <i class="icon hand pointer"></i>
                        <span>退货出库</span>
                    </a>
                </div>
            </template>

        </el-dialog>


    </div>
    <!-- /主体内容 === 不可复用 -->
@endsection
@section('pageJs')
    <script src="{{url('js/stock_out_add.js')}}"></script>
@endsection