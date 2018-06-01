@extends('layouts.main')
@section('title','已立项清单')
@section('content')
    <!-- 主体内容 === 不可复用 -->
    <div class="index-content print-no-padding">

        <div class="ui breadcrumb">
            <a class="section">施工管理</a>
            <div class="divider"> / </div>
            <div class="active section">施工费清单</div>
        </div>

        <!-- 操作区域 -->
        <div class="content-operation">

            <form action="" class="ui form">
                {{--<div class="inline fields" style="justify-content:flex-end;">--}}
                    {{--<label>系统状态：</label>--}}
                    {{--<div class="field">--}}
                        {{--<div class="ui radio checkbox">--}}
                            {{--<input type="radio" name="system" value="1">--}}
                            {{--<label>已结清</label>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="field">--}}
                        {{--<div class="ui radio checkbox">--}}
                            {{--<input type="radio" name="system" value="0">--}}
                            {{--<label>未结清</label>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
                <div class="flex-row flex-between flex-wrap">
                    <div>
                        <a class="ui green button" href="{{url('export/build/list')}}">
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
                                <div class="item" data-value="2">施工队</div>
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
                    <th>施工队</th>
                    <th>施工经理</th>
                    <th>项目编号</th>
                    <th>项目内容</th>
                    <th>项目经理</th>
                    <th>已完工请款</th>
                    <th>已付款</th>
                    <th>应付账款</th>
                    <th>已收票</th>
                    <th>未收票</th>
                    <th>系统状态</th>
                </tr>
                </thead>
                <tbody>
                @foreach($lists as $list)
                <tr>
                    <td>{{$list->team}}</td>
                    <td>{{$list->manager}}</td>
                    <td>{{$list->project_number}}</td>
                    <td>{{$list->project_content}}</td>
                    <td>{{$list->project_manager}}</td>
                    <td>{{number_format($list->payments()->where('state','>=',3)->sum('price'),2)}} ￥</td>
                    <td>{{number_format($list->applies()->where('state','=',4)->sum('apply_price'),2)}} ￥</td>
                    <td>{{number_format($list->payments()->where('state','=',3)->sum('price')-$list->applies()->where('state','=',4)->sum('apply_price'),2)}} ￥</td>
                    <td>{{number_format($list->invoices()->sum('with_tax'),2)}} ￥</td>
                    <td>{{number_format($list->payments()->where('state','>=',3)->sum('price')-$list->invoices()->sum('with_tax'),2)}} ￥</td>
                    <td>{{$list->payments()->where('state','=',3)->sum('price')-$list->applies()->where('state','=',4)->sum('apply_price')!=0?'未结清':'已结清'}}</td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>

    </div>
    <!-- /主体内容 === 不可复用 -->
@endsection
@section('pageJs')
    <script src="{{url('js/build_list.js')}}"></script>
@endsection