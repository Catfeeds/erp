@extends('layouts.main')
@section('title','已立项清单')
@section('content')
    <!-- 没有导航的单独窗口页面 -->
    <div class="normal-content print-no-padding">

        <div class="ui breadcrumb print-hide">
            <a class="section">库存管理</a>
            <div class="divider"> / </div>
            <a class="section" href="../stock/get_list.html">领料出库清单</a>
            <div class="divider"> / </div>
            <div class="active section">领料查询 - {{$record->number}}</div>
        </div>

        <h1 class="ui header center aligned">领料出库清单</h1>
        <table class="ui celled center aligned table selectable">
            <thead>
            <tr>
                <th colspan="2">领料日期</th>
                <th class="fake-td" colspan="2">{{$record->date}}</th>
                <th colspan="2">领料编号</th>
                <th class="fake-td" colspan="2">{{$record->number}}</th>
            </tr>
            <tr>
                <th colspan="2">领料项目编号</th>
                <th class="fake-td" colspan="2">{{$record->project_number}}</th>
                <th colspan="2">领料项目内容</th>
                <th class="fake-td" colspan="3">{{$record->project_content}}</th>
            </tr>
            <tr>
                <th colspan="2">领料人</th>
                <th class="fake-td" colspan="2">{{$record->worker}}</th>
                <th colspan="2">出货仓库</th>
                <th class="fake-td" colspan="3">{{$record->warehouse}}</th>
            </tr>
            <tr>
                <th></th>
                <th>物料名称</th>
                <th>性能技术参数</th>
                <th>品牌型号</th>
                <th>生产厂家</th>
                <th>单位</th>
                <th>库存均价</th>
                <th>领料数量</th>
                <th>领料金额</th>
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
                <td>￥{{number_format($lists[$i]->price,2)}} </td>
                <td>{{$lists[$i]->sum}}</td>
                <td>￥{{number_format($lists[$i]->cost,2)}}</td>
            </tr>
            @endfor
            </tbody>
            <tfoot>
            <tr>
                <th colspan="8">合计</th>
                <th>￥{{number_format($record->lists()->sum('cost'),2)}} </th>
            </tr>
            </tfoot>
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