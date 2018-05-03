@extends('layouts.main')
@section('title','已立项清单')
@section('content')
    <!-- 主体内容 === 不可复用 -->
    <div class="index-content print-no-padding">

        <div class="ui breadcrumb">
            <a class="section">库存管理</a>
            <div class="divider"> / </div>
            <div class="active section">领料出库清单</div>
        </div>

        <!-- 操作区域 -->
        <div class="content-operation flex-row flex-between flex-wrap">
            <div>
                <a href="javascript:_helper.fullWindow('{{url('stock/get/add')}}')" class="ui primary button">
                    <i class="icon plus"></i>
                    <span>新增领料出库</span>
                </a>
                <a href="javascript:_helper.fullWindow('../stock/get_print.html?id=1')" class="ui positive button">
                    <i class="icon print"></i>
                    <span>导出</span>
                </a>
            </div>
            <form action="/views/buy/project_list.html" class="ui form flex-fluid">
                <div class="ui left action right input fluid">
                    <div class="ui button white dropdown ">
                        <input name="seartch-type" type="hidden">
                        <div class="text">请选中搜索内容</div>
                        <i class="dropdown icon"></i>
                        <div class="menu">
                            <div class="item" data-value="1">领料编号</div>
                            <div class="item" data-value="2">物料名称</div>
                            <div class="item" data-value="3">项目编号</div>
                            <div class="item" data-value="4">项目内容</div>
                            <div class="item" data-value="5">项目经理</div>
                            <div class="item" data-value="6">领料人</div>
                            <div class="item" data-value="7">出库仓库</div>
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
                    <th>领料编号</th>
                    <th>出库仓库</th>
                    <th>物料名称</th>
                    <th>型号</th>
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
                <tr>
                    <td>
                        <a href="javascript:_helper.fullWindow('../stock/get_print.html?id=1')">LL20123542</a>
                    </td>
                    <td>xxx仓库</td>
                    <td>线缆</td>
                    <td>xxxxx</td>
                    <td>条</td>
                    <td>21 ￥</td>
                    <td>521,231</td>
                    <td>11,111,111 ￥</td>
                    <td>XM2012222</td>
                    <td class="table-content">项目内容xxxxx</td>
                    <td>陈经理</td>
                    <td>刘相松</td>
                </tr>
                <tr>
                    <td>
                        <a href="javascript:_helper.fullWindow('../stock/get_print.html?id=1')">LL20123542</a>
                    </td>
                    <td>xxx仓库</td>
                    <td>线缆</td>
                    <td>xxxxx</td>
                    <td>条</td>
                    <td>21 ￥</td>
                    <td>521,231</td>
                    <td>11,111,111 ￥</td>
                    <td>XM2012222</td>
                    <td class="table-content">项目内容xxxxx</td>
                    <td>陈经理</td>
                    <td>刘相松</td>
                </tr>
                <tr>
                    <td>
                        <a href="javascript:_helper.fullWindow('../stock/get_print.html?id=1')">LL20123542</a>
                    </td>
                    <td>xxx仓库</td>
                    <td>线缆</td>
                    <td>xxxxx</td>
                    <td>条</td>
                    <td>21 ￥</td>
                    <td>521,231</td>
                    <td>11,111,111 ￥</td>
                    <td>XM2012222</td>
                    <td class="table-content">项目内容xxxxx</td>
                    <td>陈经理</td>
                    <td>刘相松</td>
                </tr>
                </tbody>
            </table>
        </div>


    </div>
    <!-- /主体内容 === 不可复用 -->
@endsection
@section('pageJs')
    <script src="{{url('js/stock_get_list.js')}}"></script>
@endsection