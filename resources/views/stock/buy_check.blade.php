@extends('layouts.main')
@section('title','已立项清单')
@section('content')
    <!-- 没有导航的单独窗口页面 -->
    <div class="normal-content print-no-padding">

        <div class="ui breadcrumb">
            <a class="section">库存管理</a>
            <div class="divider"> / </div>
            <a class="section" >采购收购清单</a>
            <div class="divider"> / </div>
            <div class="active section">采购收货查询 - {{$purchase->number}}</div>
        </div>

        <h1 class="ui header center aligned">采购收货查询 - {{$purchase->number}}</h1>
        <div class="flex-row flex-between table-head-nowrap" id="stockBuyCheck">

            <table class="ui celled structured table center aligned unstackable" style="width:65%;">
                <thead>
                <tr>
                    <th>采购编号</th>
                    <th class="fake-td" colspan="3">{{$purchase->number}}</th>
                    <th>采购日期</th>
                    <th class="fake-td" colspan="3">{{$purchase->date}}</th>
                    <th>收货入库记录</th>
                </tr>
                <tr>
                    <th>项目编号</th>
                    <th class="fake-td" colspan="3">{{$purchase->project_id==0?'':\App\Models\Project::find($purchase->project_id)->number}}</th>
                    <th>项目内容</th>
                    <th class="fake-td" colspan="3">{{$purchase->project_id==0?'':\App\Models\Project::find($purchase->project_id)->name}}</th>
                    <th>收货入库编号</th>
                </tr>
                <tr>
                    <th>采购商</th>
                    <th class="fake-td" colspan="7">{{$purchase->supplier}}</th>
                    <th>入库日期</th>
                </tr>
                <tr>
                    <th>项目经理</th>
                    <th class="fake-td" colspan="3">{{$purchase->project_id==0?'':\App\Models\Project::find($purchase->project_id)->pm}}</th>
                    <th>采购金额</th>
                    <th class="fake-td" colspan="3">{{number_format($purchase->lists()->sum('cost'),2)}} ￥</th>
                    <th>收货人</th>
                </tr>
                <tr>
                    <th colspan="9">采购物料清单</th>
                </tr>
                <tr>
                    <th>序号</th>
                    <th>物料名称</th>
                    <th>性能及技术参数</th>
                    <th>品牌型号</th>
                    <th>生产厂家</th>
                    <th>单位</th>
                    <th>单价</th>
                    <th>采购数量</th>
                    <th>采购金额</th>
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
                    <td>{{number_format($lists[$i]->price,2)}} ￥</td>
                    <td>{{$lists[$i]->number}}</td>
                    <td>{{number_format($lists[$i]->cost,2)}} ￥</td>
                </tr>
                @endfor

                </tbody>
                <tfoot>
                <tr>
                    <th colspan="8">合计</th>
                    <th>{{number_format($purchase->lists()->sum('cost'),2)}} ￥</th>
                </tr>
                </tfoot>
            </table>

            <div class="flex-row" style="overflow:auto; flex: 1;">
                <!-- 重复渲染部分 -->
                @for($i=0;$i<count($list2);$i++)
                <div class="scorll-table table-head-nowrap">
                    <table class="ui celled structured table center aligned unstackable">
                        <thead>
                        <tr>
                            <td colspan="4">{{$i+1}}</td>
                        </tr>
                        <tr>
                            <td colspan="4">{{$list2[$i]->number}}</td>
                        </tr>
                        <tr>
                            <td colspan="4">{{$list2[$i]->date}}</td>
                        </tr>
                        <tr>
                            <td colspan="4">{{$list2[$i]->worker}}</td>
                        </tr>
                        <tr>
                            <td colspan="4">{{$list2[$i]->warehouse}}</td>
                        </tr>
                        <tr>
                            <th>收货数量</th>
                            <th>收货金额</th>
                            <th>剩余数量</th>
                            <th>剩余金额</th>
                        </tr>
                        </thead>
                        <tbody>
                        @for($j=0;$j<count($list2[$i]->list);$j++)@if(empty($list2[$i]->list[$j]))
                        <tr>
                            <td colspan="4">暂无数据</td>
                        </tr>
                        @else
                        <tr>
                            <td>{{$list2[$i]->list[$j]['sum']}}</td>
                            <td>{{number_format($list2[$i]->list[$j]['cost'],2)}} ￥</td>
                            <td>{{$list2[$i]->list[$j]['need_sum']}}</td>
                            <td>{{number_format($list2[$i]->list[$j]['need_cost'],2)}} ￥</td>
                        </tr>
                        @endif
                            @endfor
                        </tbody>
                        <tfoot>
                        <tr>
                            <th></th>
                            <th>{{number_format($list2[$i]->lists()->sum('cost'),2)}} ￥</th>
                            <th></th>
                            <th>{{number_format($list2[$i]->lists()->sum('need_cost'),2)}} ￥</th>
                        </tr>
                        <tr>
                            <td colspan="4">
                                <a class="ui mini button primary" href="javascript:_helper.fullWindow('{{url('stock/print/buy')}}?id={{$list2[$i]->id}}');">收货凭证</a>
                            </td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
                @endfor
                <!-- / 重复渲染部分 -->

            </div>
        </div>
        <div class="inline-center margin-top-20">
            <a href="javascript:_helper.fullWindow('{{url('stock/add/buy')}}?id={{$purchase->id}}')" class="ui button primary large">
                <i class="icon hand pointer"></i>
                <span>收货入库</span>
            </a>
        </div>

    </div>
    <!-- /主体内容 === 不可复用 -->
@endsection
@section('pageJs')
{{--    <script src="{{url('js/project_list.js')}}"></script>--}}
@endsection