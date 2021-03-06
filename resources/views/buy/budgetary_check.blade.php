@extends('layouts.main_no_nav')
@section('title','采购查询')
@section('content')
    <!-- 没有导航的单独窗口页面 -->
    <div class="normal-content print-no-padding">

        <div class="ui breadcrumb">
            <a class="section">采购管理</a>
            <div class="divider"> / </div>
            <a class="section" href="{{url('purchases/list')}}" >采购清单</a>
            <div class="divider"> / </div>
            <div class="active section" >预算{{$purchase->type==1?'内':'外'}}采购</div>
            <div class="divider"> / </div>
            <div class="active section">查询</div>
        </div>

        <h1 class="ui header blue center aligned">预算{{$purchase->type==1?'内':'外'}}采购 - 查询</h1>
        <h4 class="ui dividing header blue">基本信息</h4>
        <table class="ui celled structured center aligned table selectable unstackable">
            <thead>
            <tr>
                <th>采购编号</th>
                <th class="font-normal bg-white">{{$purchase->number}}</th>
                <th>采购日期</th>
                <th class="font-normal bg-white">{{$purchase->date}}</th>
            </tr>
            <tr>
                <th rowspan="3">供货商</th>
                <th>供货商名称</th>
                <th class="font-normal bg-white" colspan="2">{{$purchase->supplier}}</th>
            </tr>
            <tr>
                <th>供货商收款银行</th>
                <th class="font-normal bg-white" colspan="2">{{$purchase->bank}}</th>
            </tr>
            <tr>
                <th>供货商收款银行</th>
                <th class="font-normal bg-white" colspan="2">{{$purchase->account}}</th>
            </tr>
            <tr>
                <th>采购金额</th>
                <th colspan="3" class="font-normal bg-white">{{number_format($purchase->lists()->sum('cost'),2)}} ￥</th>
            </tr>
            <tr>
                <th>项目编号</th>
                <th colspan="3" class="font-normal bg-white">{{$purchase->project_id==0?'':\App\Models\Project::find($purchase->project_id)->number}}</th>
            </tr>
            <tr>
                <th>项目内容</th>
                <th colspan="3" class="font-normal bg-white">{{$purchase->project_id==0?'':\App\Models\Project::find($purchase->project_id)->name}}</th>
            </tr>
            <tr>
                <th>发票条件</th>
                <th colspan="3" class="font-normal bg-white">{{$purchase->content}}</th>
            </tr>
            <tr>
                <th>付款条件</th>
                <th colspan="3" class="font-normal bg-white">{{$purchase->condition}}</th>
            </tr>
            </thead>
        </table>


        <h4 class="ui dividing header blue">采购物料清单</h4>
        <div class="table-head-nowrap">
            <table class="ui celled center aligned table selectable unstackable">
                <thead>
                <tr>
                    <th>序号</th>
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
                    <th>本次采购金额 </th>
                    <th>保修截止日期</th>
                    <th>保修时间</th>
                </tr>
                </thead>
                <tbody>
                @foreach($purchase->lists as $list)
                    {{--{{dd($purchase->lists)}}--}}
                <tr>
                    <td>{{$list->idNumber}}</td>
                    <td>{{$list->material->name}}</td>
                    <td>{{$list->material->param}}</td>
                    <td>{{$list->material->model}}</td>
                    <td>{{$list->material->factory}}</td>
                    <td>{{$list->material->unit}}</td>
                    <td>{{$list->budget_id!=0?number_format(\App\Models\Budget::find($list->budget_id)->price,2):0}} ￥</td>
                    <td>{{$list->budget_id!=0?\App\Models\Budget::find($list->budget_id)->number:0}}</td>
                    <td>{{$list->budget_id!=0?\App\Models\Budget::find($list->budget_id)->buy_number:0}}</td>
                    <td>{{$list->budget_id!=0?\App\Models\Budget::find($list->budget_id)->need_buy:0}}</td>
                    <td>{{$list->number}}</td>
                    <td>{{number_format($list->price,2)}} ￥</td>
                    <td>{{number_format($list->cost,2)}} ￥</td>
                    <td>{{$list->warranty_date}}</td>
                    <td>{{$list->warranty_time}} 天</td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <h4 class="ui dividing header blue">合同清单</h4>
        <div class="table-head-nowrap">
            <table class="ui celled center aligned table selectable unstackable">
                <thead>
                <tr>
                    <th>名称</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($contracts as $list)
                    {{--{{dd($purchase->lists)}}--}}
                    <tr>
                        <td>{{$list->name}}</td>
                        <td>
                            <a href="javascript:_helper.fullWindow('{{url($list->href)}}')">查看</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="flex-row flex-center margin-top-50">
            @if($purchase->state<3)
            <a class="ui icon button primary" href="{{$purchase->type==1?url("buy/budgetary_buy").'?buy_id='.$purchase->id:url('buy/extrabudgetary').'?id='.$purchase->id}}" style="margin:0 10px;">
                <i class="icon edit"></i>
                <span>修改</span>
            </a>
            @else
            @endif
            @if($purchase->state<3)
                <button class="ui icon button primary" data-id="{{$purchase->id}}" id="budgetaryCheckDelete" style="margin:0 10px;">
                    <i class="icon cancel"></i>
                    <span>删除</span>
                </button>
            @else
                @endif
            @if(checkRole($check,$purchase->id))
            <button class="ui icon button primary" id="budgetaryCheckRecheck" style="margin:0 10px;" data-id="{{$purchase->id}}">
                <i class="icon legal"></i>
                <span>复核</span>
            </button>
            @else
                @endif
            @if(checkRole($pass,$purchase->id))
            <button class="ui icon button primary" id="budgetaryCheckPass" data-id="{{$purchase->id}}" style="margin:0 10px;">
                <i class="icon write"></i>
                <span>审批</span>
            </button>
            @else
                @endif
            <a class="ui icon button green" href="javascript:_helper.fullWindow('{{url('buy/print/budgetary')}}?id={{$purchase->id}}')" style="margin:0 10px;">
                <i class="icon print"></i>
                <span>凭证</span>
            </a>
        </div>

        <div class="ui page dimmer" id="budgetaryCheck">
            <div class="simple dimmer content">
                <div class="center">
                    <div class="buy_dialog">
                        <div class="dialog_header">选择审批人</div>
                        <div class="dialog_content">
                            <el-checkbox-group v-model="checkedMen" @change="handleCheckManChange">
                                <el-checkbox v-for="man in menList" :label="man.id" :key="man.id">@{{man.name}}</el-checkbox>
                            </el-checkbox-group>
                        </div>
                        <div class="diolag_footer">
                            <button class="ui button primary" @click="confirmRecheck">确 定</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /主体内容 === 不可复用 -->

@endsection
@section('pageJs')
    <script src="{{url('js/buy_budgetary_check.js')}}"></script>
@endsection