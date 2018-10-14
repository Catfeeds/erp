@extends('layouts.main_no_nav')
@section('title','施工收票查询')
@section('content')
    <!-- 没有导航的单独窗口页面 -->
    <div class="normal-content print-no-padding">

        <div class="ui breadcrumb">
            <a class="section">施工管理</a>
            <div class="divider"> / </div>
            <a class="section" >施工收票清单</a>
            <div class="divider"> / </div>
            <div class="active section">施工收票查询</div>
        </div>

        <h3 class="ui header center aligned">施工收票查询</h3>
        <div class=" table-head-nowrap">
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
                    <th class="fake-td" colspan="2">{{number_format($projectTeam->payments()->where('state','>=',3)->sum('price'),2)}} ￥</th>
                </tr>
                <tr>
                    <th>项目编号</th>
                    <th class="fake-td">{{$projectTeam->project_number}}</th>
                    <th>项目内容</th>
                    <th colspan="4" class="fake-td">{{$projectTeam->project_content}}</th>
                    <th>已付款金额</th>
                    <th class="fake-td" colspan="2">{{number_format($projectTeam->applies()->where('state','=',4)->sum('apply_price'),2)}} ￥</th>
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
                    <th>操作</th>
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
                    <td style="white-space: nowrap;">
                        <a class="ui mini primary button" href="javascript:_helper.fullWindow('{{url('build/get/edit')}}?id={{$invoices[$i]->id}}')" title="修改">修改</a>
                    </td>
                </tr>
                @endfor
                </tbody>
                <tfoot>
                <tr>
                    <th colspan="6">合计</th>
                    <th>{{number_format($projectTeam->invoices()->sum('without_tax'),2)}} ￥</th>
                    <th>{{number_format($projectTeam->invoices()->sum('tax'),2)}} ￥</th>
                    <th>{{number_format($projectTeam->invoices()->sum('with_tax'),2)}} ￥</th>
                    <th></th>
                </tr>
                <tr>
                    <th colspan="8">未收票金额</th>
                    <th>{{number_format($projectTeam->payments()->where('state','>=',3)->sum('price')-$projectTeam->invoices()->sum('with_tax'),2)}}￥</th>
                    <th></th>
                </tr>
                </tfoot>
            </table>
        </div>
        <div class="flex-row flex-center margin-top-50">
            <a class="ui icon button primary" href="javascript:_helper.fullWindow('{{url('build/get/add')}}?id={{$projectTeam->id}}')" style="margin:0 10px;">
                <i class="icon yen"></i>
                <span>收票</span>
            </a>
            <a class="ui icon button positive" href="javascript:_helper.fullWindow('{{url('build/get/print')}}?id={{$projectTeam->id}}')" style="margin:0 10px;">
                <i class="icon print"></i>
                <span>凭证</span>
            </a>
        </div>

    </div>
    <!-- /主体内容 === 不可复用 -->

@endsection
@section('pageJs')
    <script src="{{url('js/buy_invoice_list.js')}}"></script>
@endsection