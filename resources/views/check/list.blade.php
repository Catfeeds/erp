@extends('layouts.main')
@section('title','已立项清单')
@section('content')
    <!-- 主体内容 === 不可复用 -->
    <div class="index-content print-no-padding">

        <div class="ui breadcrumb">
            <a class="section">验收预收款管理</a>
            <div class="divider"> / </div>
            <div class="active section">验收与收款清单</div>
        </div>
        <!-- 操作区域 -->
        <div class="content-operation flex-row flex-between" style="padding-left: 20%;">
            <form method="get" class="ui form flex-fluid">
                <div class="ui left action right input fluid">
                    <div class="ui button white dropdown ">
                        <input name="seartch-type" type="hidden">
                        <div class="text">请选中搜索内容</div>
                        <i class="dropdown icon"></i>
                        <div class="menu">
                            <div class="item" data-value="1">项目号</div>
                            <div class="item" data-value="2">项目内容</div>
                        </div>
                    </div>
                    <input name="search" type="text" placeholder="搜索内容" value="">
                    <button class="ui button">搜索</button>
                </div>
            </form>
        </div>
        <!-- / 操作区域 -->


        <div class="content-wrap table-head-nowrap">

            <table class="ui center aligned table selectable unstackable">
                <thead>
                <tr>
                    <th>项目号</th>
                    <th>项目内容</th>
                    <th>项目经理</th>
                    <th>合同金额</th>
                    <th>实际金额</th>
                    <th>主合同金额</th>
                    <th>分包合同金额</th>
                    <th>验收日期</th>
                    <th>保修截至日期</th>
                    <th>已开票请款</th>
                    <th>主合同收款</th>
                    <th>分包合同收额</th>
                    <th>应收账款</th>
                    <th>项目剩余未收款</th>
                    <th>履约保证金余额</th>
                </tr>
                </thead>
                <tbody>
                @foreach($projects as $project)
                <tr>
                    <td>
                        <a href="javascript:_helper.fullWindow('{{url('check/detail')}}?id={{$project->id}}');">{{$project->number}}</a>
                    </td>
                    <td title="{{$project->name}}">{{$project->name}}</td>
                    <td>{{$project->pm}}</td>
                    <td>{{number_format($project->price,2)}}</td>
                    <td>{{number_format($project->situation()->sum('price'),2)}}</td>
                    <td>{{number_format($project->situation()->where('type','=',1)->sum('price'),2)}}</td>
                    <td>{{number_format($project->situation()->where('type','=',2)->sum('price'),2)}}</td>
                    <td>{{$project->acceptance_date}}</td>
                    <td>{{$project->deadline}}</td>
                    <td>{{number_format($project->invoices()->sum('price'),2)}}</td>
                    <td>{{number_format($project->collects()->where('type','=',2)->sum('price'),2)}}</td>
                    <td>{{number_format($project->collects()->where('type','=',3)->sum('price'),2)}}</td>
                    <td>{{number_format($project->invoices()->sum('price')-$project->collects()->where('type','=',3)->sum('price')-$project->collects()->where('type','=',2)->sum('price'),2)}}</td>
                    <td>{{number_format($project->situation()->sum('price')-$project->collects()->where('type','=',2)->sum('price')-$project->collects()->where('type','=',3)->sum('price'),2)}}</td>
                    <td>{{number_format($project->bail()->sum('pay_price')-$project->collects()->where('type','=',1)->sum('price'),2)}}</td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        {{$projects->appends(['search'=>$search])->links()}}
    </div>
    <!-- /主体内容 === 不可复用 -->
@endsection
@section('pageJs')
    <script src="{{url('js/check_list.js')}}"></script>
@endsection