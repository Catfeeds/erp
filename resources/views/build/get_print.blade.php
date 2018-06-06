@extends('layouts.main_no_nav')
@section('title','已立项清单')
@section('content')
    <!-- 没有导航的单独窗口页面 -->
    <div class="normal-content print-no-padding">

        <div class="ui breadcrumb print-hide">
            <a class="section">施工管理</a>
            <div class="divider"> / </div>
            <a class="section" href="../build/get_list.html">施工收票清单</a>
            <div class="divider"> / </div>
            <a class="section" href="../build/get_single.html?id=CG12512312521">施工收票查询 </a>
            <div class="divider"> / </div>
            <div class="active section">凭证</div>
        </div>

        <h1 class="ui header center aligned">施工收票记帐凭证</h1>
        {{--<p style="text-align:right;font-size: 13px;padding-right:20px;"><b>记账凭证号：</b>12352323231</p>--}}
        <p style="text-align:right;font-size: 13px;padding-right:20px;"><b>附件：</b> <span style="padding: 0 20px;"></span> <b>张</b></p>

        <table class="ui celled center aligned table selectable unstackable">
            <thead>
            <tr>
                <th>施工经理</th>
                <th class="fake-td">{{$projectTeam->manager}}</th>
                <th>施工队</th>
                <th class="fake-td" colspan="2">{{$projectTeam->team}}</th>
                <th>项目经理</th>
                <th class="fake-td">{{$projectTeam->project_manager}}</th>
                <th>完工请款金额</th>
                <th class="fake-td">{{number_format($projectTeam->price,2)}} ￥</th>
            </tr>
            <tr>
                <th>项目编号</th>
                <th class="fake-td">{{$projectTeam->project_number}}</th>
                <th>项目内容</th>
                <th colspan="4" class="fake-td">{{$projectTeam->project_content}}</th>
                <th>已付款金额</th>
                <th class="fake-td">{{number_format($projectTeam->applies()->where('state','=',3)->sum('pay_price'),2)}} ￥</th>
            </tr>
            <tr>
                <th colspan="10">收票记录</th>
            </tr>
            <tr>
                <th></th>
                <th>收票日期</th>
                <th>开票日期</th>
                <th>发票号码</th>
                <th>发票类型</th>
                <th>收票经办人</th>
                <th>不含税金额</th>
                <th>税额</th>
                <th>含税金额</th>
            </tr>
            </thead>
            <tbody>
            @for($i=0;$i<count($invoices);$i++)
            <tr>
                <td>{{$i+1}}</td>
                <td>{{$invoices[$i]->date}}</td>
                <td>{{$invoices[$i]->invoice_date}}</td>
                <td>{{$invoices[$i]->number}}</td>
                <td>{{$invoices[$i]->type}}</td>
                <td>{{$invoices[$i]->worker}}</td>
                <td>{{number_format($invoices[$i]->without_tax,2)}} ￥</td>
                <td>{{number_format($invoices[$i]->tax,2)}} ￥</td>
                <td>{{number_format($invoices[$i]->with_tax,2)}} ￥</td>
            </tr>
            @endfor
            </tbody>
            <tfoot>
            <tr>
                <th colspan="6">合计</th>
                <th>{{number_format($projectTeam->invoices()->sum('without_tax'),2)}} ￥</th>
                <th>{{number_format($projectTeam->invoices()->sum('tax'),2)}} ￥</th>
                <th>{{number_format($projectTeam->invoices()->sum('with_tax'),2)}} ￥</th>
            </tr>
            <tr>
                <th colspan="8">未收票金额</th>
                <th>{{number_format($projectTeam->pay_price-$projectTeam->invoices()->sum('with_tax'),2)}}￥</th>
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