@extends('layouts.main_no_nav')
@section('title','已立项清单')
@section('content')
    <!-- 没有导航的单独窗口页面 -->
    <div class="normal-content print-no-padding">

        <div class="ui breadcrumb print-hide">
            <a class="section">库存管理</a>
            <div class="divider"> / </div>
            <a class="section" href="../stock/buy_list.html">采购收购清单</a>
            <div class="divider"> / </div>
            <a class="section" href="../stock/buy_check.html?id=CG1231532311">采购收货查询 - {{$record->purchase_number}}</a>
            <div class="divider"> / </div>
            <div class="active section">收货凭证 - {{$record->number}}</div>
        </div>

        <h1 class="ui header center aligned">采购收货入库清单</h1>
        <div class="flex-row flex-end">
            <p class="print-title">
                <b>收货入库编号：</b>{{$record->number}}</p>
        </div>
        <div class="flex-row flex-end">
            <p class="print-title">
                <b>入库日期：</b>{{$record->date}}</p>
            <p class="print-title">
                <b>入库仓库：</b>{{$record->warehouse}}</p>
        </div>
        <table class="ui celled center aligned table selectable">
            <thead>
            <tr>
                <th>采购编号</th>
                <th class="fake-td">{{$record->purchase_number}}</th>
                <th>采购日期</th>
                <th class="fake-td" colspan="2">{{$purchase->date}}</th>
                <th>采购金额</th>
                <th class="fake-td">{{number_format($purchase->lists()->sum('cost'),2)}} ￥</th>
                <th>项目编号</th>
                <th class="fake-td">{{$record->project_number}}</th>
                <th>项目内容</th>
                <th class="fake-td" colspan="3">{{$record->project_content}}</th>
                <th>项目经理</th>
                <th class="fake-td">{{$record->project_manager}}</th>
            </tr>
            <tr>
                <th>供货商名称</th>
                <th class="fake-td" colspan="8">{{$record->supplier}}</th>
                <th>收货人</th>
                <th class="fake-td" colspan="5">{{$record->worker}}</th>
            </tr>
            <tr>
                <th colspan="9">采购物料清单</th>
                <th colspan="2">以前收货情况</th>
                <th colspan="2">本次收货情况</th>
                <th colspan="2">未收货情况</th>
            </tr>
            <tr>
                <th class="fake-td"></th>
                <th class="bg-white">物料名称</th>
                <th class="bg-white">性能及技术参数</th>
                <th class="bg-white">品牌型号</th>
                <th class="bg-white">生产厂家</th>
                <th class="bg-white">单位</th>
                <th class="bg-white">单价</th>
                <th class="bg-white">采购数量</th>
                <th class="bg-white">采购金额</th>
                <th class="bg-white">已收货数量</th>
                <th class="bg-white">已收货金额</th>
                <th class="bg-white">本次收货数量</th>
                <th class="bg-white">本次收货金额</th>
                <th class="bg-white">剩余未收货数量</th>
                <th class="bg-white">剩余未收货金额</th>
            </tr>
            </thead>
            <tbody>
            @for($i=0;$i<count($lists);$i++)
            <tr>
                <td>{{$i+1}}</td>
                <td>{{\App\Models\Material::find($lists[$i]->material_id)->name}}</td>
                <td>{{\App\Models\Material::find($lists[$i]->material_id)->param}}</td>
                <td>{{\App\Models\Material::find($lists[$i]->material_id)->model}}</td>
                <td>{{\App\Models\Material::find($lists[$i]->material_id)->factory}}</td>
                <td>{{\App\Models\Material::find($lists[$i]->material_id)->unit}}</td>
                <td>{{number_format($lists[$i]->price,2)}} ￥</td>
                <td>{{\App\Models\PurchaseList::where('purchase_id','=',$record->purchase_id)->where('material_id','=',$lists[$i]->material_id)->sum('number')}}</td>
                <td>{{number_format(\App\Models\PurchaseList::where('purchase_id','=',$record->purchase_id)->where('material_id','=',$lists[$i]->material_id)->sum('cost'),2)}}￥</td>
                <td>{{$purchase->lists()->sum('received')}}</td>
                <td>{{number_format($purchase->lists()->sum('received')*$purchase->lists()->pluck('price')->first(),2)}}￥</td>
                <td>{{$lists[$i]->sum}}</td>
                <td>{{number_format($lists[$i]->cost,2)}}￥</td>
                <td>{{$lists[$i]->need_sum}}</td>
                <td>{{number_format($lists[$i]->need_cost,2)}} ￥</td>
            </tr>
            @endfor

            </tbody>
            <tfoot>
            <tr>
                <th colspan="8">合计</th>
                <th>{{number_format($purchase->lists()->sum('cost'))}} ￥</th>
                <th>0</th>
                <th>0</th>
                <th>0</th>
                <th>0</th>
                <th>0</th>
                <th>0</th>
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