@extends('layouts.main')
@section('title','已立项清单')
@section('content')
    <!-- 主体内容 === 不可复用 -->
    <div class="index-content print-no-padding">

        <div class="ui breadcrumb">
            <a class="section">采购管理</a>
            <div class="divider"> / </div>
            <div class="active section">采购清单</div>
        </div>
        <!-- 操作区域 -->
        <div class="content-operation flex-row flex-between flex-wrap" style="align-items: flex-end;">
            <div>
                <a class="ui green button" href="#">
                    <i class="icon download"></i>
                    <span>Excel 导出</span>
                </a>
            </div>
            <form action="/views/buy/list.html" class="ui form flex-fluid">
                <div class="flex-row flex-around flex-wrap">
                    <div class="inline fields">
                        <label>收货情况：</label>
                        <div class="field">
                            <div class="ui radio checkbox">
                                <input type="radio" name="receive" value="1">
                                <label>已收全</label>
                            </div>
                        </div>
                        <div class="field">
                            <div class="ui radio checkbox">
                                <input type="radio" name="receive" value="0">
                                <label>未收全</label>
                            </div>
                        </div>
                    </div>
                    <div class="inline fields">
                        <label>付款情况：</label>
                        <div class="field">
                            <div class="ui radio checkbox">
                                <input type="radio" name="payment" value="1">
                                <label>已付清</label>
                            </div>
                        </div>
                        <div class="field">
                            <div class="ui radio checkbox">
                                <input type="radio" name="payment" value="0">
                                <label>未付清</label>
                            </div>
                        </div>
                    </div>
                    <div class="inline fields">
                        <label>收票情况：</label>
                        <div class="field">
                            <div class="ui radio checkbox">
                                <input type="radio" name="invoice" value="1">
                                <label>已全收</label>
                            </div>
                        </div>
                        <div class="field">
                            <div class="ui radio checkbox">
                                <input type="radio" name="invoice" value="0">
                                <label>未全收</label>
                            </div>
                        </div>
                    </div>
                    <div class="inline fields">
                        <label>项目状态：</label>
                        <div class="field">
                            <div class="ui radio checkbox">
                                <input type="radio" name="status" value="1">
                                <label>已结清</label>
                            </div>
                        </div>
                        <div class="field">
                            <div class="ui radio checkbox">
                                <input type="radio" name="status" value="0">
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
                    <th>预算内/外</th>
                    <th>已收货</th>
                    <th>未收货</th>
                    <th>已付款</th>
                    <th>应付账款</th>
                    <th>发票条件</th>
                    <th>已收票</th>
                    <th>未收票</th>
                    <th>项目状态</th>
                </tr>
                </thead>
                <tbody>
                @foreach($lists as $list)
                <tr>
                    <td>
                        <a href="javascript:_helper.fullWindow('../buy/budgetary_check.html?id=1');">{{$list->number}}</a>
                    </td>
                    <td>{{$list->supplier}}</td>
                    <td>123,232,231 ￥</td>
                    <td>{{\App\Models\Project::find($list->project_id)->number}}</td>
                    <td class="table-content">{{\App\Models\Project::find($list->project_id)->name}}</td>
                    <td>{{\App\Models\Project::find($list->project_id)->pm}}</td>
                    <td>{{$list->type==1?'内':'外'}}</td>
                    <td>200</td>
                    <td>400</td>
                    <td>5000 ￥</td>
                    <td>5600 ￥</td>
                    <td>条件一</td>
                    <td>2000 ￥</td>
                    <td>2400 ￥</td>
                    <td>未结清</td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>

    </div>
    <!-- /主体内容 === 不可复用 -->
@endsection
@section('pageJs')
    <script src="{{url('js/buy_list.js')}}"></script>
@endsection