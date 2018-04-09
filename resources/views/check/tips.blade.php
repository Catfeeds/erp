@extends('layouts.main')
@section('title','已立项清单')
@section('content')
    <!-- 主体内容 === 不可复用 -->
    <div class="index-content print-no-padding">

        <div class="ui breadcrumb">
            <a class="section">验收预收款管理</a>
            <div class="divider"> / </div>
            <div class="active section">收款提示</div>
        </div>

        <!-- 操作 -->
        <div class="content-operation flex-row flex-end" id="datePicker">
            <form action="/views/check/tips.html">
                <el-date-picker v-model="date" name="search-date" type="datetimerange" :picker-options="dateOption" range-separator="至" start-placeholder="开始日期"
                                end-placeholder="结束日期" align="right" format="yyyy-MM-dd">
                </el-date-picker>
                <button class="ui icon button primary" type="submit">
                    <i class="icon search"></i>
                    <span>查询</span>
                </button>
            </form>
        </div>
        <!-- / 操作 -->


        <div class="content-wrap table-head-nowrap">

            <table class="ui center aligned table selectable unstackable">
                <thead>
                <tr>
                    <th>项目编号</th>
                    <th>项目内容</th>
                    <th>项目经理</th>
                    <th>请款/收回履约保证金</th>
                    <th>预计请款日期</th>
                    <th>预计请款金额</th>
                    <th>付款单位</th>
                    <th>备注</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>
                        <a href="javascript:_helper.fullWindow('../check/detail.html');">154376453254</a>
                    </td>
                    <td>这是一大段内容</td>
                    <td>张喜</td>
                    <td>10万/20万</td>
                    <td>2017-12-01</td>
                    <td>20万</td>
                    <td>xxx公司</td>
                    <td>这是一大串备注</td>
                </tr>
                <tr>
                    <td>
                        <a href="javascript:_helper.fullWindow('../check/detail.html');">154376453254</a>
                    </td>
                    <td>这是一大段内容</td>
                    <td>张喜</td>
                    <td>10万/20万</td>
                    <td>2017-12-01</td>
                    <td>20万</td>
                    <td>xxx公司</td>
                    <td>这是一大串备注</td>
                </tr>
                </tbody>
            </table>
        </div>

    </div>
    <!-- /主体内容 === 不可复用 -->
@endsection
@section('pageJs')
    <script src="{{url('js/check_tips.js')}}"></script>
@endsection