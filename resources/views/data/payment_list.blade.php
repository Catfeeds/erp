@extends('layouts.main')
@section('title','已立项清单')
@section('content')
    <!-- 主体内容 === 不可复用 -->
    <div class="index-content print-no-padding">

        <div class="ui breadcrumb">
            <a class="section">数据维护</a>
            <div class="divider"> / </div>
            <div class="active section">报销费用类别列表</div>
        </div>

        <!-- 操作区域 -->
        <div class="content-operation">
            <a class="ui primary button" href="javascript:_helper.fullWindow('{{url('category/create')}}')">
                <i class="icon plus"></i>
                <span>新增类别</span>
            </a>
        </div>
        <!-- / 操作区域 -->

        <div class="content-wrap table-head-nowrap">

            <table class="ui center aligned table selectable unstackable">
                <thead>
                <tr>
                    <th>序号</th>
                    <th style="min-width:100px;">费用类型</th>
                    <th style="min-width:300px;">具体事项</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($categories as $category)
                <tr>
                    <td>{{$category->id}}</td>
                    <td>{{$category->title}}</td>
                    @if(!empty($category->kinds))
                    <td style="max-width:600px;">{{implode('/',$category->kinds)}}</td>
                    @else
                        <td style="max-width:600px;"></td>
                    @endif
                    <td style="white-space:nowrap">
                        <a class="ui mini button primary" href="javascript:_helper.fullWindow('{{url('category/create')}}?id={{$category->id}}')">录入事项</a>
                        <button class="ui mini button negative dataPaymentDelete">删除</button>
                    </td>
                </tr>
                @endforeach

                </tbody>
            </table>
        </div>

    </div>
    <!-- /主体内容 === 不可复用 -->
@endsection
@section('pageJs')
    <script src="{{url('js/data_payment_list.js')}}"></script>
@endsection