@extends('layouts.main_no_nav')
@section('title','已立项清单')
@section('content')
    <!-- 没有导航的单独窗口页面 -->
    <div class="normal-content print-no-padding">

        <div class="ui breadcrumb print-hide">
            <a class="section">库存管理</a>
            <div class="divider"> / </div>
            <a class="section" href="../pay/list.html">退货出库清单</a>
            <div class="divider"> / </div>
            <div class="active section">退货出库查询 - {{$record->number}}</div>
        </div>

        <h3 class="ui header center aligned">退货出库清单</h3>
        <div class="flex-row flex-end">
            <p class="print-title">
                <b>退货出库编号：</b>{{$record->number}}</p>
        </div>
        <div class="flex-row flex-end">
            <p class="print-title">
                <b>入库日期：</b>{{$record->date}}</p>
            <p class="print-title">
                <b>入库仓库：</b>{{$record->warehouse}}</p>
        </div>
        <table class="ui celled center aligned table unstackable">
            <thead>
            <tr>
                <th>采购编号</th>
                <th class="fake-td">{{$purchase->number}}</th>
                <th>采购日期</th>
                <th class="fake-td">{{$purchase->date}}</th>
                <th>采购金额</th>
                <th class="fake-td">{{$purchase->lists()->sum('cost')}}￥</th>
                <th>项目编号</th>
                <th class="fake-td">{{$record->project_number}}</th>
                <th>项目内容</th>
                <th class="fake-td" colspan="2">{{$record->project_content}}</th>
                <th>项目经理</th>
                <th class="fake-td">{{$record->project_manager}}</th>
            </tr>
            <tr>
                <th>供货商名称</th>
                <th colspan="7" class="fake-td">{{$record->supplier}}</th>
                <th>退货原因</th>
                <th colspan="4" class="fake-td">{{$record->reason}}</th>
            </tr>
            <tr>
                <th colspan="9">采购物料清单</th>
                <th colspan="2">已收货情况</th>
                <th colspan="2">本次退货情况</th>
            </tr>
            <tr>
                <th></th>
                <th>物料名称</th>
                <th>性能及技术参数</th>
                <th>品牌型号</th>
                <th>生产厂家</th>
                <th>单位</th>
                <th>单价</th>
                <th>采购数量</th>
                <th>采购金额</th>
                <th>已收货数量</th>
                <th>已收货金额</th>
                <th>本次退货数量</th>
                <th>本次退货金额</th>
            </tr>
            </thead>
            <tbody>
            @for($i=0;$i<count($lists);$i++)
            <tr>
                <td>1</td>
                <td>线缆</td>
                <td>这是性能参数</td>
                <td>ak232</td>
                <td>xxx厂家</td>
                <td>个</td>
                <td>125￥</td>
                <td>21,523</td>
                <td>12,352￥</td>
                <td>125</td>
                <td>52,123￥</td>
                <td>510</td>
                <td>523,523￥</td>
            </tr>
            @endfor
            </tbody>
            <tfoot>
            <tr>
                <th colspan="7">合计</th>
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
    <script src="{{url('js/project_list.js')}}"></script>
@endsection