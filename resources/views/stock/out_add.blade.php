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

            <form action="" class="ui form">
                <div class="inline fields" style="justify-content:flex-end;">
                    <label>系统状态：</label>
                    <div class="field">
                        <div class="ui radio checkbox">
                            <input type="radio" name="system" value="1">
                            <label>已结清</label>
                        </div>
                    </div>
                    <div class="field">
                        <div class="ui radio checkbox">
                            <input type="radio" name="system" value="0">
                            <label>未结清</label>
                        </div>
                    </div>
                </div>
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
                    <input name="value" type="text" placeholder="搜索内容" value="">
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
                <tr>
                    <td>
                        <a class="stockOutItem" data-id="1">CG1231532311</a>
                    </td>
                    <td>xx供货商</td>
                    <td>123,521 ￥</td>
                    <td>XM1352123124</td>
                    <td class="table-content">这是项目内容xzxx</td>
                    <td>陈经理</td>
                    <td>123,521 ￥</td>
                    <td>52,212 ￥</td>
                    <td>已结清</td>
                </tr>
                <tr>
                    <td>
                        <a class="stockOutItem" data-id="2">CG1231532311</a>
                    </td>
                    <td>xx供货商</td>
                    <td>123,521 ￥</td>
                    <td>XM1352123124</td>
                    <td class="table-content">这是项目内容xzxx</td>
                    <td>陈经理</td>
                    <td>123,521 ￥</td>
                    <td>52,212 ￥</td>
                    <td>已结清</td>
                </tr>
                <tr>
                    <td>
                        <a class="stockOutItem" data-id="3">CG1231532311</a>
                    </td>
                    <td>xx供货商</td>
                    <td>123,521 ￥</td>
                    <td>XM1352123124</td>
                    <td class="table-content">这是项目内容xzxx</td>
                    <td>陈经理</td>
                    <td>123,521 ￥</td>
                    <td>52,212 ￥</td>
                    <td>已结清</td>
                </tr>
                </tbody>
            </table>
        </div>


        <el-dialog title="采购收货查询 - CG1231532311" :visible.sync="stockCheckDialog" width="90%" center id="stockOutAdd" class="invisible">

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

                    <table class="ui celled structured table center aligned unstackable" style="width:65%;">
                        <thead>
                        <tr>
                            <th>采购编号</th>
                            <th class="fake-td" colspan="3">@{{ singleData.buy_id }}</th>
                            <th>采购日期</th>
                            <th class="fake-td" colspan="3">@{{ singleData.buy_date }}</th>
                            <th>收货入库记录</th>
                        </tr>
                        <tr>
                            <th>项目编号</th>
                            <th class="fake-td" colspan="3">@{{ singleData.project_id }}</th>
                            <th>项目内容</th>
                            <th class="fake-td" colspan="3">@{{ singleData.project_content }}</th>
                            <th>收货入库编号</th>
                        </tr>
                        <tr>
                            <th>采购商</th>
                            <th class="fake-td" colspan="7">@{{ singleData.buy_shop }}</th>
                            <th>入库日期</th>
                        </tr>
                        <tr>
                            <th>项目经理</th>
                            <th class="fake-td" colspan="3">@{{ singleData.project_manager }}</th>
                            <th>采购金额</th>
                            <th class="fake-td" colspan="3">@{{ singleData.buy_amount }}</th>
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
                        <template v-if="singleData.list && singleData.list.length">
                            <tr v-for="(item, index) in singleData.list" :key="item.id">
                                <td>@{{ index + 1 }}</td>
                                <td>@{{ item.name }}</td>
                                <td>@{{ item.parameter }}</td>
                                <td>@{{ item.model }}</td>
                                <td>@{{ item.manufacturer }}</td>
                                <td>@{{ item.unit }}</td>
                                <td>@{{ item.price.toLocaleString('en-US') }} ￥</td>
                                <td>@{{ item.count.toLocaleString('en-US') }}</td>
                                <td>@{{ item.amount.toLocaleString('en-US') }} ￥</td>
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
                            <th>@{{ singleData.total_amount.toLocaleString('en-US') || 0 }}￥</th>
                        </tr>
                        </tfoot>
                    </table>

                    <div class="flex-row" style="overflow:auto; flex: 1;">

                        <template v-if="singleData.list && singleData.list.length">
                            <div class="scorll-table table-head-nowrap" v-for="(item, index) in singleData.list" :key="item.id">
                                <table class="ui celled structured table center aligned unstackable">
                                    <thead>
                                    <tr>
                                        <td colspan="4">@{{ index + 1 }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="4">@{{ item.stock_id }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="4">@{{ item.stock_date }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="4">@{{ item.stock_manager }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="4">@{{ item.stock_name }}</td>
                                    </tr>
                                    <tr>
                                        <th>收货数量</th>
                                        <th>收货金额</th>
                                        <th>剩余数量</th>
                                        <th>剩余金额</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>4,000 ￥</td>
                                        <td>300</td>
                                        <td>6000 ￥</td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>4,000 ￥</td>
                                        <td>300</td>
                                        <td>6000 ￥</td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>4,000 ￥</td>
                                        <td>300</td>
                                        <td>6000 ￥</td>
                                    </tr>
                                    <tr>
                                        <td>4</td>
                                        <td>4,000 ￥</td>
                                        <td>300</td>
                                        <td>6000 ￥</td>
                                    </tr>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th></th>
                                        <th>4,000 ￥</th>
                                        <th></th>
                                        <th>6,000 ￥</th>
                                    </tr>
                                    <tr>
                                        <td colspan="4">
                                            <a class="ui mini button primary" href="javascript:_helper.fullWindow('../stock/buy_print.html?id=1');">收货凭证</a>
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
                </div>
                <div class="inline-center margin-top-20">
                    <a href="javascript:_helper.fullWindow('../stock/out_add_add.html?id=1')" class="ui button primary large">
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