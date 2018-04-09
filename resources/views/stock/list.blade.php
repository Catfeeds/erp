@extends('layouts.main')
@section('title','已立项清单')
@section('content')
    <!-- 主体内容 === 不可复用 -->
    <div class="index-content print-no-padding">

        <div class="ui breadcrumb">
            <a class="section">库存管理</a>
            <div class="divider"> / </div>
            <div class="active section">库存清单</div>
        </div>

        <!-- 操作区域 -->
        <div class="content-operation flex-row flex-between flex-wrap" style="align-items: flex-end;">
            <div>
                <a class="ui green button" href="#">
                    <i class="icon download"></i>
                    <span>Excel 导出</span>
                </a>
            </div>
            <form action="/views/buy/charge_list.html" class="ui form flex-fluid">
                <div class="ui left action right input fluid">
                    <div class="ui button white dropdown ">
                        <input name="seartch-type" type="hidden">
                        <div class="text">请选中搜索内容</div>
                        <i class="dropdown icon"></i>
                        <div class="menu">
                            <div class="item" data-value="1">物料名称</div>
                            <div class="item" data-value="2">仓库</div>
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
                    <th>序号</th>
                    <th>物料名称</th>
                    <th>品牌型号</th>
                    <th>单位</th>
                    <th>单价</th>
                    <th>库存数量</th>
                    <th>库存金额</th>
                    <th>评价单价</th>
                    <th>仓库</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>1</td>
                    <td>
                        <a href="javascript:_helper.fullWindow('../stock/check.html?id=1')">物料一</a>
                    </td>
                    <td>ak-47</td>
                    <td>个</td>
                    <td>321 ￥</td>
                    <td>213,523,123</td>
                    <td>123,522,321 ￥</td>
                    <td>21,523 ￥</td>
                    <td>仓库一</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>
                        <a href="javascript:_helper.fullWindow('../stock/check.html?id=1')">物料一</a>
                    </td>
                    <td>ak-47</td>
                    <td>个</td>
                    <td>321 ￥</td>
                    <td>213,523,123</td>
                    <td>123,522,321 ￥</td>
                    <td>21,523 ￥</td>
                    <td>仓库一</td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>
                        <a href="javascript:_helper.fullWindow('../stock/check.html?id=1')">物料一</a>
                    </td>
                    <td>ak-47</td>
                    <td>个</td>
                    <td>321 ￥</td>
                    <td>213,523,123</td>
                    <td>123,522,321 ￥</td>
                    <td>21,523 ￥</td>
                    <td>仓库一</td>
                </tr>
                </tbody>
            </table>
        </div>

    </div>
    <!-- /主体内容 === 不可复用 -->
@endsection
@section('pageJs')
    <script src="{{url('js/stock_list.js')}}"></script>
@endsection