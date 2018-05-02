@extends('layouts.main_no_nav')
@section('title','已立项清单')
@section('content')
    <!-- 没有导航的单独窗口页面 -->
    <div class="normal-content print-no-padding">

        <div class="ui breadcrumb print-hide">
            <a class="section">报销与借款管理</a>
            <div class="divider"> / </div>
            <a class="section" href="../loan/submit_list.html">报销申请清单</a>
            <div class="divider"> / </div>
            <a class="section" href="../loan/submit_single.html?id=BXFK20171103001">报销申请查询 - {{$submit->number}}</a>
            <div class="divider"> / </div>
            <div class="active section">凭证</div>
        </div>

        <h1 class="ui header center aligned">报销申请记帐凭证</h1>
        {{--<p style="text-align:right;font-size: 13px;padding-right:20px;"><b>记账凭证号：</b>123123123123123123</p>--}}
        <p style="text-align:right;font-size: 13px;padding-right:20px;">
            <b>附件：</b>
            <span style="padding: 0 20px;"></span>
            <b>张</b>
        </p>
        <table class="ui celled center aligned table selectable">
            <thead>
            <tr>
                <th>报销编号</th>
                <th class="fake-td">{{$submit->number}}</th>
                <th>报销日期</th>
                <th class="fake-td">{{$submit->date}}</th>
                <th>报销金额</th>
                <th class="fake-td">{{$submit->price}}￥</th>
            </tr>
            <tr>
                <th>项目编号</th>
                <th class="fake-td">{{$submit->project_id==0?'':\App\Models\Project::find($submit->project_id)->number}}</th>
                <th>项目内容</th>
                <th colspan="3" class="fake-td">{{$submit->project_id==0?'':\App\Models\Project::find($submit->project_id)->name}}</th>
            </tr>
            <tr>
                <th>报销人</th>
                <th class="fake-td">{{$submit->loan_user}}</th>
                <th>复核人</th>
                <th class="fake-td">{{$submit->checker}}</th>
                <th>审批人</th>
                <th class="fake-td">{{$submit->passer}}</th>
            </tr>
            <tr>
                <th>报销单据</th>
                <th>费用类别</th>
                <th>具体事项</th>
                <th>备注</th>
                <th>单据张数</th>
                <th>金额</th>
            </tr>
            </thead>
            <tbody>
            @foreach($lists as $list)
            <tr>
                <td>{{$list->id}}</td>
                <td>{{\App\Models\Category::find($list->category_id)->title}}</td>
                <td>{{$list->kind_id==0?'':\App\Models\Detail::find($list->kind_id)->title}}</td>
                <td>{{$list->remark}}</td>
                <td>{{$list->number}}</td>
                <td>{{$list->price}}￥</td>
            </tr>
            @endforeach
            </tbody>
            <tfoot>
            <tr>
                <th colspan="5">合计</th>
                <th>{{$submit->lists()->sum('price')}}￥</th>
            </tr>
            </tfoot>
        </table>
        <div class="content-operation print-hide">
            <div class="flex-row flex-end">
                <a class="ui icon button primary" href="javascript:window.print();">
                    <i class="icon print"></i>
                    <span>打印</span>
                </a>
            </div>
        </div>

    </div>
    <!-- /主体内容 === 不可复用 -->
@endsection
@section('pageJs')
    {{--<script src="{{url('js/project_list.js')}}"></script>--}}
@endsection