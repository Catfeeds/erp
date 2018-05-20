@extends('layouts.main_no_nav')
@section('title','已立项清单')
@section('content')
    <!-- 没有导航的单独窗口页面 -->
    <div class="normal-content print-no-padding">

        <div class="ui breadcrumb print-hide">
            <a class="section">预算管理</a>
            <div class="divider"> / </div>
            <a class="section" href="../budget/list.html">预算清单</a>
            <div class="divider"> / </div>
            <div class="active section">预算清单 - 项目号 {{$project->number}}</div>
        </div>

        <div id="budgetPrint">

            <h1 class="ui header blue center aligned print-hide">预算清单 - 项目号 {{$project->number}}</h1>
            <table class="ui celled structured table center aligned">
                <thead>
                <tr>
                    <th>项目编号</th>
                    <th class="fake-td">{{$project->number}}</th>
                    <th>项目内容</th>
                    <th class="fake-td" colspan="7">{{$project->name}}</th>
                </tr>
                <tr>
                    <th>序号</th>
                    <th>物料名称</th>
                    <th>性能及技术参数</th>
                    <th>品牌型号</th>
                    <th>生产厂家</th>
                    <th>单位</th>
                    <th>单价</th>
                    <th>数量</th>
                    <th>金额</th>
                    <th>物料/工程/其他</th>
                </tr>
                </thead>
                <tbody>
                @for($i=0;$i<count($budgets);$i++)
                <tr>
                    <td>{{$i+1}}</td>
                    <td>{{$budgets[$i]->name}}</td>
                    <td>{{$budgets[$i]->param}}</td>
                    <td>{{$budgets[$i]->model}}</td>
                    <td>{{$budgets[$i]->factory}}</td>
                    <td>{{$budgets[$i]->unit}}</td>
                    <td>{{$budgets[$i]->price}}</td>
                    <td>{{$budgets[$i]->number}}</td>
                    <td>{{$budgets[$i]->cost}}</td>
                    @if($budgets[$i]->type==1)
                    <td>物料</td>
                        @elseif($budgets[$i]->type==2)
                        <td>工程</td>
                    @else
                        <td>其他</td>
                    @endif
                </tr>
                @endfor
                </tbody>
                <tfoot>
                <tr>
                    <th colspan="4" rowspan="3" style="font-weight:600;">预算总额</th>
                    <th colspan="2" rowspan="3">{{$project->budget()->sum('cost')}} 元</th>
                    <th colspan="2">物料采购金额</th>
                    <th colspan="2">{{$project->budget()->where('type','=',1)->sum('cost')}} 元</th>
                </tr>
                <tr>
                    <th colspan="2">工程采购金额</th>
                    <th colspan="2">{{$project->budget()->where('type','=',2)->sum('cost')}} 元</th>
                </tr>
                <tr>
                    <th colspan="2">其他</th>
                    <th colspan="2">{{$project->budget()->where('type','=',3)->sum('cost')}} 元</th>
                </tr>
                </tfoot>
            </table>
            <div class="content-operation print-hide">
                <div class="flex-row flex-end">
                    <a class="ui icon button positive" href="{{url('export/budget')}}?id={{$project->id}}" style="margin: 0 20px;">
                        <i class="icon download"></i>
                        <span>导出 EXCEL 表</span>
                    </a>
                    <a class="ui icon button primary" href="javascript:window.print();" style="margin: 0 20px;">
                        <i class="icon print"></i>
                        <span>打印</span>
                    </a>
                </div>
            </div>
        </div>

    </div>
    <!-- /主体内容 === 不可复用 -->
@endsection
@section('pageJs')
{{--    <script src="{{url('js/project_list.js')}}"></script>--}}
@endsection