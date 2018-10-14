@extends('layouts.main')
@section('title','查看预算 - 项目号 '.$project->number)
@section('content')
    <!-- 没有导航的单独窗口页面 -->
    <div class="normal-content print-no-padding">

        <div class="ui breadcrumb">
            <a class="section">预算管理</a>
            <div class="divider"> / </div>
            <a class="section" href="{{url('budget/list')}}" >预算清单</a>
            <div class="divider"> / </div>
            <div class="active section">查看预算 - 项目号 {{$project->number}}</div>
        </div>

        <h1 class="inline-center">项目编号 - {{$project->number}}</h1>
        <div class="margin-top-20" id="projectCheck">
            <!-- 基本信息 -->
            <h4 class="ui dividing header blue">基本信息</h4>

            <div class="ui form form-item">
                <div class="ui three column doubling stackable grid">
                    <div class="column">
                        <div class="inline fields">
                            <label class="four wide field">立项日期</label>
                            <div class="twelve wide field">
                                <div class="fake-input">{{date('Y-m-d',$project->createTime)}}</div>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="four wide field">甲方</label>
                            <div class="twelve wide field">
                                <div class="fake-input">{{$project->PartyA}}</div>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="four wide field">项目合同金额</label>
                            <div class="twelve wide field icon input">
                                <div class="fake-input">￥{{number_format($project->price,2)}}</div>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="four wide field">预计完工日期</label>
                            <div class="twelve wide field">
                                <div class="fake-input">{{date('Y-m-d',$project->finishTime)}}</div>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="four wide field">项目经理</label>
                            <div class="twelve wide field">
                                <div class="fake-input">{{$project->pm}}</div>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="four wide field">维护要求</label>
                            <div class="twelve wide field">
                                <div class="fake-input">{{$project->condition}}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /基本信息 -->

            <!-- 主合同中标情况 -->
            <h4 class="ui dividing header blue margin-top-50">主合同中标情况</h4>
            <div class="ui form form-item">
                <div class="ui five column doubling stackable grid">
                    <div class="two wide column form-thead">序号</div>
                    <div class="four wide column form-thead">单位名称</div>
                    <div class="four wide column form-thead">金额</div>
                    <div class="six wide column form-thead">备注</div>
                </div>
                <div class="form-wrap special-form">
                    @for($i=0;$i<count($mainContracts);$i++)
                    {{--@foreach($mainContracts as $mainContract)--}}
                    <div class="ui three column doubling stackable grid center aligned">
                        <div class="two wide column">
                            <div class="fake-input">{{$i+1}}</div>
                        </div>
                        <div class="four wide column">
                            <div class="fake-input">{{$mainContracts[$i]->unit}}</div>
                        </div>
                        <div class="four wide column">
                            <div class="fake-input">￥{{number_format($mainContracts[$i]->price,2)}}</div>
                        </div>
                        <div class="six wide column">
                            <div class="fake-input">{{$mainContracts[$i]->remark}}</div>
                        </div>
                    </div>
                        @endfor
                    {{--@endforeach--}}
                </div>
            </div>
            <!-- /主合同中标情况 -->

            <!-- 合同分包情况 -->
            <h4 class="ui dividing header blue margin-top-50">合同分包情况</h4>
            <div class="ui form form-item">
                <div class="ui five column doubling stackable grid">
                    <div class="two wide column form-thead">序号</div>
                    <div class="four wide column form-thead">发包单位</div>
                    <div class="four wide column form-thead">分包金额</div>
                    <div class="six wide column form-thead">备注</div>
                </div>
                <div class="form-wrap special-form">
                    @for($i=0;$i<count($outContracts);$i++)
                    {{--@foreach($outContracts as $outContract  )--}}
                    <div class="ui three column doubling stackable grid center aligned">
                        <div class="two wide column">
                            <div class="fake-input">{{$i+1}}</div>
                        </div>
                        <div class="four wide column">
                            <div class="fake-input">{{$outContracts[$i]->unit}}</div>
                        </div>
                        <div class="four wide column">
                            <div class="fake-input">￥{{number_format($outContracts[$i]->price,2)}}</div>
                        </div>
                        <div class="six wide column">
                            <div class="fake-input">{{$outContracts[$i]->remark}}</div>
                        </div>
                    </div>
                    @endfor

                </div>
            </div>
            <!-- /合同分包情况 -->

            <!-- 项目实际情况 -->
            <h4 class="ui dividing header blue margin-top-50">项目实际情况</h4>
            <div class="check-item table-head-nowrap">
                <table class="ui celled structured table unstackable center aligned">
                    <thead>
                    <tr>
                        <th rowspan="3">类型</th>
                        <th rowspan="3">金额</th>
                        <th colspan="4">具体内容</th>
                    </tr>
                    <tr>
                        <th>内容</th>
                        <th>税率</th>
                        <th>金额</th>
                        <th>备注</th>
                    </tr>
                    </thead>
                    <tbody>
                    @for($i=0;$i<count($situations);$i++)
                        {{--{{dd($situations[1]->lists)}}--}}
                        {{--                        {{$situations[1]->lists}}--}}
                        @for($j=0;$j<count($situations[$i]->lists);$j++)

                            @if($j==0)
                                <tr>
                                    @if($situations[$i]->type==1&&$situations[$i]->is_main==1)
                                        <td rowspan="{{count($situations[$i]->lists)}}">主合同</td>
                                    @elseif($situations[$i]->type==1&&$situations[$i]->is_main==0)
                                        <td rowspan="{{count($situations[$i]->lists)}}">主合同后期追加或减少</td>
                                    @elseif($situations[$i]->type==2&&$situations[$i]->is_main==1)
                                        <td rowspan="{{count($situations[$i]->lists)}}">分包合同</td>
                                    @else
                                        <td rowspan="{{count($situations[$i]->lists)}}">分包合同后期追加或减少</td>
                                    @endif
                                    <td rowspan="{{count($situations[$i]->lists)}}">￥{{number_format($situations[$i]->price,2)}} </td>

                                    <td>{{$situations[$i]->lists[$j]->name}}</td>
                                    <td>{{$situations[$i]->lists[$j]->tax}}%</td>
                                    <td>￥{{number_format($situations[$i]->lists[$j]->price,2)}} </td>
                                    <td>{{$situations[$i]->lists[$j]->remark}}</td>
                                </tr>


                            @else

                                <tr>
                                    <td>{{$situations[$i]->lists[$j]->name}}</td>
                                    <td>{{$situations[$i]->lists[$j]->tax}}%</td>
                                    <td>￥{{number_format($situations[$i]->lists[$j]->price,2)}} </td>
                                    <td>{{$situations[$i]->lists[$j]->remark}}</td>
                                </tr>

                            @endif
                        @endfor
                        {{--@endforeach--}}
                    @endfor
                    </tbody>
                </table>
            </div>
            <!-- /项目实际情况 -->

            <!-- 预算总额 -->
            <h4 class="ui dividing header blue margin-top-50">预算总额</h4>
            <div class="check-item table-head-nowrap">
                <table class="ui celled structured table unstackable center aligned">
                    <thead>
                    <tr>
                        <th rowspan="2">类型</th>
                        <th rowspan="2">金额</th>
                        <th rowspan="2">具体内容</th>
                        <th rowspan="2">具体金额</th>
                        <th rowspan="2">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td rowspan="3">预算总额</td>
                        <td rowspan="3">￥{{number_format($project->budget()->sum('cost'),2)}} </td>
                        <td>物料采购金额</td>
                        <td>￥{{number_format($project->budget()->where('type','=',1)->sum('cost'),2)}} </td>
                        <td rowspan="3">
                            <a href="javascript:_helper.fullWindow('{{url('budget/print')}}?id={{$project->id}}');">查看预算清单</a>
                        </td>
                    </tr>
                    <tr>
                        <td>工程金额</td>
                        <td>￥{{number_format($project->budget()->where('type','=',2)->sum('cost'),2)}} </td>
                    </tr>
                    <tr>
                        <td>其他</td>
                        <td>￥{{number_format($project->budget()->where('type','=',3)->sum('cost'),2)}} </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <!-- / 预算总额 -->
            <div class="flex-row flex-center margin-top-50">
                <a class="ui icon button primary" href="javascript:_helper.fullWindow('{{url('create/budget')}}?project_id={{$project->id}}');" style="margin: 0 20px;">
                    <i class="icon plus"></i>
                    <span>录入 / 修改预算清单</span>
                </a>
                <a class="ui icon button green" href="{{url('excel/excel1.xlsx')}}" style="margin: 0 20px;">
                    <i class="icon download"></i>
                    <span>导出预算清单格式</span>
                </a>
            </div>
        </div>

    </div>
    <!-- /主体内容 === 不可复用 -->
@endsection
@section('pageJs')
    {{--<script src="{{url('js/budget_detail.js')}}"></script>--}}
@endsection