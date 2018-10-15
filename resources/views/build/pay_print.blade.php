@extends('layouts.main_no_nav')
@section('title','凭证')
@section('content')
    <!-- 没有导航的单独窗口页面 -->
    <div class="normal-content print-no-padding">

        <div class="ui breadcrumb print-hide">
            <a class="section">施工管理</a>
            <div class="divider"> / </div>
            <a class="section" href="{{url('build/pay/list')}}" >施工付款款清单</a>
            <div class="divider"> / </div>
            <a class="section" href="{{url('build/pay/single?id=')}}{{$team->id}}" >付款查询 </a>
            <div class="divider"> / </div>
            <div class="active section">凭证</div>
        </div>

        <h1 class="ui header center aligned">施工付款记帐凭证</h1>
        <p style="text-align:right;font-size: 13px;padding-right:20px;">
            <b>记账凭证号：</b></p>
        <table class="ui celled center aligned table selectable" style="margin-bottom:0;">
            <thead>
            <tr>
                <th >施工队</th>
                <th colspan="2">{{$team->team}}</th>
                <th >施工经理</th>
                <th colspan="2">{{$team->manager}}</th>
                <th >开户银行</th>
                <th colspan="2">{{$info->bank}}</th>
                <th >账号</th>
                <th colspan="3">{{$info->account}}</th>
            </tr>
            <tr>
                <th colspan="13">完工请款</th>
            </tr>
            <tr>
                <th colspan="2">项目编号</th>
                <th colspan="2">项目内容</th>
                {{--<th></th>--}}
                {{--<th></th>--}}
                <th colspan="2">项目经理</th>
                {{--<th></th>--}}
                <th>已完工请款</th>
                <th>请款编号</th>
                <th>请款日期</th>
                <th>经办人</th>
                <th>复核人</th>
                <th>审批人</th>
                <th>请款金额</th>
            </tr>
            @if(!empty($payments))
            @for($i=0;$i<count($payments);$i++)
            <tr>
                @if($i==0)
                {{--<th class="fake-td"></th>--}}
                {{--<th class="fake-td"></th>--}}
                <th colspan="2" class="fake-td">{{$team->project_number}}</th>
                <th colspan="2" class="fake-td">{{$team->project_content}}</th>
                <th colspan="2" class="fake-td">{{$team->project_manager}}</th>
                {{--<th class="fake-td"></th>--}}
                @else
                    {{--<th class="fake-td"></th>--}}
                    {{--<th class="fake-td"></th>--}}
                    {{--<th class="fake-td"></th>--}}
                    <th colspan="2" class="fake-td"></th>
                    <th colspan="2" class="fake-td"></th>
                    <th colspan="2" class="fake-td"></th>
                    @endif
                <th class="fake-td">{{$i+1}}</th>
                <th class="fake-td">{{$payments[$i]->number}}</th>
                <th class="fake-td">{{$payments[$i]->request_date}}</th>
                <th class="fake-td">{{$payments[$i]->applier}}</th>
                <th class="fake-td">{{$payments[$i]->checker}}</th>
                <th class="fake-td">{{$payments[$i]->passer}}</th>
                <th class="fake-td">{{number_format($payments[$i]->price,2)}} ￥</th>
            </tr>
            @endfor
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th colspan="6">合计</th>
                <th>{{number_format($team->payments()->where('state','=',3)->sum('price'),2)}} ￥</th>
            </tr>
            @else
                @endif
            <tr>
                <th colspan="8">申请付款</th>
                <th colspan="5">实际付款</th>
            </tr>
            <tr>
                <th>付款编号</th>
                <th>申请付款日期</th>
                <th>申请付款金额</th>
                <th>收款人名称</th>
                <th>收款银行及账号</th>
                <th>经办人</th>
                <th>复核人</th>
                <th>审批人</th>
                <th>付款日期</th>
                <th>付款金额</th>
                <th>付款银行及账号</th>
                <th>备注</th>
                <th>经办人</th>
            </tr>
            </thead>
            <tbody>
            @if(count($applies)!=0)
            @for($i=0;$i<count($applies);$i++)
            <tr>
                <td>{{$applies[$i]->number}}</td>
                <td>{{$applies[$i]->apply_date}}</td>
                <td>{{number_format($applies[$i]->apply_price,2)}}￥</td>
                <td>{{$applies[$i]->payee}}</td>
                <td>{{$applies[$i]->bank}} {{$applies[$i]->account}}</td>
                <td>{{$applies[$i]->worker}}</td>
                <td>{{$applies[$i]->checker}}</td>
                <td>{{$applies[$i]->passer}}</td>
                <td>{{$applies[$i]->pay_date}}</td>
                <td>{{number_format($applies[$i]->pay_price,2)}}￥</td>
                <td>{{$applies[$i]->pay_bank}} {{$applies[$i]->pay_account}}</td>
                <td style="max-width:150px;">{{$applies[$i]->remark}}</td>
                <td>{{$applies[$i]->pay_worker}}</td>
            </tr>
            @endfor
            </tbody>
            <tfoot>
            <tr>
                <th colspan="12">已付款合计</th>
                <th>{{number_format($team->applies()->sum('pay_price'),2)}}￥</th>
            </tr>
            <tr>
                <th colspan="12">剩余应付账款</th>
                <th>{{number_format($team->payments()->where('state','=',3)->sum('price')-$team->applies()->where('state','=',4)->sum('pay_price'),2)}}￥</th>
            </tr>
            </tfoot>
            @else
                @endif
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