@extends('layouts.main')
@section('title','已立项清单')
@section('content')
    <!-- 没有导航的单独窗口页面 -->
    <div class="normal-content print-no-padding">

        <div class="ui breadcrumb">
            <a class="section">报销与借款管理</a>
            <div class="divider"> / </div>
            <a class="section" href="../loan/pay_list.html">报销付款清单</a>
            <div class="divider"> / </div>
            <div class="active section">报销付款查询 - {{$loan->number}}</div>
        </div>

        <h3 class="ui header center aligned">报销付款查询 - {{$loan->number}}</h3>
        <table class="ui celled center aligned table selectable">
            <thead>
            <tr>
                <th>付款日期</th>
                <th class="fake-td">{{$loan->date}}</th>
                <th>付款报销编号</th>
                <th class="fake-td">{{$loan->number}}</th>
                <th>报销人</th>
                <th class="fake-td">{{$loan->applier}}</th>
            </tr>
            <tr>
                <th>本次支付报销单</th>
                <th>报销编号</th>
                <th>报销金额</th>
                <th>复核人</th>
                <th>审批人</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @for($i=0;$i<count($lists);$i++)
            <tr>
                <td>{{$i+1}}</td>
                <td>{{$lists[$i]->number}}</td>
                <td>{{number_format($lists[$i]->price,2)}}￥</td>
                <td>{{$lists[$i]->checker}}</td>
                <td>{{$lists[$i]->passer}}</td>
                <td></td>
            </tr>
            @endfor
            </tbody>
            <tfoot>
            <tr>
                <th colspan="2">本次支付报销合计</th>
                <th>{{number_format($price,2)}}￥</th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
            <tr>
                <th></th>
                <th>抵扣借款</th>
                <th>现金付款</th>
                <th>银行转账</th>
                <th></th>
                <th></th>
            </tr>
            <tr>
                <th>初始数据</th>
                <th class="fake-td">{{number_format($loan->deduction,2)}}￥</th>
                <th class="fake-td">{{number_format($loan->cash,2)}}￥</th>
                <th class="fake-td">{{number_format($loan->transfer,2)}}￥</th>
                <th class="fake-td"></th>
                <th class="fake-td"></th>
            </tr>
            <tr>
                <th>本次支付</th>
                <th class="fake-td">{{number_format($loan->deduction,2)}}￥</th>
                <th class="fake-td">{{number_format($loan->cash,2)}}￥</th>
                <th class="fake-td">{{number_format($loan->transfer,2)}}￥</th>
                <th class="fake-td"></th>
                <th class="fake-td"></th>
            </tr>
            <tr>
                <th>付款银行及账号</th>
                <th colspan="5" class="fake-td">{{$loan->bank}} {{$loan->account}}</th>
            </tr>
            <tr>
                <th>付款经办人</th>
                <th colspan="5" class="fake-td">{{\App\User::find($loan->worker)->username}}</th>
            </tr>
            </tfoot>
        </table>

        <div class="flex-row flex-center margin-top-50">
            {{--<a class="ui icon button primary" href="javascript:_helper.fullWindow('../loan/pay_add.html?id=1')" style="margin:0 20px;">--}}
                {{--<i class="icon edit"></i>--}}
                {{--<span>修改</span>--}}
            {{--</a>--}}
            <a class="ui icon button positive" href="javascript:_helper.fullWindow('{{url('loan/pay/print')}}?id={{$loan->id}}')" style="margin:0 20px;">
                <i class="icon print"></i>
                <span>凭证</span>
            </a>
        </div>


    </div>
    <!-- /主体内容 === 不可复用 -->
@endsection
@section('pageJs')
{{--    <script src="{{url('js/project_list.js')}}"></script>--}}
@endsection