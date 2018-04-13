@extends('layouts.main')
@section('title','已立项清单')
@section('content')
    <!-- 主体内容 === 不可复用 -->
    <div class="index-content print-no-padding">

        <div class="ui breadcrumb">
            <a class="section">施工管理</a>
            <div class="divider"> / </div>
            <div class="active section">施工收票清单</div>
        </div>

        <!-- 操作区域 -->
        <div class="content-operation">

            <form action="" class="ui form">
                <div class="flex-row flex-between flex-wrap">
                    <div>
                        <a class="ui green button" href="#">
                            <i class="icon download"></i>
                            <span>Excel 导出</span>
                        </a>
                    </div>
                    <div class="ui left action right input fluid flex-fluid">
                        <div class="ui button white dropdown ">
                            <input name="seartch-type" type="hidden">
                            <div class="text">请选中搜索内容</div>
                            <i class="dropdown icon"></i>
                            <div class="menu">
                                <div class="item" data-value="2">施工队</div>
                                <div class="item" data-value="3">项目编号</div>
                                <div class="item" data-value="4">项目内容</div>
                                <div class="item" data-value="5">项目经理</div>
                            </div>
                        </div>
                        <input name="value" type="text" placeholder="搜索内容" value="">
                        <button class="ui button">搜索</button>
                    </div>
                </div>
            </form>
        </div>
        <!-- / 操作区域 -->

        <div class="content-wrap table-head-nowrap">

            <table class="ui center aligned table selectable unstackable">
                <thead>
                <tr>
                    <th>施工队</th>
                    <th>施工经理</th>
                    <th>项目编号</th>
                    <th>项目内容</th>
                    <th>项目经理</th>
                    <th>已完工请款</th>
                    <th>已付款</th>
                    <th>应付账款</th>
                    <th>已收票</th>
                    <th>未收票</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>xx施工队</td>
                    <td>陈经理</td>
                    <td>XM20923213</td>
                    <td class="table-content">这是项目内容这是项目内容</td>
                    <td>刘经理</td>
                    <td>123,523￥</td>
                    <td>12,523￥</td>
                    <td>1,232￥</td>
                    <td>10,523￥</td>
                    <td>10,523￥</td>
                    <td style="white-space:nowrap">
                        <a class="ui mini button primary" href="javascript:_helper.fullWindow('../build/get_single.html?id=1')">查看</a>
                    </td>
                </tr>
                <tr>
                    <td>xx施工队</td>
                    <td>陈经理</td>
                    <td>XM20923213</td>
                    <td class="table-content">这是项目内容这是项目内容</td>
                    <td>刘经理</td>
                    <td>123,523￥</td>
                    <td>12,523￥</td>
                    <td>1,232￥</td>
                    <td>10,523￥</td>
                    <td>10,523￥</td>
                    <td>
                        <a class="ui mini button primary" href="javascript:_helper.fullWindow('../build/get_single.html?id=1')">查看</a>
                    </td>
                </tr>
                <tr>
                    <td>xx施工队</td>
                    <td>陈经理</td>
                    <td>XM20923213</td>
                    <td class="table-content">这是项目内容这是项目内容</td>
                    <td>刘经理</td>
                    <td>123,523￥</td>
                    <td>12,523￥</td>
                    <td>1,232￥</td>
                    <td>10,523￥</td>
                    <td>10,523￥</td>
                    <td>
                        <a class="ui mini button primary" href="javascript:_helper.fullWindow('../build/get_single.html?id=1')">查看</a>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

    </div>
    <!-- /主体内容 === 不可复用 -->
@endsection
@section('pageJs')
    <script src="{{url('js/build_get_list.js')}}"></script>
@endsection