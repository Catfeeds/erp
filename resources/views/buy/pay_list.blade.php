@extends('layouts.main')
@section('title','采购付款清单')
@section('content')
    <!-- 主体内容 === 不可复用 -->
    <div class="index-content print-no-padding">

        <div class="ui breadcrumb">
            <a class="section">采购管理</a>
            <div class="divider"> / </div>
            <div class="active section">采购付款清单</div>
        </div>

        <!-- 操作区域 -->
        <div class="content-operation flex-row flex-between flex-wrap" style="align-items: flex-end;">
            <div>
                <a class="ui green button" href="{{url('export/purchases/pay/list')}}">
                    <i class="icon download"></i>
                    <span>Excel 导出</span>
                </a>
            </div>
            <form method="get" class="ui form flex-fluid">
                <div class="flex-row flex-end flex-wrap">
                    <div class="inline fields" style="margin-right:40px;">
                        <label>系统状态：</label>
                        <div class="field">
                            <div class="ui radio checkbox">
                                <input type="radio" name="finish" value="1">
                                <label>已结清</label>
                            </div>
                        </div>
                        <div class="field">
                            <div class="ui radio checkbox">
                                <input type="radio" name="finish" value="2">
                                <label>未结清</label>
                            </div>
                        </div>
                    </div>
                    {{--<div class="inline fields">--}}
                        {{--<label>操作状态：</label>--}}
                        {{--<div class="field">--}}
                            {{--<div class="ui radio checkbox">--}}
                                {{--<input type="radio" name="payment" value="1">--}}
                                {{--<label>待处理</label>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="field">--}}
                            {{--<div class="ui radio checkbox">--}}
                                {{--<input type="radio" name="payment" value="0">--}}
                                {{--<label>未处理</label>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                </div>
                <div class="ui left action right input fluid">
                    <div class="ui button white dropdown ">
                        <input name="search-type" type="hidden">
                        <div class="text">请选中搜索内容</div>
                        <i class="dropdown icon"></i>
                        <div class="menu">
                            <div class="item" data-value="1">采购编号</div>
                            <div class="item" data-value="2">供货商</div>
                            <div class="item" data-value="3">项目编号</div>
                            <div class="item" data-value="4">项目内容</div>
                            <div class="item" data-value="5">项目负责人</div>
                        </div>
                    </div>
                    <input name="search" type="text" placeholder="搜索内容" value="">
                    <button class="ui button">搜索</button>
                </div>
            </form>
        </div>
        <!-- / 操作区域 -->

        <div class="content-wrap table-head-nowrap">

            <table class="ui center aligned table selectable unstackable">
                <thead>
                <tr>
                    <th>采购编号</th>
                    <th>供货商</th>
                    <th>采购金额</th>
                    <th>项目编号</th>
                    <th>项目内容</th>
                    <th>项目经理</th>
                    <th>已付款</th>
                    <th>应付账款</th>
                    <th>系统状态</th>
                    <th>操作状态</th>
                    <th>支票</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($lists as $list)
                <tr @if($list->count!=0)style="background-color:#CACBCD"@else @endif>
                    <td>
                        <a href="javascript:_helper.fullWindow('{{url('buy/payment/list')}}?id={{$list->id}}')">{{$list->number}}</a>
                    </td>
                    <td>{{$list->supplier}}</td>
                    <td>{{number_format($list->lists()->sum('cost'),2)}} </td>
                    <td>{{$list->project_id==0?'':\App\Models\Project::find($list->project_id)->number}}</td>
                    <td class="table-content" title="{{$list->project_id==0?'':\App\Models\Project::find($list->project_id)->name}}">{{$list->project_id==0?'':\App\Models\Project::find($list->project_id)->name}}</td>
                    <td>{{$list->project_id==0?'':\App\Models\Project::find($list->project_id)->pm}}</td>
                    <td>{{number_format($list->payments()->sum('pay_price'),2)}} </td>
                    <td>{{number_format($list->lists()->sum('cost')-$list->payments()->sum('pay_price'),2)}} </td>
                    <td>{{$list->lists()->sum('cost')-$list->payments()->sum('pay_price')==0?'已结清':'未结清'}}</td>
                    <td>{{$list->count==0?'':'待处理'}}</td>
                    <td title="{{$list->cheque}}">{{$list->cheque}}</td>
                    <td class="pay-operation" data-id="{{$list->id}}"><span style="color: #1e5fc2">修改支票</span></td>
                </tr>
                @endforeach

                </tbody>
            </table>
        </div>
        {{$lists->appends(['search'=>$search])->links()}}
    </div>
    <!-- /主体内容 === 不可复用 -->
@endsection
@section('pageJs')
    <script src="{{url('js/buy_pay_list.js')}}"></script>
@endsection