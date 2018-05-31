@extends('layouts.main')
@section('title','已立项清单')
@section('content')
    <!-- 主体内容 === 不可复用 -->
    <div class="index-content print-no-padding">

        <div class="ui breadcrumb">
            <a class="section">报销与借款管理</a>
            <div class="divider"> / </div>
            <div class="active section">借款清单</div>
        </div>

        <!-- 操作区域 -->
        <div class="content-operation">
            <a class="ui primary button" href="javascript:_helper.fullWindow('{{url('loan/loan/add')}}')">
                <i class="icon plus"></i>
                <span>新增借款申请</span>
            </a>
        </div>
        <!-- / 操作区域 -->

        <div class="content-wrap table-head-nowrap">
            <table class="ui center aligned table selectable unstackable">
                <thead>
                <tr>
                    <th>借款编号</th>
                    <th>借款金额</th>
                    <th>借款原因</th>
                    <th>借款人</th>
                    <th>审批人</th>
                    <th>付款日期</th>
                    <th>付款方式</th>
                    <th>银行及账号</th>
                    <th>付款经办人</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @for($i=0;$i<count($lists);$i++)
                {{--@foreach($lists as $list)--}}
                <tr data-id="{{$lists[$i]->id}}">
                    <td>{{$lists[$i]->number}}</td>
                    <td>{{number_format($lists[$i]->price)}}￥</td>
                    <td style="max-width:300px">{{$lists[$i]->reason}}</td>
                    <td>{{$lists[$i]->borrower}}</td>
                    @if($lists[$i]->approver_id==0)
                    <td>未审批</td>
                    @else
                        <td>{{\App\User::find($lists[$i]->approver_id)->name}}</td>
                    @endif
                    @if(empty($lists[$i]->pay_date))
                    <td colspan="4">暂无数据</td>
                    @else
                        <td>{{$lists[$i]->pay_date}}</td>
                        <td>{{$lists[$i]->pay_type==1?'现金':'转账'}}</td>
                    @if($lists[$i]->pay_type==1)
                            <td></td>
                        @else
                        <td>{{$lists[$i]->bank}} {{$lists[$i]->account}}</td>
                        @endif
                        <td>{{$lists[$i]->manager}}</td>
                        @endif
                    <td style="white-space:nowrap;">
                        @if($lists[$i]->state==1)
                        <button class="ui mini button negative loanLoanListCancel">撤销</button>
                        @if(checkRole('loan_loan_pass',$lists[$i]->id))
                        <button class="ui mini button positive loanLoanListCheck">审批</button>
                            @else
                            @endif
                            @elseif($lists[$i]->state==2)
                            <a class="ui mini button primary" href="javascript:_helper.fullWindow('{{url('loan/pay')}}?id={{$lists[$i]->id}}')">录入/修改</a>
                            <a class="ui mini button positive" href="javascript:_helper.fullWindow('{{url('loan/print')}}?id={{$lists[$i]->id}}')">凭证</a>
                            @else
                        @endif
                    </td>
                </tr>
                @endfor
                {{--@endforeach--}}
                </tbody>
            </table>
        </div>
        {{$lists->links()}}
    </div>
    <!-- /主体内容 === 不可复用 -->
@endsection
@section('pageJs')
    <script src="{{url('js/loan_loan_list.js')}}"></script>
@endsection