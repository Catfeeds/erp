@extends('layouts.main')
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
                    <div class="column">
                        <div class="inline fields">
                            <label class="four wide field">单位名</label>
                            <div class="twelve wide field">
                                <div class="fake-input">这是单位名</div>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="four wide field">甲方</label>
                            <div class="twelve wide field">
                                <div class="fake-input">{{$project->partyA}}</div>
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
                    <tr>
                        <td rowspan="3">主合同</td>
                        <td rowspan="3">123,542,000 ￥</td>
                        <td>内容一</td>
                        <td>17%</td>
                        <td>123,000 ￥</td>
                        <td>这是备注</td>
                    </tr>
                    <tr>
                        <td>内容二</td>
                        <td>5%</td>
                        <td>123,000 ￥</td>
                        <td>这是备注</td>
                    </tr>
                    <tr>
                        <td>内容三</td>
                        <td>9%</td>
                        <td>123,000 ￥</td>
                        <td>这是备注</td>
                    </tr>
                    <tr>
                        <td rowspan="2">主合同后期追加</td>
                        <td rowspan="2">42,000 ￥</td>
                        <td>内容一</td>
                        <td>17%</td>
                        <td>13,000 ￥</td>
                        <td>这是备注</td>
                    </tr>
                    <tr>
                        <td>内容三</td>
                        <td>5%</td>
                        <td>23,100 ￥</td>
                        <td>这是备注</td>
                    </tr>
                    <tr>
                        <td rowspan="2">分包合同</td>
                        <td rowspan="2">123,542,000 ￥</td>
                        <td>内容一</td>
                        <td>17%</td>
                        <td>123,000 ￥</td>
                        <td>这是备注</td>
                    </tr>
                    <tr>
                        <td>内容三</td>
                        <td>9%</td>
                        <td>123,000 ￥</td>
                        <td>这是备注</td>
                    </tr>
                    <tr>
                        <td rowspan="1">分包合同后期追加</td>
                        <td rowspan="1">42,000 ￥</td>
                        <td>内容一</td>
                        <td>17%</td>
                        <td>13,000 ￥</td>
                        <td>这是备注</td>
                    </tr>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th rowspan="3">合计</th>
                        <th rowspan="3">123,542,000 ￥</th>
                        <th>内容一</th>
                        <th>17%</th>
                        <th>123,000 ￥</th>
                        <th>/</th>
                    </tr>
                    <tr>
                        <th>内容二</th>
                        <th>9%</th>
                        <th>123,000 ￥</th>
                        <th>/</th>
                    </tr>
                    <tr>
                        <th>内容三</th>
                        <th>9%</th>
                        <th>123,000 ￥</th>
                        <th>/</th>
                    </tr>
                    </tfoot>
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
                    <tr>
                        <td>1</td>
                        <td>xxxx单位</td>
                        <td>123,523￥</td>
                        <td>2018-02-11</td>
                        <td>12,321</td>
                        <td>这是其他信息</td>
                        <td>2018-02-12</td>
                        <td>1,232￥</td>
                        <td>陈一发</td>
                        <td>中国银行 60294825472829122234</td>
                        <td>这是回收条件</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td colspan="5">暂无数据</td>
                        <td>2018-02-12</td>
                        <td>1,232￥</td>
                        <td>陈一发</td>
                        <td>中国银行 60294825472829122234</td>
                        <td>这是回收条件</td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>xxxx单位</td>
                        <td>123,523￥</td>
                        <td>2018-02-11</td>
                        <td>12,321</td>
                        <td>这是其他信息</td>
                        <td colspan="5">暂无数据</td>
                    </tr>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>合计</th>
                        <th></th>
                        <th>11,232￥</th>
                        <th></th>
                        <th>11,232￥</th>
                        <th></th>
                        <th>11,232￥</th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                    </tfoot>
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
                    <tr>
                        <td>17%</td>
                        <td>200,000,232 ￥</td>
                        <td>回收条件回收条件回收条件回收条件回收条件回收条件</td>
                    </tr>
                    <tr>
                        <td>8%</td>
                        <td>200,000,232 ￥</td>
                        <td>回收条件回收条件回收条件回收条件回收条件回收条件</td>
                    </tr>
                    <tr>
                        <td>5%</td>
                        <td>200,000,232 ￥</td>
                        <td>回收条件回收条件回收条件回收条件回收条件回收条件</td>
                    </tr>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>合计</th>
                        <th>123,523,220 ￥</th>
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
                    <div class="column">
                        <a class="check-link" href="https://www.huaguo.cn/resources/images/ht/hb1.jpg" target="_blank">
                            <img class="check-img" src="https://www.huaguo.cn/resources/images/ht/hb1.jpg" alt="合同一">
                        </a>
                    </div>
                    <div class="column">
                        <a class="check-link" href="https://www.huaguo.cn/resources/images/ht/hb1.jpg" target="_blank">
                            <img class="check-img" src="https://www.huaguo.cn/resources/images/ht/hb1.jpg" alt="合同二">
                        </a>
                    </div>
                    <div class="column">
                        <a class="check-link" href="https://www.huaguo.cn/resources/images/ht/hb1.jpg" target="_blank">
                            <img class="check-img" src="https://www.huaguo.cn/resources/images/ht/hb1.jpg" alt="合同三">
                        </a>
                    </div>
                </div>
            </div>
            <!-- / 合同 -->
            <div class="inline-center margin-top-50">
                <a class="ui button primary large" href="javascript:_helper.fullWindow('../project/create.html')">
                    <i class="icon edit"></i>
                    <span>修改</span>
                </a>
            </div>
        </div>

    </div>
    <!-- /主体内容 === 不可复用 -->
@endsection
@section('pageJs')
    {{--<script src="{{url('js/project_check.js')}}"></script>--}}
@endsection