@extends('layouts.main')
@section('title','已立项清单')
@section('content')
    <!-- 主体内容 === 不可复用 -->
    <div class="index-content print-no-padding">

        <div class="ui breadcrumb">
            <a class="section">费用付款管理</a>
            <div class="divider"> / </div>
            <div class="active section">付款审批清单</div>
        </div>

        <!-- 操作区域 -->
        <div class="content-operation">

            <form action="" class="ui form">
                <div class="flex-row flex-between flex-wrap">
                    <div>
                        <a class="ui primary button" href="javascript:_helper.fullWindow('{{url('pay/add')}}')">
                            <i class="icon plus"></i>
                            <span>付款申请</span>
                        </a>
                        <a class="ui green button" href="{{url('export/pay/apply')}}">
                            <i class="icon download"></i>
                            <span>Excel 导出</span>
                        </a>
                    </div>
                    <div class="ui left action right input fluid flex-fluid">
                        <div class="ui button white dropdown ">
                            <input name="seartch-type" type="hidden">
                            <div class="text">请选中搜索内容</div>
                            <i class="dropdown icon"></i>
                            <div class="menu">
                                <div class="item" data-value="2">业务编号</div>
                                <div class="item" data-value="3">项目编号</div>
                                <div class="item" data-value="4">项目内容</div>
                                <div class="item" data-value="5">申请人</div>
                                <div class="item" data-value="6">审批人</div>
                            </div>
                        </div>
                        <input name="value" type="text" placeholder="搜索内容" value="">
                        <button class="ui button">搜索</button>
                    </div>
                </div>
            </form>
        </div>
        <!-- / 操作区域 -->

        <div class="content-wrap table-head-nowrap">

            <table class="ui center aligned table selectable unstackable">
                <thead>
                <tr>
                    <th>业务编号</th>
                    <th>付款金额</th>
                    <th style="min-width:250px;">用途</th>
                    <th>项目编号</th>
                    <th>项目内容</th>
                    <th>申请人</th>
                    <th>审批人</th>
                    <th style="min-width:100px;">付款日期</th>
                    <th>现金</th>
                    <th>转账</th>
                    <th>银行及账号</th>
                    <th style="min-width:100px;">其他</th>
                    <th style="min-width:200px;">备注</th>
                    <th>付款经办人</th>
                </tr>
                </thead>
                <tbody>
                @foreach($lists as $list)
                    <tr>
                        <td>
                            <a href="javascript:_helper.fullWindow('{{url('pay/single')}}?id={{$list->id}}')">{{$list->number}}</a>
                        </td>
                        <td>{{number_format($list->price,2)}}￥</td>
                        <td style="max-width:350px;">{{$list->use}}</td>
                        <td>{{$list->project_number}}</td>
                        <td class="table-content">{{$list->project_content}}</td>
                        <td>{{$list->proposer}}</td>

                        <td>{{empty($list->approver)?'未审核':$list->approver}}</td>
                        @if($list->state!=3)
                        <td colspan="7">暂无数据</td>
                            @else

                            <td>{{$list->pay_date}}</td>
                            <td>{{number_format($list->cash,2)}}￥</td>
                            <td>{{number_format($list->transfer,2)}}￥</td>
                            <td>{{$list->bank}} {{$list->account}}</td>
                            <td>{{number_format($list->other,2)}}￥</td>
                            <td style="max-width: 250px;">{{$list->remark}}</td>
                            <td>{{$list->manager}}</td>
                        @endif
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

    </div>
    <!-- /主体内容 === 不可复用 -->
@endsection
@section('pageJs')
    <script src="{{url('js/pay_list.js')}}"></script>
@endsection