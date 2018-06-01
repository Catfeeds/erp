@extends('layouts.main_no_nav')
@section('title','已立项清单')
@section('content')
    <!-- 没有导航的单独窗口页面 -->
    <div class="normal-content print-no-padding">

        <div class="ui breadcrumb">
            <a class="section">库存管理</a>
            <div class="divider"> / </div>
            <a class="section" href="../stock/list.html">库存清单</a>
            <div class="divider"> / </div>
            <div class="active section">查询出入库记录</div>
        </div>


        <!-- 操作 -->
        <h4 class="ui dividing header blue">选择时间段</h4>
        <div class="content-operation invisible stockCheck" id="stockCheck">
            <form action="">
                <div class="ui form">
                    <div class="ui three column doubling stackable grid">
                        <div class="column">
                            <div class="inline fields">
                                <label class="six wide field flex-center">物料名称</label>
                                <div class="ten wide field">
                                    <div class="fake-input">{{$stock->material->name}}</div>
                                </div>
                            </div>
                        </div>
                        <div class="column">
                            <div class="inline fields">
                                <label class="six wide field flex-center">性能与技术参数</label>
                                <div class="ten wide field">
                                    <div class="fake-input">{{$stock->material->param}}</div>
                                </div>
                            </div>
                        </div>
                        <div class="column">
                            <div class="inline fields">
                                <label class="six wide field flex-center">生产厂家</label>
                                <div class="ten wide field">
                                    <div class="fake-input">{{$stock->material->factory}}</div>
                                </div>
                            </div>
                        </div>
                        <div class="column">
                            <div class="inline fields">
                                <label class="six wide field flex-center">品牌型号</label>
                                <div class="ten wide field">
                                    <div class="fake-input">{{$stock->material->model}}</div>
                                </div>
                            </div>
                        </div>
                        <div class="column">
                            <div class="inline fields">
                                <label class="six wide field flex-center">单位</label>
                                <div class="ten wide field">
                                    <div class="fake-input">{{$stock->material->unit}}</div>
                                </div>
                            </div>
                        </div>
                        <div class="column">
                            <div class="inline fields">
                                <label class="six wide field flex-center">仓库</label>
                                <div class="ten wide field">
                                    <div class="fake-input">{{$stock->warehouse->name}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="margin-top-20 flex-row flex-between">
                    <div>
                        <a class="ui green button" href="#">
                            <i class="icon download"></i>
                            <span>Excel 导出</span>
                        </a>
                    </div>
                    <div>
                        <input type="hidden" value="{{$stock->id}}" name="id">
                        <el-date-picker v-model="date" name="search-date" type="datetimerange" :picker-options="dateOption" range-separator="至" start-placeholder="开始日期"
                                        end-placeholder="结束日期" align="right" format="yyyy-MM-dd">
                        </el-date-picker>
                        <button class="ui icon button primary" type="submit">
                            <i class="icon search"></i>
                            <span>查询</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <!-- / 操作 -->

        <h1 class="ui header center aligned">出入库记录</h1>
        <div class="stockCheck ui form">
            <div class="ui three column doubling stackable grid">
                <div class="column">
                    <div class="inline fields">
                        <label class="four wide field flex-center">物料名称</label>
                        <div class="twelve wide field">
                            <div class="fake-input">{{$stock->material->name}}</div>
                        </div>
                    </div>
                </div>
                <div class="column">
                    <div class="inline fields">
                        <label class="four wide field flex-center">性能与技术参数</label>
                        <div class="twelve wide field">
                            <div class="fake-input">{{$stock->material->param}}</div>
                        </div>
                    </div>
                </div>
                <div class="column">
                    <div class="inline fields">
                        <label class="four wide field flex-center">品牌型号</label>
                        <div class="twelve wide field">
                            <div class="fake-input">{{$stock->material->model}}</div>
                        </div>
                    </div>
                </div>
                <div class="column">
                    <div class="inline fields">
                        <label class="four wide field flex-center">生产厂家</label>
                        <div class="twelve wide field">
                            <div class="fake-input">{{$stock->material->factory}}</div>
                        </div>
                    </div>
                </div>
                <div class="column">
                    <div class="inline fields">
                        <label class="four wide field flex-center">单位</label>
                        <div class="twelve wide field">
                            <div class="fake-input">{{$stock->material->unit}}</div>
                        </div>
                    </div>
                </div>
                <div class="column">
                    <div class="inline fields">
                        <label class="four wide field flex-center">仓库</label>
                        <div class="twelve wide field">
                            <div class="fake-input">{{$stock->warehouse->name}}</div>
                        </div>
                    </div>
                </div>
                <div class="column wide">
                    <div class="inline fields">
                        <label class="four wide field flex-center">时间段</label>
                        <div class="twelve wide field">
                            <div class="fake-input">{{$start}}
                                <b style="padding: 0 40px;">至</b> {{$end}}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{--<h3 class="ui header center aligned">暂无数据</h3>--}}
        <div class="stockCheck table-head-nowrap">

            <table class="ui celled structured table center aligned">
                <thead>
                <tr>
                    <th rowspan="2">日期</th>
                    <th colspan="6">入库</th>
                    <th colspan="7">出库</th>
                    <th colspan="3">库存</th>
                </tr>
                <tr>
                    <th>数量</th>
                    <th>单价</th>
                    <th>金额</th>
                    <th>供货商</th>
                    <th>收货/退料编号</th>
                    <th>收货人</th>
                    <th>数量</th>
                    <th>单价</th>
                    <th>金额</th>
                    <th>项目号</th>
                    <th>项目内容</th>
                    <th>领料/退货出库编号</th>
                    <th>领料人</th>
                    <th>数量</th>
                    <th>金额</th>
                    <th>平均单价</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>期初</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>{{empty($startData['stock_number'])?0:$startData['stock_number']}}</td>
                    <td>{{empty($startData['stock_cost'])?0:number_format($startData['stock_cost'],2)}}</td>
                    <td>{{empty($startData['stock_price'])?0:number_format($startData['stock_price'],2)}}</td>
                </tr>
                @foreach($lists as $list)
                <tr>
                    <td>{{$list->record->date}}</td>
                    @if($list->record->type==1||$list->record->type==2)
                    <td>{{$list->sum}}</td>
                    <td>{{number_format($list->price,2)}}￥</td>
                    <td>{{number_format($list->cost,2)}}￥</td>
                    <td>{{$list->record->supplier}}</td>
                    <td>{{$list->record->number}}</td>
                    @else
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    @endif
                    <td>{{$list->record->worker}}</td>
                    @if($list->record->type==1||$list->record->type==2)
                    <td></td>
                    <td></td>
                    <td></td>
                    @else
                        <td>{{$list->sum}}</td>
                        <td>{{number_format($list->price,2)}}￥</td>
                        <td>{{number_format($list->cost,2)}}￥</td>
                    @endif
                    <td>{{$list->record->project_number}}</td>
                    <td class="table-content">{{$list->record->project_content}}</td>
                    @if($list->record->type==1||$list->record->type==2)
                        <td></td>
                    @else
                        <td>{{$list->record->number}}</td>
                        @endif

                    <td>{{$list->record->returnee}}</td>
                    <td>{{$list->stock_number}}</td>
                    <td>{{number_format($list->stock_cost,2)}}￥</td>
                    <td>{{number_format($list->stock_price,2)}}￥</td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>

    </div>
    <!-- /主体内容 === 不可复用 -->
@endsection
@section('pageJs')
    <script src="{{url('js/stock_check.js')}}"></script>
@endsection