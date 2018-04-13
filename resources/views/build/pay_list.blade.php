@extends('layouts.main')
@section('title','已立项清单')
@section('content')
    <!-- 主体内容 === 不可复用 -->
    <div class="index-content print-no-padding">

        <div class="ui breadcrumb">
            <a class="section">施工管理</a>
            <div class="divider"> / </div>
            <div class="active section">施工付款清单</div>
        </div>

        <!-- 操作区域 -->
        <div class="content-operation">

            <form action="" class="ui form">
                <div class="inline fields" style="justify-content:flex-end;">
                    <label>系统状态：</label>
                    <div class="field">
                        <div class="ui radio checkbox">
                            <input type="radio" name="system" value="1">
                            <label>待处理</label>
                        </div>
                    </div>
                    <div class="field">
                        <div class="ui radio checkbox">
                            <input type="radio" name="system" value="0">
                            <label>已处理</label>
                        </div>
                    </div>
                </div>
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
                    <th>系统状态</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>xxx施工队</td>
                    <td>陈经理</td>
                    <td>XM20123211</td>
                    <td>这是项目内容</td>
                    <td>刘经理</td>
                    <td>12,212 ￥</td>
                    <td>5,231 ￥</td>
                    <td>10,212 ￥</td>
                    <td>待处理</td>
                    <td style="white-space:nowrap;">
                        <a class="ui mini button primary" href="javascript:_helper.fullWindow('../build/pay_single.html?id=1')">查看</a>
                    </td>
                </tr>
                <tr>
                    <td>xxx施工队</td>
                    <td>陈经理</td>
                    <td>XM20123211</td>
                    <td>这是项目内容</td>
                    <td>刘经理</td>
                    <td>12,212 ￥</td>
                    <td>5,231 ￥</td>
                    <td>10,212 ￥</td>
                    <td>待处理</td>
                    <td>
                        <a class="ui mini button primary" href="javascript:_helper.fullWindow('../build/pay_single.html?id=1')">查看</a>
                    </td>
                </tr>
                <tr>
                    <td>xxx施工队</td>
                    <td>陈经理</td>
                    <td>XM20123211</td>
                    <td>这是项目内容</td>
                    <td>刘经理</td>
                    <td>12,212 ￥</td>
                    <td>5,231 ￥</td>
                    <td>10,212 ￥</td>
                    <td>待处理</td>
                    <td>
                        <a class="ui mini button primary" href="javascript:_helper.fullWindow('../build/pay_single.html?id=1')">查看</a>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

    </div>
    <!-- /主体内容 === 不可复用 -->

@endsection
@section('pageJs')
    <script src="{{url('js/build_pay_list.js')}}"></script>
@endsection