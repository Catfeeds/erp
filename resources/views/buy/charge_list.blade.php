@extends('layouts.main')
@section('title','已立项清单')
@section('content')
    <!-- 主体内容 === 不可复用 -->
    <div class="index-content print-no-padding">

        <div class="ui breadcrumb">
            <a class="section">采购管理</a>
            <div class="divider"> / </div>
            <div class="active section">采购收票清单</div>
        </div>

        <!-- 操作区域 -->
        <div class="content-operation flex-row flex-between flex-wrap" style="align-items: flex-end;">
            <div>
                <a class="ui green button" href="{{url('export/purchase/charge/list')}}">
                    <i class="icon download"></i>
                    <span>Excel 导出</span>
                </a>
            </div>
            <form action="/views/buy/charge_list.html" class="ui form flex-fluid">
                <div class="flex-row flex-end flex-wrap">
                    <div class="inline fields" style="margin-right:50px;">
                        <select name="invoice" class="ui dropdown">
                            <option value="">选择发票条件</option>
                            <option value="1">专用票17%</option>
                            <option value="0">专用票9%</option>
                        </select>
                    </div>
                    <div class="inline fields">
                        <label>系统状态：</label>
                        <div class="field">
                            <div class="ui radio checkbox">
                                <input type="radio" name="system" value="1">
                                <label>已结清</label>
                            </div>
                        </div>
                        <div class="field">
                            <div class="ui radio checkbox">
                                <input type="radio" name="system" value="0">
                                <label>未结清</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ui left action right input fluid">
                    <div class="ui button white dropdown ">
                        <input name="seartch-type" type="hidden">
                        <div class="text">请选中搜索内容</div>
                        <i class="dropdown icon"></i>
                        <div class="menu">
                            <div class="item" data-value="1">采购编号</div>
                            <div class="item" data-value="2">供货商</div>
                            <div class="item" data-value="3">项目编号</div>
                            <div class="item" data-value="4">项目内容</div>
                            <div class="item" data-value="5">项目经理</div>
                        </div>
                    </div>
                    <input name="value" type="text" placeholder="搜索内容" value="">
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
                    <th>发票条件</th>
                    <th>已收票</th>
                    <th>未收票</th>
                    <th>系统状态</th>
                </tr>
                </thead>
                <tbody>
                @foreach($purchases as $purchase)
                <tr>
                    <td>
                        <a href="javascript:_helper.fullWindow('{{url('buy/list/invoice')}}?id={{$purchase->id}}')">{{$purchase->number}}</a>
                    </td>
                    <td>{{$purchase->supplier}}</td>
                    <td>{{number_format($purchase->lists()->sum('cost'))}} ￥</td>
                    <td>{{$purchase->project_id==0?'':\App\Models\Project::find($purchase->project_id)->number}}</td>
                    <td class="table-content">{{$purchase->project_id==0?'':\App\Models\Project::find($purchase->project_id)->name}}</td>
                    <td>{{$purchase->project_id==0?'':\App\Models\Project::find($purchase->project_id)->pm}}</td>
                    <td>{{$purchase->content}}</td>
                    <td>{{number_format($purchase->invoices()->sum('with_tax'))}} ￥</td>
                    <td>{{number_format($purchase->lists()->sum('cost')-$purchase->invoices()->sum('with_tax'))}} ￥</td>
                    <td>{{$purchase->lists()->sum('cost')-$purchase->invoices()->sum('with_tax')==0?'已':'未'}}结清</td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>

    </div>
    <!-- /主体内容 === 不可复用 -->
@endsection
@section('pageJs')
    <script src="{{url('js/buy_charge_list.js')}}"></script>
@endsection