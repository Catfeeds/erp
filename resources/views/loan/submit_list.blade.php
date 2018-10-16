@extends('layouts.main')
@section('title','报销申请清单')
@section('content')
    <!-- 主体内容 === 不可复用 -->
    <div class="index-content print-no-padding">

        <div class="ui breadcrumb">
            <a class="section">报销与借款管理</a>
            <div class="divider"> / </div>
            <div class="active section">报销申请清单</div>
        </div>

        <!-- 操作区域 -->
        <div class="content-operation">

            <form action="" class="ui form">
                <div class="flex-row" style="justify-content: flex-end;">
                    <div class="inline fields" style="margin-right:50px;">
                        <label>付款状态：</label>
                        <div class="field">
                            <div class="ui radio checkbox">
                                <input type="radio" name="pay" value="1">
                                <label>已付款</label>
                            </div>
                        </div>
                        <div class="field">
                            <div class="ui radio checkbox">
                                <input type="radio" name="pay" value="2">
                                <label>未付款</label>
                            </div>
                        </div>
                    </div>
                    {{--<div class="inline fields">--}}
                        {{--<label>报销类型：</label>--}}
                        {{--<div class="field">--}}
                            {{--<div class="ui radio checkbox">--}}
                                {{--<input type="radio" name="system" value="1">--}}
                                {{--<label>期间费用报销</label>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="field">--}}
                            {{--<div class="ui radio checkbox">--}}
                                {{--<input type="radio" name="system" value="0">--}}
                                {{--<label>项目成本报销</label>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                </div>
                <div class="flex-row flex-between flex-wrap">
                    <div>
                        <a class="ui primary button" href="javascript:_helper.fullWindow('{{url('loan/submit/other')}}')">
                            <i class="icon plus"></i>
                            <span>期间费用报销</span>
                        </a>
                        <a class="ui primary button" href="javascript:_helper.fullWindow('{{url('loan/submit/project')}}')">
                            <i class="icon plus"></i>
                            <span>项目成本报销</span>
                        </a>
                        <a class="ui green button" href="{{url('export/loan/submit')}}">
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
                                <div class="item" data-value="1">报销编号</div>
                                <div class="item" data-value="2">项目编号</div>
                                <div class="item" data-value="3">项目内容</div>
                                <div class="item" data-value="4">报销人</div>
                            </div>
                        </div>
                        <input name="search" type="text" placeholder="搜索内容" value="">
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
                    <th>报销编号</th>
                    <th>类型</th>
                    <th>金额</th>
                    {{--<th>其中：材料款</th>--}}
                    {{--<th>其中：工程款</th>--}}
                    {{--<th>其中：其他</th>--}}
                    <th>项目编号</th>
                    <th>项目内容</th>
                    <th>报销人</th>
                    <th>复核人</th>
                    <th>审批人</th>
                    <th>付款状态</th>
                    <th>付款编号</th>
                </tr>
                </thead>
                <tbody>
                @foreach($lists as $list)
                <tr>
                    <td>
                        <a href="javascript:_helper.fullWindow('{{url('loan/submit/single')}}?id={{$list->id}}')">{{$list->number}}</a>
                    </td>
                    @if($list->type==1)
                    <td>期间报销</td>
                    @else
                        <td>项目报销</td>
                    @endif
                    <td>{{number_format($list->price,2)}}</td>
                    <td>
                        @if($list->project_id!=0)
                            {{\App\Models\Project::find($list->project_id)->number}}
                            @else
                        @endif
                    </td>
                    <td title="{{$list->project_id==0?'':\App\Models\Project::find($list->project_id)->name}}">
                        @if($list->project_id!=0)
                            {{\App\Models\Project::find($list->project_id)->name}}
                        @else
                        @endif
                    </td>
                    <td>{{$list->loan_user}}</td>
                    @if($list->state>=2)
                    <td>{{$list->checker}}</td>
                    @else
                        <td>待复核</td>
                    @endif
                    @if($list->state>=2)
                        <td>{{$list->passer}}</td>
                    @else
                        <td>待审核</td>
                    @endif
                    <td>{{$list->state!=4?'未付款':'已付款'}}</td>
                    <td>{{$list->FKNumber}}</td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        {{$lists->appends(['search'=>$search,'search-type'=>$type,'pay'=>$pay])->links()}}
    </div>
    <!-- /主体内容 === 不可复用 -->

@endsection
@section('pageJs')
    <script src="{{url('js/loan_submit_list.js')}}"></script>
@endsection