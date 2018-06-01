@extends('layouts.main')
@section('title','已立项清单')
@section('content')
    <!-- 主体内容 === 不可复用 -->
    <div class="index-content print-no-padding">

        <div class="ui breadcrumb">
            <a class="section">库存管理</a>
            <div class="divider"> / </div>
            <div class="active section">库存清单</div>
        </div>

        <!-- 操作区域 -->
        <div class="content-operation flex-row flex-between flex-wrap" style="align-items: flex-end;">
            <div>
                <a class="ui green button" href="{{url('export/stock/list')}}">
                    <i class="icon download"></i>
                    <span>Excel 导出</span>
                </a>
            </div>
            <form  class="ui form flex-fluid">
                <div class="ui left action right input fluid">
                    <div class="ui button white dropdown ">
                        <input name="seartch-type" type="hidden">
                        <div class="text">请选中搜索内容</div>
                        <i class="dropdown icon"></i>
                        <div class="menu">
                            <div class="item" data-value="1">物料名称</div>
                            <div class="item" data-value="2">仓库</div>
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
                    <th>序号</th>
                    <th>物料名称</th>
                    <th>性能与技术参数</th>
                    <th>品牌型号</th>
                    <th>生产厂家</th>
                    <th>单位</th>
                    {{--<th>单价</th>--}}
                    <th>库存数量</th>
                    <th>库存金额</th>
                    <th>平均单价</th>
                    <th>仓库</th>
                </tr>
                </thead>
                <tbody>
                @for($i=0;$i<count($stocks);$i++)
{{--                @foreach($stocks as $stock)--}}
                <tr>
                    <td>{{$i+1}}</td>
                    <td>
                        <a href="javascript:_helper.fullWindow('{{url('stock/check')}}?id={{$stocks[$i]->id}}')">{{$stocks[$i]->material()->name}}</a>
                    </td>
                    <td>{{$stocks[$i]->material()->param}}</td>
                    <td>{{$stocks[$i]->material()->model}}</td>
                    <td>{{$stocks[$i]->material()->factory}}</td>
                    <td>{{$stocks[$i]->material()->unit}}</td>
                    <td>{{$stocks[$i]->number}} </td>
                    <td>{{number_format($stocks[$i]->cost,2)}}￥</td>
                    <td>{{$stocks[$i]->number==0?0:number_format($stocks[$i]->cost/$stocks[$i]->number),2}} ￥</td>
                    <td>{{$stocks[$i]->warehouse()->name}}</td>
                </tr>
                {{--@endforeach--}}
                    @endfor
                </tbody>
            </table>
        </div>

    </div>
    {{$stocks->links()}}
    <!-- /主体内容 === 不可复用 -->
@endsection
@section('pageJs')
    <script src="{{url('js/stock_list.js')}}"></script>
@endsection