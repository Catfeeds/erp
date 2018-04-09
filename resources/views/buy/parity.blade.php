@extends('layouts.main')
@section('title','已立项清单')
@section('content')
    <!-- 主体内容 === 不可复用 -->
    <div class="index-content print-no-padding">

        <div class="ui breadcrumb">
            <a class="section">采购管理</a>
            <div class="divider"> / </div>
            <div class="active section">物料采购比价</div>
        </div>

        <!-- 操作 -->
        <h4 class="ui dividing header blue">录入基本信息</h4>
        <div class="content-operation invisible" id="buyParityForm">
            <form action="/views/buy/parity.html">
                <div class="ui form">
                    <div class="ui three column doubling stackable grid">
                        <div class="column">
                            <div class="inline fields">
                                <label class="six wide field flex-center">物料名称</label>
                                <div class="ten wide field">
                                    <el-autocomplete popper-class="my-autocomplete" name="name" v-model="currentMaterials.name" :fetch-suggestions="querySearch"
                                                     placeholder="请输入物料名称" @select="handleSelect">
                                        <i class="el-icon-edit el-input__icon" slot="suffix">
                                        </i>
                                        <template slot-scope="props">
                                            <div class="name">{{ props.item.name }}</div>
                                            <span class="addr">{{ props.item.address }}</span>
                                        </template>
                                    </el-autocomplete>
                                </div>
                            </div>
                        </div>
                        <div class="column">
                            <div class="inline fields">
                                <label class="six wide field flex-center">性能及技术参数</label>
                                <div class="ten wide field">
                                    <div class="fake-input">{{currentMaterials.parameter || '暂无数据'}}</div>
                                </div>
                            </div>
                        </div>
                        <div class="column">
                            <div class="inline fields">
                                <label class="six wide field flex-center">品牌型号</label>
                                <div class="ten wide field">
                                    <div class="fake-input">{{currentMaterials.model || '暂无数据'}}</div>
                                </div>
                            </div>
                        </div>
                        <div class="column">
                            <div class="inline fields">
                                <label class="six wide field flex-center">生产商家</label>
                                <div class="ten wide field">
                                    <div class="fake-input">{{currentMaterials.address || '暂无数据'}}</div>
                                </div>
                            </div>
                        </div>
                        <div class="column">
                            <div class="inline fields">
                                <label class="six wide field flex-center">单位</label>
                                <div class="ten wide field">
                                    <div class="fake-input">{{currentMaterials.unit || '暂无数据'}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="margin-top-20 flex-row flex-between flex-wrap">
                    <div>
                        <a class="ui green button" href="#">
                            <i class="icon download"></i>
                            <span>Excel 导出</span>
                        </a>
                    </div>
                    <div>
                        <el-date-picker v-model="date" name="search-date" type="datetimerange" :picker-options="dateOption" range-separator="至" start-placeholder="开始日期"
                                        end-placeholder="结束日期" align="right" format="yyyy-MM-dd">
                        </el-date-picker>
                        <button class="ui icon button primary" type="submit">
                            <i class="icon search"></i>
                            <span>查询</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <!-- / 操作 -->


        <div class="content-wrap table-head-nowrap">

            <table class="ui center aligned table selectable unstackable">
                <thead>
                <tr>
                    <th>采购日期</th>
                    <th>采购编号</th>
                    <th>供货商</th>
                    <th>发票条件</th>
                    <th>付款条件</th>
                    <th>数量</th>
                    <th>单价</th>
                    <th>保修时间</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>2017-12-01</td>
                    <td>
                        <a href="javascript:_helper.fullWindow('../check/detail.html');">154376453254</a>
                    </td>
                    <td>xx供货商</td>
                    <td>条件一</td>
                    <td>条件xx</td>
                    <td>123,542,212</td>
                    <td>20 / 件</td>
                    <td>2017-12-01</td>
                </tr>
                <tr>
                    <td>2017-12-01</td>
                    <td>
                        <a href="javascript:_helper.fullWindow('../check/detail.html');">154376453254</a>
                    </td>
                    <td>xx供货商</td>
                    <td>条件一</td>
                    <td>条件xx</td>
                    <td>123,542,212</td>
                    <td>20 / 件</td>
                    <td>2017-12-01</td>
                </tr>
                <tr>
                    <td>2017-12-01</td>
                    <td>
                        <a href="javascript:_helper.fullWindow('../check/detail.html');">154376453254</a>
                    </td>
                    <td>xx供货商</td>
                    <td>条件一</td>
                    <td>条件xx</td>
                    <td>123,542,212</td>
                    <td>20 / 件</td>
                    <td>2017-12-01</td>
                </tr>
                </tbody>
            </table>
        </div>

    </div>
    <!-- /主体内容 === 不可复用 -->
@endsection
@section('pageJs')
    <script src="{{url('js/buy_parity.js')}}"></script>
@endsection