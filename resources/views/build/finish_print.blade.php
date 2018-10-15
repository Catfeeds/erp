@extends('layouts.main_no_nav')
@section('title','完工请款记帐凭证')
@section('content')
    <!-- 没有导航的单独窗口页面 -->
    <div class="normal-content print-no-padding">

        <div class="ui breadcrumb print-hide">
            <a class="section">库存管理</a>
            <div class="divider"> / </div>
            <a class="section" href="{{url('build/finish/list')}}" >完工请款清单</a>
            <div class="divider"> / </div>
            <a class="section" href="{{url('build/finish/single?id=')}}{{$apply->id}}">请款查询 - {{$apply->number}}</a>
            <div class="divider"> / </div>
            <div class="active section">查看凭证</div>
        </div>

        <h1 class="ui header center aligned">完工请款记帐凭证</h1>
        <p style="text-align:right;font-size: 13px;padding-right:20px;">
            {{--<b>记账凭证号：</b>12312312312232</p>--}}
        <table class="ui celled center aligned table selectable">
            <thead>
            <tr>
                <th>请款日期</th>
                <th class="fake-td">2018-01-02</th>
                <th>请款编号</th>
                <th class="fake-td"> {{$apply->number}}</th>
                <th>请款金额</th>
                <th class="fake-td" colspan="3">￥{{number_format($apply->price,2)}} </th>
            </tr>
            <tr>
                <th>施工队</th>
                <th class="fake-td">{{$apply->team}}</th>
                <th>项目编号</th>
                <th class="fake-td">{{$apply->project_number}}</th>
                <th>项目内容</th>
                <th class="fake-td" colspan="3">{{$apply->project_content}}</th>
            </tr>
            <tr>
                <th>施工经理</th>
                <th class="fake-td" colspan="3">{{$apply->manager}}</th>
                <th>项目经理</th>
                <th class="fake-td" colspan="3">{{$apply->project_manager}}</th>
            </tr>
            <tr>
                <th>序号</th>
                <th>设备名称</th>
                <th>性能参数</th>
                <th>数量</th>
                <th>单位</th>
                <th>含税单价</th>
                <th>含税总价</th>
                <th>备注</th>
            </tr>
            </thead>
            <tbody>
            @for($i=0;$i<count($lists);$i++)
            <tr>
                <td>{{$i}}</td>
                <td>{{$lists[$i]->name}}</td>
                <td>{{$lists[$i]->param}}</td>
                <td>{{$lists[$i]->number}}</td>
                <td>{{$lists[$i]->unit}}</td>
                <td>￥{{number_format($lists[$i]->price,2)}} </td>
                <td>￥{{number_format($lists[$i]->total,2)}} </td>
                <td style="max-width:400px">{{$lists[$i]->remark}}</td>
            </tr>
            @endfor
            </tbody>
            <tfoot>
            <tr>
                <th colspan="6">合计</th>
                <th>￥{{number_format($apply->lists()->sum('total'),2)}} </th>
                <th></th>
            </tr>
            </tfoot>
        </table>

        <div class="flex-row flex-center margin-top-50">
            <div style="margin: 0 50px;">
                <b style="margin-right:20px;">经办人</b>{{$apply->applier}}</div>
            <div style="margin: 0 50px;">
                <b style="margin-right:20px;">复核人</b>{{$apply->checker}}</div>
            <div style="margin: 0 50px;">
                <b style="margin-right:20px;">审批人</b>{{$apply->passer}}</div>
        </div>

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