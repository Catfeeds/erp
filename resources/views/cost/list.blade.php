@extends('layouts.main')
@section('title','费用付款清单')
@section('content')
    <!-- 主体内容 === 不可复用 -->
    <div class="index-content print-no-padding">

        <div class="ui breadcrumb">
            <a class="section">费用付款管理</a>
            <div class="divider"> / </div>
            <div class="active section">费用审批清单</div>
        </div>

        <!-- 操作区域 -->
        <div class="content-operation">

            <form action="" class="ui form">
                <div class="flex-row flex-between flex-wrap">
                    <div>
                        <a class="ui primary button" href="javascript:_helper.fullWindow('{{url('new/pay/add')}}')">
                            <i class="icon plus"></i>
                            <span>新增费用申请</span>
                        </a>
                        <a class="ui green button" href="{{url('export/pay/list')}}">
                            <i class="icon download"></i>
                            <span>Excel 导出</span>
                        </a>
                    </div>
                    <div class="ui left action right input fluid flex-fluid">
                        <div class="ui button white dropdown ">
                            <input name="search-type" type="hidden">
                            <div class="text">请选中搜索内容</div>
                            <i class="dropdown icon"></i>
                            <div class="menu">
                                <div class="item" data-value="1">业务编号</div>
                                <div class="item" data-value="2">项目编号</div>
                                <div class="item" data-value="3">项目内容</div>
                                <div class="item" data-value="4">申请人</div>
                                <div class="item" data-value="5">审批人</div>
                                <div class="item" data-value="6">收款人</div>
                                <div class="item" data-value="7">费用类型</div>
                                <div class="item" data-value="8">具体事项</div>
                                <div class="item" data-value="9">用途</div>
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
                    <th class="function-toggle-one">项目编号（可展开）</th>
                    <th class="function-one">付款方式</th>
                    <th class="function-one">收款银行及账号</th>
                    <th>项目内容</th>
                    <th>付款金额</th>
                    <th>收款人</th>
                    <th>费用类型</th>
                    <th>具体事项</th>
                    <th style="min-width:250px;">用途</th>
                    <th>发票类型</th>
                    <th style="min-width:250px;">备注</th>
                    <th>申请人</th>
                    <th>审批人</th>
                    <th>已付款金额</th>
                    <th>应付账款</th>
                    <th>已收票金额</th>
                    <th>未收票金额</th>
                </tr>
                </thead>
                <tbody>
                @foreach($costs as $cost)
                <tr @if($cost->state==2)style="background-color:#CACBCD"@else @endif>
                    <td>
                        <a href="javascript:_helper.fullWindow('{{url('new/pay/single')}}?id={{$cost->id}}')">{{$cost->number}}</a>
                    </td>
                    <td>{{$cost->project_id==0?'':\App\Models\Project::find($cost->project_id)->number}}</td>
                    <td class="function-one">{{$cost->type==1?'现金':'付款'}}</td>
                    <td class="function-one">{{$cost->supplier_id==0?'':\App\Models\Supplier::find($cost->supplier_id)->bank}}</td>
                    <td class="table-content">{{$cost->project_id==0?'':\App\Models\Project::find($cost->project_id)->name}}</td>
                    <td>{{number_format($cost->apply_price,2)}}￥</td>
                    <td>{{$cost->supplier_id==0?'':\App\Models\Supplier::find($cost->supplier_id)->name}}</td>
                    <td>{{$cost->pay_type==0?'':\App\PayType::find($cost->pay_type)->title}}</td>
                    <td>{{$cost->pay_detail==0?'':\App\PayTypeDetail::find($cost->pay_detail)->title}}</td>
                    <td>{{$cost->application}}</td>
                    <td>{{$cost->invoice_type==0?'':\App\Models\Invoice::find($cost->invoice_type)->name}}</td>
                    <td>{{$cost->remark}}</td>
                    <td>{{$cost->proposer}}</td>
                    <td>{{$cost->approver}}</td>
                    <td>{{number_format(\App\Models\CostPay::where('cost_id','=',$cost->id)->sum('cost'),2)}}￥</td>
                    <td>{{number_format($cost->apply_price-\App\Models\CostPay::where('cost_id','=',$cost->id)->sum('cost'),2)}}￥</td>
                    <td>{{number_format(\App\Models\CostInvoice::where('cost_id','=',$cost->id)->sum('with_tax'),2)}}￥</td>
                    <td>{{number_format($cost->apply_price-\App\Models\CostInvoice::where('cost_id','=',$cost->id)->sum('with_tax'),2)}}￥</td>
                </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{$costs->appends(['search-type'=>$type,'value'=>$value])->links()}}
    </div>
    <!-- /主体内容 === 不可复用 -->
@endsection
@section('pageJs')
    <script src="{{url('js/pay_list.js')}}"></script>
@endsection