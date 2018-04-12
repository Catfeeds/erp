@extends('layouts.main')
@section('title','已立项清单')
@section('content')
    <!-- 主体内容 === 不可复用 -->
    <div class="index-content print-no-padding">

        <div class="ui breadcrumb">
            <a class="section">施工管理</a>
            <div class="divider"> / </div>
            <div class="active section">备案合同清单</div>
        </div>

        <!-- 操作区域 -->
        <div class="content-operation">

            <form action="" class="ui form">
                <div class="flex-row flex-between flex-wrap">
                    <div>
                        <a class="ui primary button" href="javascript:_helper.fullWindow('{{url('build/deal/create')}}')">
                            <i class="icon plus"></i>
                            <span>录入合同</span>
                        </a>
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
                    <th>序号</th>
                    <th>合同日期</th>
                    <th>施工队</th>
                    <th>施工经理</th>
                    <th>项目编号</th>
                    <th>项目内容</th>
                    <th>项目经理</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>1</td>
                    <td>2018-01-21</td>
                    <td>xxx施工队</td>
                    <td>xxx内容</td>
                    <td>程经理</td>
                    <td>XM2012322</td>
                    <td>刘经理</td>
                    <td>
                        <a class="ui mini button primary" href="#">查看合同</a>
                    </td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>2018-01-21</td>
                    <td>xxx施工队</td>
                    <td>xxx内容</td>
                    <td>程经理</td>
                    <td>XM2012322</td>
                    <td>刘经理</td>
                    <td>
                        <a class="ui mini button primary" href="#">查看合同</a>
                    </td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>2018-01-21</td>
                    <td>xxx施工队</td>
                    <td>xxx内容</td>
                    <td>程经理</td>
                    <td>XM2012322</td>
                    <td>刘经理</td>
                    <td>
                        <a class="ui mini button primary" href="#">查看合同</a>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

    </div>
    <!-- /主体内容 === 不可复用 -->
@endsection
@section('pageJs')
    <script src="{{url('js/build_deal_list.js')}}"></script>
@endsection