@extends('layouts.main')
@section('title','已立项清单')
@section('content')
    <!-- 主体内容 === 不可复用 -->
    <div class="index-content print-no-padding">

        <div class="ui breadcrumb">
            <a class="section">采购管理</a>
            <div class="divider"> / </div>
            <div class="active section">采购汇总清单</div>
        </div>

        <!-- 操作区域 -->
        <div class="content-operation flex-row flex-between">
            <div>
                <a class="ui green button" href="{{url('export/purchase/collect')}}?search={{$search}}">
                    <i class="icon download"></i>
                    <span>Excel 导出</span>
                </a>
            </div>
            <form action="" class="ui form flex-fluid">
                {{--<div class="ui left action right input fluid">--}}
                    {{--<div class="ui button white dropdown ">--}}
                        {{--<input name="seartch-type" type="hidden">--}}
                        {{--<div class="text">请选中搜索内容</div>--}}
                        {{--<i class="dropdown icon"></i>--}}
                        {{--<div class="menu">--}}
                            {{--<div class="item" data-value="1">项目编号</div>--}}
                            {{--<div class="item" data-value="2">项目内容</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<input name="value" type="text" placeholder="搜索内容" value="">--}}
                    {{--<button class="ui button">搜索</button>--}}
                {{--</div>--}}
                <div class="ui left action right input fluid" id="ele-part">
                    <!-- <div class="ui button white dropdown ">
                      <div class="text">请选中搜索内容</div>
                      <i class="dropdown icon"></i>
                      <div class="menu">
                        <div class="item" data-value="1">项目编号</div>
                        <div class="item" data-value="2">项目内容</div>
                      </div>
                    </div> -->
                    <el-autocomplete style="width: 70%;" popper-class="my-autocomplete" v-model="search.project_name" :fetch-suggestions="querySearchProjectContent" placeholder="请输入项目内容"
                                     @select="handleSelectProjectContent">
                        <i class="el-icon-edit el-input__icon" slot="suffix">
                        </i>
                        <template slot-scope="props">
                            <div class="name">@{{ props.item.name }}</div>
                            <span class="addr">@{{ props.item.number }}</span>
                        </template>
                    </el-autocomplete>
                    <input name="name" type="hidden" id="nameInput" value="">
                    <input name="number" type="hidden" id="numberInput" value="">
                    <button type="submit" class="ui button">搜索</button>
                </div>
            </form>
        </div>
        <!-- / 操作区域 -->
        <h1 class="ui header center aligned">项目采购物料清单</h1>

        <div class="table-head-nowrap">
            @if(!empty($project))
            {{--@foreach($projects as $project)--}}
            <table class="ui celled structured table center aligned unstackable">
                <thead>
                <tr>
                    <th>项目编号</th>
                    <th class="fake-td">{{$project->number}}</th>
                    <th>项目内容</th>
                    <th class="fake-td" colspan="9">{{$project->name}}</th>
                    <th>项目保修截止日期</th>
                    <th class="fake-td">{{$project->deadline}}</th>
                </tr>
                <tr>
                    <th>序号</th>
                    <th>采购日期</th>
                    <th>采购编号</th>
                    <th>预算内/外</th>
                    <th>供货商</th>
                    <th>物料名称</th>
                    <th>性能及技术</th>
                    <th>品牌型号</th>
                    <th>生产厂家</th>
                    <th>单位</th>
                    <th>单价</th>
                    <th>数量</th>
                    <th>金额</th>
                    <th>保修截止日期</th>
                </tr>
                </thead>
                <tbody>
                @if(!empty($project->purchases))
                @foreach($project->purchases as $purchase)
                    @if(!empty($purchase->lists))
                        {{--{{dd(count($purchase->lists))}}--}}
                        @for($i=0;$i<count($purchase->lists);$i++)
                        {{--@foreach($purchase->lists as $list)--}}
                <tr>
                    <td >{{$i+1}}</td>
                    <td >{{$purchase->date}}</td>
                    <td >{{$purchase->number}}</td>
                    <td >内</td>

                    <td >{{$purchase->supplier}}</td>

                    <td>{{\App\Models\Material::find($purchase->lists[$i]->material_id)->name}}</td>
                    <td>{{\App\Models\Material::find($purchase->lists[$i]->material_id)->param}}</td>
                    <td>{{\App\Models\Material::find($purchase->lists[$i]->material_id)->model}}</td>
                    <td>{{\App\Models\Material::find($purchase->lists[$i]->material_id)->factory}}</td>
                    <td>{{\App\Models\Material::find($purchase->lists[$i]->material_id)->unit}}</td>
                    <td>{{number_format($purchase->lists[$i]->price)}} ￥</td>
                    <td>{{$purchase->lists[$i]->number}}</td>
                    <td>{{number_format($purchase->lists[$i]->cost)}} ￥</td>
                    <td>{{$purchase->lists[$i]->warranty_date}}</td>
                        @endfor
                        @else
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    @endif
                </tr>
                        <tr>
                            <td colspan="12">合计</td>
                            <td>{{number_format($purchase->lists()->sum('cost'))}} ￥</td>
                            <td></td>
                        </tr>
                </tbody>
                {{--<tfoot>--}}

                {{--</tfoot>--}}
                @endforeach

            @else

                @endif

                {{--@endforeach--}}
            </table>
            @else
                <h1 class="ui header center aligned">暂无数据</h1>
            @endif
        </div>

    </div>
    <!-- /主体内容 === 不可复用 -->
@endsection
@section('pageJs')
    <script src="{{url('js/buy_collect.js')}}"></script>
@endsection