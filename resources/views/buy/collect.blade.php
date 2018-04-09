@extends('layouts.main')
@section('title','已立项清单')
@section('content')
    <!-- 主体内容 === 不可复用 -->
    <div class="index-content print-no-padding">

        <div class="ui breadcrumb">
            <a class="section">采购管理</a>
            <div class="divider"> / </div>
            <div class="active section">采购汇总清单</div>
        </div>

        <!-- 操作区域 -->
        <div class="content-operation flex-row flex-between">
            <div>
                <a class="ui green button" href="#">
                    <i class="icon download"></i>
                    <span>Excel 导出</span>
                </a>
            </div>
            <form action="" class="ui form flex-fluid">
                <div class="ui left action right input fluid">
                    <div class="ui button white dropdown ">
                        <input name="seartch-type" type="hidden">
                        <div class="text">请选中搜索内容</div>
                        <i class="dropdown icon"></i>
                        <div class="menu">
                            <div class="item" data-value="1">项目编号</div>
                            <div class="item" data-value="2">项目内容</div>
                        </div>
                    </div>
                    <input name="value" type="text" placeholder="搜索内容" value="">
                    <button class="ui button">搜索</button>
                </div>
            </form>
        </div>
        <!-- / 操作区域 -->
        <h1 class="ui header center aligned">项目采购物料清单</h1>

        <div class="table-head-nowrap">
            <table class="ui celled structured table center aligned unstackable">
                <thead>
                <tr>
                    <th>项目编号</th>
                    <th class="fake-td">xm21312521312</th>
                    <th>项目内容</th>
                    <th class="fake-td" colspan="9">这是项目内容</th>
                    <th>项目保修截止日期</th>
                    <th class="fake-td">2018-06-02</th>
                </tr>
                <tr>
                    <th>序号</th>
                    <th>采购日期</th>
                    <th>采购编号</th>
                    <th>预算内/外</th>
                    <th>供货商</th>
                    <th>物料名称</th>
                    <th>性能及技术</th>
                    <th>品牌型号</th>
                    <th>生产厂家</th>
                    <th>单位</th>
                    <th>单价</th>
                    <th>数量</th>
                    <th>金额</th>
                    <th>保修截止日期</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>1</td>
                    <td>2018-02-03</td>
                    <td>52132132</td>
                    <td>内</td>
                    <td>供应商一</td>
                    <td>物料一</td>
                    <td>xx性能xx技术</td>
                    <td>ak-47</td>
                    <td>xx厂家</td>
                    <td>件</td>
                    <td>20 ￥</td>
                    <td>123,421</td>
                    <td>523,123,521 ￥</td>
                    <td>2018-03-22</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>2018-02-03</td>
                    <td>52132132</td>
                    <td>外</td>
                    <td>供应商二</td>
                    <td>物料三</td>
                    <td>xx性能xx技术</td>
                    <td>ak-47</td>
                    <td>xx厂家</td>
                    <td>件</td>
                    <td>20 ￥</td>
                    <td>123,421</td>
                    <td>523,123,521 ￥</td>
                    <td>2018-03-22</td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>2018-02-03</td>
                    <td>52132132</td>
                    <td>外</td>
                    <td>供应商二</td>
                    <td>物料三</td>
                    <td>xx性能xx技术</td>
                    <td>ak-47</td>
                    <td>xx厂家</td>
                    <td>件</td>
                    <td>20 ￥</td>
                    <td>123,421</td>
                    <td>523,123,521 ￥</td>
                    <td>2018-03-22</td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>2018-02-03</td>
                    <td>52132132</td>
                    <td>内</td>
                    <td>供应商五</td>
                    <td>物料三</td>
                    <td>xx性能xx技术</td>
                    <td>ak-47</td>
                    <td>xx厂家</td>
                    <td>件</td>
                    <td>20 ￥</td>
                    <td>123,421</td>
                    <td>523,123,521 ￥</td>
                    <td>2018-03-22</td>
                </tr>
                </tbody>
                <tfoot>
                <tr>
                    <th colspan="12">合计</th>
                    <th>123,123,123 ￥</th>
                    <th></th>
                </tr>
                </tfoot>
            </table>
        </div>

    </div>
    <!-- /主体内容 === 不可复用 -->
@endsection
@section('pageJs')
    <script src="{{url('js/buy_collect.js')}}"></script>
@endsection