@extends('layouts.main')
@section('title','已立项清单')
@section('content')
    <!-- 主体内容 === 不可复用 -->
    <div class="index-content print-no-padding">

        <div class="ui breadcrumb">
            <a class="section">施工管理</a>
            <div class="divider"> / </div>
            <div class="active section">完工请款清单</div>
        </div>

        <!-- 操作区域 -->
        <div class="content-operation">

            <form action="" class="ui form">
                <div class="flex-row flex-between flex-wrap">
                    <div>
                        <a class="ui primary button" href="javascript:_helper.fullWindow('{{url('build/finish/create')}}')">
                            <i class="icon plus"></i>
                            <span>新增请款</span>
                        </a>
                        <a class="ui green button" href="{{url('export/build/finish/list')}}">
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
                                <div class="item" data-value="1">施工队</div>
                                <div class="item" data-value="2">施工经理</div>
                                <div class="item" data-value="3">项目编号</div>
                                <div class="item" data-value="4">项目内容</div>
                                <div class="item" data-value="5">项目经理</div>
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
                    <th>请款编号</th>
                    <th>施工队</th>
                    <th>施工经理</th>
                    <th>项目编号</th>
                    <th>项目内容</th>
                    <th>项目经理</th>
                    <th>请款金额</th>
                    <th>经办人</th>
                    <th>复核人</th>
                    <th>审核人</th>
                </tr>
                </thead>
                <tbody>
                @foreach($applies as $apply)
                <tr>
                    <td>
                        <a href="javascript:_helper.fullWindow('{{url('build/finish/single')}}?id={{$apply->id}}')">{{$apply->number}}</a>
                    </td>
                    <td>{{$apply->team}}</td>
                    <td>{{$apply->manager}}</td>
                    <td>{{$apply->project_number}}</td>
                    <td class="table-content">{{$apply->project_content}}</td>
                    <td>{{$apply->project_manager}}</td>
                    <td>{{$apply->price}} ￥</td>
                    <td>{{$apply->applier}}</td>
                    @if($apply->state<2)
                    <td>未复核</td>
                    @else
                        <td>{{$apply->checker}}</td>
                    @endif
                    @if($apply->state<3)
                    <td>未审批</td>
                        @else
                    <td>{{$apply->passer}}</td>
                        @endif
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="margin-top-20" style="text-align:right;">
            <a class="ui positive button" href="#">
                <i class="icon download"></i>
                <span>请款单标准格式导出</span>
            </a>
        </div>
    </div>
    <!-- /主体内容 === 不可复用 -->
@endsection
@section('pageJs')
    <script src="{{url('js/build_finish_list.js')}}"></script>
@endsection