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
            <form >
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
                @foreach($tips as $tip)
                <tr>
                    <td>
                        <a href="javascript:_helper.fullWindow('{{url('check/detail')}}?id={{$tip->project_id}}');">{{!$tip->project()?'':$tip->project()->number}}</a>
                    </td>
                    <td>{{!$tip->project()?'':$tip->project()->name}}</td>
                    <td>{{!$tip->project()?'':$tip->project()->pm}}</td>
                    <td>{{$tip->type==1?'履约保证金':'请款'}}</td>
                    <td>{{$tip->pay_date}}</td>
                    <td>{{number_format($tip->price,2)}}</td>
                    <td>{{$tip->pay_unit}}</td>
                    <td>{{$tip->remark}}</td>
                </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{$tips->links()}}
    </div>
    <!-- /主体内容 === 不可复用 -->
@endsection
@section('pageJs')
    <script src="{{url('js/check_tips.js')}}"></script>
@endsection