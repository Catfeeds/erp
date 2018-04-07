@extends('layouts.main')
@section('title','已立项清单')
@section('content')
    <!-- 没有导航的单独窗口页面 -->
    <div class="normal-content print-no-padding">

        <div class="ui breadcrumb">
            <a class="section">预算管理</a>
            <div class="divider"> / </div>
            <a class="section" href="../budget/list.html">预算清单</a>
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
                                <div class="fake-input">2018-01-02</div>
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
                                <div class="fake-input">甲方</div>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="four wide field">项目合同金额</label>
                            <div class="twelve wide field icon input">
                                <div class="fake-input">123,523￥</div>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="four wide field">预计完工日期</label>
                            <div class="twelve wide field">
                                <div class="fake-input">2018-01-22</div>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="four wide field">项目经理</label>
                            <div class="twelve wide field">
                                <div class="fake-input">陈一发</div>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="four wide field">维护要求</label>
                            <div class="twelve wide field">
                                <div class="fake-input">这是维护要求</div>
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
                    <div class="ui three column doubling stackable grid center aligned">
                        <div class="two wide column">
                            <div class="fake-input">1</div>
                        </div>
                        <div class="four wide column">
                            <div class="fake-input">单位A</div>
                        </div>
                        <div class="four wide column">
                            <div class="fake-input">123,523￥</div>
                        </div>
                        <div class="six wide column">
                            <div class="fake-input">这是一些备注</div>
                        </div>
                    </div>
                    <div class="ui three column doubling stackable grid center aligned">
                        <div class="two wide column">
                            <div class="fake-input">2</div>
                        </div>
                        <div class="four wide column">
                            <div class="fake-input">单位B</div>
                        </div>
                        <div class="four wide column">
                            <div class="fake-input">123,523￥</div>
                        </div>
                        <div class="six wide column">
                            <div class="fake-input">这是一些备注这是一些备注</div>
                        </div>
                    </div>
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
                    <div class="ui three column doubling stackable grid center aligned">
                        <div class="two wide column">
                            <div class="fake-input">1</div>
                        </div>
                        <div class="four wide column">
                            <div class="fake-input">发包单位A</div>
                        </div>
                        <div class="four wide column">
                            <div class="fake-input">123,523￥</div>
                        </div>
                        <div class="six wide column">
                            <div class="fake-input">这是一些备注</div>
                        </div>
                    </div>
                    <div class="ui three column doubling stackable grid center aligned">
                        <div class="two wide column">
                            <div class="fake-input">2</div>
                        </div>
                        <div class="four wide column">
                            <div class="fake-input">发包单位B</div>
                        </div>
                        <div class="four wide column">
                            <div class="fake-input">123,523￥</div>
                        </div>
                        <div class="six wide column">
                            <div class="fake-input">这是一些备注这是一些备注</div>
                        </div>
                    </div>
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
                        <td rowspan="3">111,542,000 ￥</td>
                        <td>物料采购金额</td>
                        <td>111,542,000 ￥</td>
                        <td rowspan="3">
                            <a href="javascript:_helper.fullWindow('../budget/print.html');">查看预算清单</a>
                        </td>
                    </tr>
                    <tr>
                        <td>工程金额</td>
                        <td>111,542,000 ￥</td>
                    </tr>
                    <tr>
                        <td>其他</td>
                        <td>111,542,000 ￥</td>
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
                <a class="ui icon button green" href="#" style="margin: 0 20px;">
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