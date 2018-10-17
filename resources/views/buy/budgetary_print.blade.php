@extends('layouts.main_no_nav')
@section('title','凭证')
@section('content')
    <!-- 没有导航的单独窗口页面 -->
    <div class="normal-content print-no-padding">

        <div class="ui breadcrumb print-hide">
            <a class="section">采购管理</a>
            <div class="divider"> / </div>
            <a class="section" href="{{url('purchases/list')}}" >采购清单</a>
            <div class="divider"> / </div>
            <div class="section active" >预算{{$purchase->type==1?'内':'外'}}采购</div>
            <div class="divider"> / </div>
            <div class="active section">凭证</div>
        </div>


        <h1 class="ui header center aligned">采购立项记帐凭证（预算{{$purchase->type==1?'内':'外'}}） </h1>
        <p style="text-align:right;font-size: 13px;padding-right:25px;">记账凭证号：</p>
        <table class="ui celled structured table" id="budgetaryPrint">
            <thead>
            <tr>
                <th colspan="2">采购编号</th>
                <th class="font-normal bg-white" colspan="3">{{$purchase->number}}</th>
                <th colspan="2" >采购日期</th>
                <th class="font-normal bg-white" colspan="3">{{$purchase->date}}</th>
                <th colspan="2">采购金额</th>
                <th class="font-normal bg-white" colspan="3">{{number_format($purchase->lists()->sum('cost'),2)}} ￥</th>
            </tr>
            <tr>
                <th colspan="2">项目编号</th>
                <th class="font-normal bg-white" colspan="3">{{$purchase->project_id==0?'':\App\Models\Project::find($purchase->project_id)->number}}</th>
                <th colspan="2">项目内容</th>
                <th class="font-normal bg-white" colspan="3">{{$purchase->project_id==0?'':\App\Models\Project::find($purchase->project_id)->name}}</th>
                <th colspan="2">供货商</th>
                <th class="font-normal bg-white" colspan="3">{{$purchase->supplier}}</th>
            </tr>
            <tr>
                <th colspan="2">发票条件</th>
                <th class="font-normal bg-white" colspan="5">{{$purchase->content}}</th>
                <th colspan="2">付款条件</th>
                <th class="font-normal bg-white" colspan="6">{{$purchase->condition}}</th>
            </tr>
            <tr>
                <th colspan="2">经办人</th>
                <th class="font-normal bg-white" colspan="3">{{$purchase->worker}}</th>
                <th colspan="2">复核人</th>
                <th class="font-normal bg-white" colspan="3">{{$purchase->check==0?"":\App\User::find($purchase->check)->username}}</th>
                <th colspan="2">审批人</th>
                <th class="font-normal bg-white" colspan="3">{{$purchase->pass==0?'':\App\User::find($purchase->pass)->username}}</th>
            </tr>
            <tr>
                <th colspan="15" class="inline-center">采购物料清单</th>
            </tr>
            <tr class="no-padding">
                <th></th>
                <th>物料名称</th>
                <th>性能及技术参数</th>
                <th>品牌型号</th>
                <th>生产厂家</th>
                <th>单位</th>
                <th>预算单价</th>
                <th>预算数量</th>
                <th>已采购数量</th>
                <th>剩余未采购数量</th>
                <th>本次采购数量</th>
                <th>本次采购单价</th>
                <th>本次采购金额</th>
                <th>保修截止日期</th>
                <th>保修时间</th>
            </tr>
            </thead>
            <tbody>
            @for($i=0;$i<count($lists);$i++)
            <tr>
                <td>{{$i+1}}</td>
                <td>{{$lists[$i]->material->name}}</td>
                <td>{{$lists[$i]->material->param}}</td>
                <td>{{$lists[$i]->material->model}}</td>
                <td>{{$lists[$i]->material->factory}}</td>
                <td>{{$lists[$i]->material->unit}}</td>
                <td>{{$lists[$i]->budget_id!=0?number_format(\App\Models\Budget::find($lists[$i]->budget_id)->price,2):0}} ￥</td>
                <td>{{$lists[$i]->budget_id!=0?\App\Models\Budget::find($lists[$i]->budget_id)->number:0}}</td>
                <td>{{$lists[$i]->budget_id!=0?\App\Models\Budget::find($lists[$i]->budget_id)->buy_number:0}}</td>
                <td>{{$lists[$i]->budget_id!=0?\App\Models\Budget::find($lists[$i]->budget_id)->need_buy:0}}</td>
                <td>{{$lists[$i]->number}}</td>
                <td>{{number_format($lists[$i]->price,2)}} ￥</td>
                <td>{{number_format($lists[$i]->cost,2)}} ￥</td>
                <td>{{$lists[$i]->warranty_date}}</td>
                <td>{{$lists[$i]->warranty_time}} </td>
            </tr>
                @endfor
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