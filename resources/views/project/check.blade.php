@extends('layouts.main_no_nav')
@section('title','已立项清单')
@section('content')
    <!-- 没有导航的单独窗口页面 -->
    <div class="normal-content print-no-padding">

        <div class="ui breadcrumb">
            <a class="section">项目立项管理</a>
            <div class="divider"> / </div>
            <a class="section" href="../project/list.html">已立项清单</a>
            <div class="divider"> / </div>
            <div class="active section">15823910212</div>
        </div>
        <input type="hidden" value="{{$project->id}}" id="projectId">
        <h1 class="inline-center">项目编号 - {{$project->number}}</h1>
        <div class="margin-top-20" id="projectCheck">
            <!-- 基本信息 -->
            <h4 class="ui dividing header blue">项目基本信息</h4>
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
                    {{--<div class="column">--}}
                        {{--<div class="inline fields">--}}
                            {{--<label class="four wide field">单位名</label>--}}
                            {{--<div class="twelve wide field">--}}
                                {{--<div class="fake-input">这是单位名</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
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
                                <div class="fake-input">{{$project->price}}￥</div>
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
                    @foreach($mainContracts as $mainContract)
                        <div class="ui three column doubling stackable grid center aligned">
                            <div class="two wide column">
                                <div class="fake-input">{{$mainContract->id}}</div>
                            </div>
                            <div class="four wide column">
                                <div class="fake-input">{{$mainContract->unit}}</div>
                            </div>
                            <div class="four wide column">
                                <div class="fake-input">{{$mainContract->price}}￥</div>
                            </div>
                            <div class="six wide column">
                                <div class="fake-input">{{$mainContract->remark}}</div>
                            </div>
                        </div>
                    @endforeach
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
                    @foreach($outContracts as $outContract)
                    <div class="ui three column doubling stackable grid center aligned">
                        <div class="two wide column">
                            <div class="fake-input">{{$outContract->id}}</div>
                        </div>
                        <div class="four wide column">
                            <div class="fake-input">{{$outContract->unit}}</div>
                        </div>
                        <div class="four wide column">
                            <div class="fake-input">{{$outContract->price}}￥</div>
                        </div>
                        <div class="six wide column">
                            <div class="fake-input">{{$outContract->remark}}</div>
                        </div>
                    </div>
                    @endforeach
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
                                <td rowspan="{{count($situations[$i]->lists[$j])}}">主合同</td>
                            @elseif($situations[$i]->type==1&&$situations[$i]->is_main==0)
                                <td rowspan="{{count($situations[$i]->lists[$j])}}">主合同后期追加或减少</td>
                            @elseif($situations[$i]->type==2&&$situations[$i]->is_main==1)
                                <td rowspan="{{count($situations[$i]->lists[$j])}}">分包合同</td>
                            @else
                                <td rowspan="{{count($situations[$i]->lists[$j])}}">分包合同后期追加或减少</td>
                            @endif
                            <td rowspan="{{count($situations[$i]->lists[$j])}}">{{$situations[$i]->price}} ￥</td>

                                    <td>{{$situations[$i]->lists[$j]->name}}</td>
                                    <td>{{$situations[$i]->lists[$j]->tax}}%</td>
                                    <td>{{$situations[$i]->lists[$j]->price}} ￥</td>
                                    <td>{{$situations[$i]->lists[$j]->remark}}</td>
                            </tr>


                        @else

                                <tr>
                                    <td>{{$situations[$i]->lists[$j]->name}}</td>
                                    <td>{{$situations[$i]->lists[$j]->tax}}%</td>
                                    <td>{{$situations[$i]->lists[$j]->price}} ￥</td>
                                    <td>{{$situations[$i]->lists[$j]->remark}}</td>
                                </tr>

                            @endif
                                @endfor
                    {{--@endforeach--}}
                    @endfor
                    </tbody>
                {{--</table>--}}
                </table>
            </div>
            <!-- /项目实际情况 -->

            <!-- 履约保证金情况 -->
            <h4 class="ui dividing header blue margin-top-50">履约保证金情况</h4>
            <div class="check-item table-head-nowrap">
                <table class="ui celled structured table unstackable center aligned">
                    <thead>
                    <tr>
                        <th rowspan="2">序号</th>
                        <th colspan="5">保函情况</th>
                        <th colspan="5">付款情况</th>
                    </tr>
                    <tr>
                        <th>开具单位</th>
                        <th>金额</th>
                        <th>期限</th>
                        <th>费用</th>
                        <th>其他</th>
                        <th>支付日期</th>
                        <th>支付金额</th>
                        <th>收款人</th>
                        <th>收款银行及账号</th>
                        <th>回收条件</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($bails as $bail)
                    <tr>
                        <td>{{$bail->id}}</td>
                        <td>{{$bail->unit}}</td>
                        <td>{{$bail->price}}￥</td>
                        <td>{{$bail->term}}</td>
                        <td>{{$bail->cost}}</td>
                        <td>{{$bail->other}}</td>
                        <td>{{$bail->pay_date}}</td>
                        <td>{{$bail->pay_price}}￥</td>
                        <td>{{$bail->payee}}</td>
                        <td>{{$bail->bank}} {{$bail->account}}</td>
                        <td>{{$bail->condition}}</td>
                    </tr>
                    @endforeach

                    {{--<tfoot>--}}
                    {{--<tr>--}}
                        {{--<th>合计</th>--}}
                        {{--<th></th>--}}
                        {{--<th>11,232￥</th>--}}
                        {{--<th></th>--}}
                        {{--<th>11,232￥</th>--}}
                        {{--<th></th>--}}
                        {{--<th>11,232￥</th>--}}
                        {{--<th></th>--}}
                        {{--<th></th>--}}
                        {{--<th></th>--}}
                        {{--<th></th>--}}
                    {{--</tr>--}}
                    {{--</tfoot>--}}
                </table>
            </div>
            <!-- / 履约保证金情况 -->

            <!-- 收款条件 -->
            <h4 class="ui dividing header blue margin-top-50">收款条件</h4>
            <div class="check-item table-head-nowrap">
                <table class="ui celled table unstackable center aligned">
                    <thead>
                    <tr>
                        <th>收款比例</th>
                        <th>预计金额</th>
                        <th>回收条件</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($receipts as $receipt)
                    <tr>
                        <td>{{$receipt->ratio}} %</td>
                        <td>{{$receipt->price}} ￥</td>
                        <td>{{$receipt->condition}}</td>
                    </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>合计</th>
                        <th>{{$project->receipt()->sum('price')}} ￥</th>
                        <th></th>
                    </tr>
                    </tfoot>
                </table>
            </div>
            <!-- / 收款条件 -->

            <!-- 合同 -->
            <h4 class="ui dividing header blue margin-top-50">合同</h4>
            <div class="check-item">
                <div class="ui three column doubling stackable grid">
                    @foreach($pictures as $picture)
                    <div class="column">
                        <a class="check-link" href="{{$picture->url}}" target="_blank">
                            <img class="check-img" src="{{$picture->url}}" alt="合同一">
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
            <!-- / 合同 -->
            <div class="inline-center margin-top-50">
                <a class="ui button primary large" href="javascript:_helper.fullWindow('{{url('project/create')}}?id={{$project->id}}')">
                    <i class="icon edit"></i>
                    <span>修改</span>
                </a>
                <button class="ui icon button primary" id="projectCheckBtn" style="margin:0 20px;">
                    <i class="icon legal"></i>
                    <span>复核</span>
                </button>
                <button class="ui icon button primary" id="projectPass" style="margin:0 20px;">
                    <i class="icon edit"></i>
                    <span>审批</span>
                </button>
            </div>
            <div class="ui page dimmer" id="projectCheckDialog">
                <div class="simple dimmer content">
                    <div class="center">
                        <div class="buy_dialog">
                            <div class="dialog_header">选择审批人</div>
                            <div class="dialog_content">
                                <el-checkbox-group v-model="checkedMen" @change="handleCheckManChange">
                                    <el-checkbox v-for="man in menList" :label="man.id" :key="man.id">@{{man.name}}</el-checkbox>
                                </el-checkbox-group>
                            </div>
                            <div class="diolag_footer">
                                <button class="ui button primary" @click="confirmRecheck">确 定</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- /主体内容 === 不可复用 -->
@endsection
@section('pageJs')
    <script src="{{url('js/project_check.js')}}"></script>
@endsection