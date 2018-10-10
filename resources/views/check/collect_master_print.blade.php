@extends('layouts.main_no_nav')
@section('title','已立项清单')
@section('content')
    <!-- 没有导航的单独窗口页面 -->
    <div class="normal-content print-no-padding">

        <div class="ui breadcrumb print-hide">
            <a class="section">验收与收款管理</a>
            <div class="divider"> / </div>
            <a class="section" >验收与收款清单</a>
            <div class="divider"> / </div>
            <a class="section" >项目明细 - 项目号 {{$project->number}}</a>
            <div class="divider"> / </div>
            <div class="active section">主合同收款凭证</div>
        </div>


        <h1 class="ui header center aligned">项目收款记账凭证</h1>
        <table class="ui celled table">
            <tbody>
            <tr>
                <td class="print-bold">项目编号</td>
                <td>{{$project->number}}</td>
            </tr>
            <tr>
                <td class="print-bold">项目内容</td>
                <td>{{$project->name}}</td>
            </tr>
            <tr>
                <td class="print-bold">主合同/分包合同收款</td>
                <td>主合同收款</td>
            </tr>
            <tr>
                <td class="print-bold">付款单位</td>
                <td>{{$collect->payee}}</td>
            </tr>
            <tr>
                <td class="print-bold">收款日期</td>
                <td>{{$collect->date}}</td>
            </tr>
            <tr>
                <td class="print-bold">收款银行</td>
                <td>{{$collect->bank}}</td>
            </tr>
            <tr>
                <td class="print-bold">收款银行</td>
                <td>{{$collect->account}}</td>
            </tr>
            <tr>
                <td class="print-bold">收款金额</td>
                <td>{{number_format($collect->price,2)}} ￥</td>
            </tr>
            </tbody>
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