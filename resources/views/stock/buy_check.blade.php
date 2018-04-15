@extends('layouts.main')
@section('title','已立项清单')
@section('content')
    <!-- 没有导航的单独窗口页面 -->
    <div class="normal-content print-no-padding">

        <div class="ui breadcrumb">
            <a class="section">库存管理</a>
            <div class="divider"> / </div>
            <a class="section" href="../stock/buy_list.html">采购收购清单</a>
            <div class="divider"> / </div>
            <div class="active section">采购收货查询 - CG1231532311</div>
        </div>

        <h1 class="ui header center aligned">采购收货查询 - CG1231532311</h1>
        <div class="flex-row flex-between table-head-nowrap" id="stockBuyCheck">

            <table class="ui celled structured table center aligned unstackable" style="width:65%;">
                <thead>
                <tr>
                    <th>采购编号</th>
                    <th class="fake-td" colspan="3">CG213123213</th>
                    <th>采购日期</th>
                    <th class="fake-td" colspan="3">2018-02-03</th>
                    <th>收货入库记录</th>
                </tr>
                <tr>
                    <th>项目编号</th>
                    <th class="fake-td" colspan="3">XM16312412321</th>
                    <th>项目内容</th>
                    <th class="fake-td" colspan="3">这是内容xxx</th>
                    <th>收货入库编号</th>
                </tr>
                <tr>
                    <th>采购商</th>
                    <th class="fake-td" colspan="7">xxx 采购商</th>
                    <th>入库日期</th>
                </tr>
                <tr>
                    <th>项目经理</th>
                    <th class="fake-td" colspan="3">陈先生</th>
                    <th>采购金额</th>
                    <th class="fake-td" colspan="3">123,523,123 ￥</th>
                    <th>收货人</th>
                </tr>
                <tr>
                    <th colspan="9">采购物料清单</th>
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
                <tr>
                    <td>1</td>
                    <td>线缆</td>
                    <td>这是性能参数</td>
                    <td>xxx</td>
                    <td>xxx厂家</td>
                    <td>个</td>
                    <td>20 ￥</td>
                    <td>500</td>
                    <td>10,000 ￥</td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>线缆</td>
                    <td>这是性能参数</td>
                    <td>xxx</td>
                    <td>xxx厂家</td>
                    <td>个</td>
                    <td>20 ￥</td>
                    <td>500</td>
                    <td>10,000 ￥</td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>线缆</td>
                    <td>这是性能参数</td>
                    <td>xxx</td>
                    <td>xxx厂家</td>
                    <td>个</td>
                    <td>20 ￥</td>
                    <td>500</td>
                    <td>10,000 ￥</td>
                </tr>
                </tbody>
                <tfoot>
                <tr>
                    <th colspan="8">合计</th>
                    <th>10,000￥</th>
                </tr>
                </tfoot>
            </table>

            <div class="flex-row" style="overflow:auto; flex: 1;">
                <!-- 重复渲染部分 -->
                <div class="scorll-table table-head-nowrap">
                    <table class="ui celled structured table center aligned unstackable">
                        <thead>
                        <tr>
                            <td colspan="4">1</td>
                        </tr>
                        <tr>
                            <td colspan="4">SHRK2-1703001</td>
                        </tr>
                        <tr>
                            <td colspan="4">2017-03-01</td>
                        </tr>
                        <tr>
                            <td colspan="4">瑞先生</td>
                        </tr>
                        <tr>
                            <td colspan="4">仓库一</td>
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
                            <td>200</td>
                            <td>4,000 ￥</td>
                            <td>300</td>
                            <td>6000 ￥</td>
                        </tr>
                        <tr>
                            <td>200</td>
                            <td>4,000 ￥</td>
                            <td>300</td>
                            <td>6000 ￥</td>
                        </tr>
                        <tr>
                            <td>200</td>
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
                <!-- / 重复渲染部分 -->

                <div class="scorll-table table-head-nowrap">
                    <table class="ui celled structured table center aligned unstackable">
                        <thead>
                        <tr>
                            <td colspan="4">1</td>
                        </tr>
                        <tr>
                            <td colspan="4">SHRK2-1703001</td>
                        </tr>
                        <tr>
                            <td colspan="4">2017-03-01</td>
                        </tr>
                        <tr>
                            <td colspan="4">瑞先生</td>
                        </tr>
                        <tr>
                            <td colspan="4">仓库一</td>
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
                            <td>200</td>
                            <td>4,000 ￥</td>
                            <td>300</td>
                            <td>6000 ￥</td>
                        </tr>
                        <tr>
                            <td>200</td>
                            <td>4,000 ￥</td>
                            <td>300</td>
                            <td>6000 ￥</td>
                        </tr>
                        <tr>
                            <td>200</td>
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
                                <a class="ui mini button primary" href="javascript:_helper.fullWindow('../stock/buy_print.html?id=2');">收货凭证</a>
                            </td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <div class="inline-center margin-top-20">
            <a href="javascript:_helper.fullWindow('{{url('stock/add/buy')}}?id={{$purchase->id}}')" class="ui button primary large">
                <i class="icon hand pointer"></i>
                <span>收货入库</span>
            </a>
        </div>

    </div>
    <!-- /主体内容 === 不可复用 -->
@endsection
@section('pageJs')
{{--    <script src="{{url('js/project_list.js')}}"></script>--}}
@endsection