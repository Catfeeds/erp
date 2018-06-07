@extends('layouts.main_no_nav')
@section('title','已立项清单')
@section('content')
    <!-- 没有导航的单独窗口页面 -->
    <div class="normal-content print-no-padding">

        <div class="ui breadcrumb print-hide">
            <a class="section">验收与收款管理</a>
            <div class="divider"> / </div>
            <a class="section" href="../check/list.html">验收与收款清单</a>
            <div class="divider"> / </div>
            <a class="section" href="../check/detail.html">项目明细 - 项目号 {{\App\Models\Project::find($invoice->project_id)->number}}</a>
            <div class="divider"> / </div>
            <div class="active section">开票凭证</div>
        </div>


        <h1 class="ui header center aligned">开票记帐凭证 </h1>
        {{--<p style="text-align:right;font-size: 13px;padding-right:25px;">记账凭证号：12312321231321321</p>--}}
        <table class="ui celled table center aligned">
            <thead>
            <tr>
                <th>项目编号</th>
                <th class="fake-td" colspan="2">{{\App\Models\Project::find($invoice->project_id)->number}}</th>
                <th>项目内容</th>
                <th class="fake-td" colspan="2">{{\App\Models\Project::find($invoice->project_id)->name}}</th>
            </tr>
            <tr>
                <th>开票日期</th>
                <th class="fake-td" colspan="2">{{$invoice->date}}</th>
                <th>税率</th>
                <th class="fake-td" colspan="2">{{\App\Models\Invoice::find($invoice->rate)->rate}}%</th>
            </tr>
            <tr>
                <th>付款单位</th>
                <th class="fake-td" colspan="5">{{$invoice->unit}}</th>
            </tr>
            <tr>
                <th>序号</th>
                <th>发票号码</th>
                <th>含税销售额</th>
                <th>税额</th>
                <th>不含税销售额</th>
                <th>摘要</th>
            </tr>
            </thead>
            <tbody>
            @for($i=0;$i<count($lists);$i++)
            <tr>
                <td>{{$i+1}}</td>
                <td>{{$lists[$i]->number}}</td>
                <td>{{number_format($lists[$i]->tax_include,2)}} ￥</td>
                <td>{{number_format($lists[$i]->tax_price,2)}} ￥</td>
                <td>{{number_format($lists[$i]->tax_without,2)}} ￥</td>
                <td>{{$lists[$i]->remark}}</td>
            </tr>
            @endfor
            </tbody>
            <tfoot>
            <tr>
                <th colspan="2">合计</th>
                <th>{{number_format($invoice->lists()->sum('tax_include'),2)}} ￥</th>
                <th>{{number_format($invoice->lists()->sum('tax_price'),2)}} ￥</th>
                <th>{{number_format($invoice->lists()->sum('tax_without'),2)}} ￥</th>
                <th></th>
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
{{--    <script src="{{url('js/project_list.js')}}"></script>--}}
@endsection