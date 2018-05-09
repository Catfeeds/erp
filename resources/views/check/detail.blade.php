@extends('layouts.main')
@section('title','项目明细 - 项目编号'.$project->number)
@section('content')
    <!-- 没有导航的单独窗口页面 -->
    <div class="normal-content print-no-padding">

        <div class="ui breadcrumb">
            <a class="section">验收与收款管理</a>
            <div class="divider"> / </div>
            <a class="section" href="{{url('check/list')}}">验收与收款清单</a>
            <div class="divider"> / </div>
            <div class="active section">项目明细 - 项目编号 {{$project->number}}</div>
        </div>

        <div style="display:none" id="marginPay">{"count1":123123,"count2":123123,"count3":213421252,"data":[{"id":1,"guarantee":{"company":"单位一","amount":12315412,"date":"2018-02-11","cost":5232,"others":"其他信息"},"payment":{"date":"2018-02-04","amount":52321,"payee":"张先生","bank":"广发银行","account":6009876787523154000,"recyle":"回收条件条件"}},{"id":2,"guarantee":{"company":"单位二","amount":223542,"date":"2018-02-15","cost":6234,"others":"其他信息"},"payment":{"date":"2018-02-04","amount":52321,"payee":"张先生","bank":"广发银行","account":6009876787523154000,"recyle":"回收条件条件"}}]}</div>
        <div style="display:none" id="marginRecyle">{"count":1111111,"leftCount":2321,"data":[{"id":1,"preDate":"2018-01-02","preAmount":12342213,"prePeople":"张先生","preRemark":"这是备注","realDate":"2018-02-01","realBank":"中国银行","realAmount":231523,"realPeople":"张先生","realAccount":60002321523215230000},{"id":2,"preDate":"2018-03-02","preAmount":5232124,"prePeople":"成先生","preRemark":"这是备注","realDate":"2018-04-01","realBank":"广发银行","realAmount":2342,"realPeople":"成先生","realAccount":60002321523215230000}]}</div>
        <div style="display:none" id="requirement">{"count":123123,"data":[{"id":1,"date":"2018-10-22","amount":123142,"company":"xxx单位","remark":"这是备注~"},{"id":2,"date":"2017-12-22","amount":123,"company":"xxx单位","remark":"这是备注这是备注~"}]}</div>
        <div style="display:none" id="invoice">{"count":2312312,"data":[{"id":1,"date":"2018-01-02","amount":2132,"company":{"id":1,"value":"单位一"},"tax":{"id":1,"value":5}},{"id":2,"date":"2018-01-02","amount":2132,"company":{"id":1,"value":"单位一"},"tax":{"id":1,"value":5}},{"id":3,"date":"2018-01-02","amount":2132,"company":{"id":2,"value":"单位二"},"tax":{"id":2,"value":9}},{"id":4,"date":"2018-01-02","amount":2132,"company":{"id":3,"value":"单位三"},"tax":{"id":3,"value":15}},{"id":5,"date":"2018-01-02","amount":2132,"company":{"id":3,"value":"单位三"},"tax":{"id":1,"value":5}}]}</div>
        <div style="display:none" id="invoiceCompany">[{"id":1,"value":"单位一"},{"id":2,"value":"单位二"},{"id":3,"value":"单位三"}]</div>
        <div style="display:none" id="invoiceTax">{{json_encode($invoiceTax)}}</div>
        <div style="display:none" id="subCompany">{"count":323123,"data":[{"id":1,"date":"2018-01-02","amount":213123,"remark":"这是备注啊~"},{"id":2,"date":"2018-01-02","amount":3212,"remark":"这是备注啊~"},{"id":3,"date":"2018-01-02","amount":4274,"remark":"这是备注啊~"}]}</div>
        <div style="display:none" id="masterContract">{"count":123123,"data":[{"id":1,"date":"2018-09-21","amount":213123,"bank":"中国银行","account":6034232123523673000,"remark":"这是备注~"},{"id":2,"date":"2018-09-21","amount":6423,"bank":"中国银行","account":603423212123473200,"remark":"这是备注~"},{"id":3,"date":"2018-09-21","amount":6321,"bank":"广发银行","account":6034232123242673000,"remark":"这是备注~"},{"id":4,"date":"2018-09-21","amount":32421,"bank":"中国银行","account":6034232123523673000,"remark":"这是备注~"}]}</div>
        <div style="display:none" id="subContract">{"count":123123,"data":[{"id":1,"date":"2018-09-21","amount":213123,"bank":"中国银行","account":6034232123523673000,"remark":"这是备注~"},{"id":2,"date":"2018-09-21","amount":6423,"bank":"中国银行","account":603423212123473200,"remark":"这是备注~"},{"id":3,"date":"2018-09-21","amount":6321,"bank":"广发银行","account":6034232123242673000,"remark":"这是备注~"},{"id":4,"date":"2018-09-21","amount":32421,"bank":"中国银行","account":6034232123523673000,"remark":"这是备注~"}]}</div>


        <h1 class="inline-center">项目编号 - {{$project->number}}</h1>
        <div id="projectCheck">
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
                    <div class="column">
                        <div class="inline fields">
                            <label class="four wide field">验收日期</label>
                            <div class="twelve wide field">
                                <div class="fake-input">{{$project->acceptance_date}}</div>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="four wide field">保修截止日期</label>
                            <div class="twelve wide field">
                                <div class="fake-input">{{$project->deadline}}</div>
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
                        <div class="ui three column doubling stackable grid center aligned">
                            <div class="two wide column">
                                <div class="fake-input">{{$i+1}}</div>
                            </div>
                            <div class="four wide column">
                                <div class="fake-input">{{$mainContracts[$i]->unit}}</div>
                            </div>
                            <div class="four wide column">
                                <div class="fake-input">{{$mainContracts[$i]->price}}￥</div>
                            </div>
                            <div class="six wide column">
                                <div class="fake-input">{{$mainContracts[$i]->remark}}</div>
                            </div>
                        </div>
                    @endfor
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
                        <div class="ui three column doubling stackable grid center aligned">
                            <div class="two wide column">
                                <div class="fake-input">{{$i+1}}</div>
                            </div>
                            <div class="four wide column">
                                <div class="fake-input">{{$outContracts[$i]->unit}}</div>
                            </div>
                            <div class="four wide column">
                                <div class="fake-input">{{$outContracts[$i]->price}}￥</div>
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
                                    <td rowspan="{{count($situations[$i]->lists)}}">{{$situations[$i]->price}} ￥</td>

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
                    {{--<tfoot>--}}
                    {{--<tr>--}}
                        {{--<th rowspan="3">合计</th>--}}
                        {{--<th rowspan="3">123,542,000 ￥</th>--}}
                        {{--<th>内容一</th>--}}
                        {{--<th>17%</th>--}}
                        {{--<th>123,000 ￥</th>--}}
                        {{--<th>/</th>--}}
                    {{--</tr>--}}
                    {{--<tr>--}}
                        {{--<th>内容二</th>--}}
                        {{--<th>9%</th>--}}
                        {{--<th>123,000 ￥</th>--}}
                        {{--<th>/</th>--}}
                    {{--</tr>--}}
                    {{--<tr>--}}
                        {{--<th>内容三</th>--}}
                        {{--<th>9%</th>--}}
                        {{--<th>123,000 ￥</th>--}}
                        {{--<th>/</th>--}}
                    {{--</tr>--}}
                    {{--</tfoot>--}}
                </table>
            </div>
            <!-- /项目实际情况 -->

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
                        <td>{{$receipt->ratio}}%</td>
                        <td>{{$receipt->price}} ￥</td>
                        <td>{{$receipt->condition}}</td>
                    </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    {{--<tr>--}}
                        {{--<th>合计</th>--}}
                        {{--<th>123,523,220 ￥</th>--}}
                        {{--<th></th>--}}
                    {{--</tr>--}}
                    </tfoot>
                </table>
            </div>
            <!-- / 收款条件 -->

            <!-- 合同 -->
            <h4 class="ui dividing header blue margin-top-50">合同</h4>
            <div class="check-item table-head-nowrap">
                <table class="ui celled table unstackable center aligned">
                    <thead>
                    <tr>
                        <th>序号</th>
                        <th>名称</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @for($i=0;$i<count($pictures);$i++)
                    <tr>
                        <td>{{$i+1}}</td>
                        <td>{{$pictures[$i]->name}}</td>
                        <td>
                            <a href="{{$pictures[$i]->url}}" target="_blank">查看</a>
                        </td>
                    </tr>
                    @endfor
                    </tbody>
                </table>
            </div>
            <!-- / 合同 -->

            <!-- Vue 渲染部分 -->
            <div id="checkDetail" >

                <!-- 履约金保证情况 -->
                <h4 class="ui dividing header blue margin-top-50">履约金保证情况</h4>
                <div class="check-item table-head-nowrap">
                    <table class="ui celled structured table unstackable center aligned">
                        <thead>
                        <tr>
                            <th colspan="5">保函情况</th>
                            <th colspan="6">付款情况</th>
                        </tr>
                        <tr>
                            <th>开具单位</th>
                            <th>金额</th>
                            <th>到期日</th>
                            <th>费用</th>
                            <th>其他</th>
                            <th>支付日期</th>
                            <th>支付金额</th>
                            <th>收款人</th>
                            <th>付款银行</th>
                            <th>付款账户</th>
                            <th>回收条件</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($bails as $bail)
                        <tr >
                            <td>{{$bail->unit}}</td>
                            <td>{{$bail->price}} ￥</td>
                            <td>{{$bail->term}}</td>
                            <td>{{$bail->cost}} ￥</td>
                            <td>{{$bail->other}}</td>
                            <td>{{$bail->pay_date}}</td>
                            <td> {{$bail->pay_price}}￥</td>
                            <td>{{$bail->payee}}</td>
                            <td>{{$bail->bank}}</td>
                            <td>{{$bail->bank_account}}</td>
                            <td>{{$bail->condition}}</td>
                        </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>合计</th>
                            <th>{{$project->bail()->sum('price')}} ￥</th>
                            <th>/</th>
                            <th>{{$project->bail()->sum('cost')}} ￥</th>
                            <th>/</th>
                            <th>/</th>
                            <th>{{$project->bail()->sum('pay_price')}} ￥</th>
                            <th>/</th>
                            <th>/</th>
                            <th>/</th>
                            <th>/</th>
                        </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="check-item margin-top-50" style="overflow:auto;">
                    <table class="ui celled structured table center aligned special" v-if="marginRecyle.data && marginRecyle.data.length">
                        <thead>
                        <tr>
                            <th colspan="10">履约保证金回收情况</th>
                        </tr>
                        <tr>
                            <th colspan="4">预计回收</th>
                            <th colspan="5">实际回收</th>
                            <th>操作</th>
                        </tr>
                        <tr>
                            <th>预计回收日期</th>
                            <th>预计回收金额</th>
                            <th>付款人</th>
                            <th>备注</th>
                            <th>实际回收日期</th>
                            <th>实际回收金额</th>
                            <th>付款人</th>
                            <th>付款银行</th>
                            <th>付款账户</th>
                            <th>/</th>
                        </tr>
                        </thead>
                        <tbody>
                        @for($i=0;$i<count($bailReturn);$i++)
                        <tr >
                            <template >
                                <td>{{$bailReturn[$i]->pay_date}}</td>
                                <td>{{$bailReturn[$i]->price}}</td>
                                <td>{{$bailReturn[$i]->pay_unit}}</td>
                                <td>{{$bailReturn[$i]->remark}}</td>
                                @if(isset($bailGet[$i]))
                                <td>{{$bailGet[$i]->date}}</td>
                                <td>{{$bailGet[$i]->price}}</td>
                                <td>{{$bailGet[$i]->payee}}</td>
                                <td>{{$bailGet[$i]->bank}}</td>
                                <td>{{$bailGet[$i]->account}}</td>
                                @else
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                @endif
                                <td>
                                    <button class="ui mini button primary" @click="EditFnc(item, index, 'marginRecyle')">修改</button>
                                </td>
                            </template>
                        </tr>
                            @endfor
                        </tbody>
                        <tfoot>
                        <tr>
                            <th colspan="3">实际回收合计</th>
                            <th colspan="7"> {{$project->collects()->where('type','=',1)->sum('price')}}￥</th>
                        </tr>
                        <tr>
                            <th colspan="3">剩余未回收保证金</th>
                            <th colspan="7"> {{$project->tips()->where('type','=',1)->sum('price')-$project->collects()->where('type','=',1)->sum('price')}}￥</th>
                        </tr>
                        </tfoot>
                    </table>
                    <div v-else>暂无数据</div>
                </div>
                <!-- / 履约金保证情况 -->

                <!-- 预计请款计划 -->
                <h4 class="ui dividing header blue margin-top-50">预计请款计划</h4>
                <div class="check-item">
                    <table class="ui celled structured table center aligned special" v-if="requirement.data && requirement.data.length">
                        <thead>
                        <tr>
                            <th colspan="5">预计请款计划</th>
                        </tr>
                        <tr>
                            <th>请款日期</th>
                            <th>请款金额</th>
                            <th>付款单位</th>
                            <th>备注</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($tips as $tip)
                        <tr >
                            <template >
                                <td>{{ $tip->pay_date }}</td>
                                <td>{{ $tip->price }}</td>
                                <td>{{ $tip->pay_unit }}</td>
                                <td>{{ $tip->remark }}</td>
                                <td>
                                    <button class="ui mini button primary" @click="EditFnc(item, index, 'requirement')">修改</button>
                                </td>
                            </template>
                        </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>合计</th>
                            <th colspan="4">{{$project->tips()->where('type','=',2)->sum('price')}} ￥</th>
                        </tr>
                        </tfoot>
                    </table>
                    <h4 v-else class="ui horizontal divider header" style="padding-top:20px;">暂无数据</h4>
                </div>
                <!-- / 预计请款计划 -->

                <!-- 开票 -->
                <h4 class="ui dividing header blue margin-top-50">开票</h4>
                <template v-if="invoice.data && invoice.data.length">
                    <div class="check-item">
                        <table class="ui celled structured table center aligned">
                            <thead>
                            <tr>
                                <th colspan="5">开票</th>
                            </tr>
                            <tr>
                                <th>开票日期</th>
                                <th>开票金额（含税）</th>
                                <th>付款单位</th>
                                <th>税率</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($invoiceList as $item)
                            <tr >
                                <template >
                                    <td>{{$item->date}}</td>
                                    <td>{{$item->price}}￥</td>
                                    <td>{{$item->unit}}</td>
                                    <td>{{$item->rate}}%</td>
                                    <td>
                                        <button class="ui mini button primary" @click="EditFnc(item, index, 'invoice')">修改</button>
                                        <button @click="window._helper.fullWindow('{{url('check/invoice/print')}}?id={{$item->id}}')" class="ui mini button primary">凭证</button>
                                    </td>
                                </template>
                            </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>合计</th>
                                <th colspan="4">{{ $project->invoices()->sum('price')}} ￥</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="check-item margin-top-50">
                        <table class="ui celled structured table center aligned">
                            <thead>
                            <tr>
                                <th :colspan="invoiceTax.length + 2">开票计算结果</th>
                            </tr>
                            <tr>
                                <th>付款单位</th>
                                <th v-for="(item, index) in invoiceTax">@{{ item.value }} %</th>
                                <th>合计</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(item, index) in invoiceTaxCount" :key="item.company.id">
                                <td>@{{ item.company.name }}</td>
                                <td v-for="(value, key) in invoiceCompanyCopy" :key="key">@{{ item.result[key] || '/' }}</td>
                                <td>@{{ item.count.toLocaleString('en-US') }} ￥</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </template>
                <template v-else>
                    <h4 class="ui horizontal divider header" style="padding-top:20px;">暂无数据</h4>
                </template>
                <!-- / 开票 -->

                <!-- 发包公司收款情况 -->
                <h4 class="ui dividing header blue">发包公司收款情况</h4>
                <div class="check-item">
                    <table class="ui celled structured table center aligned" >
                        <thead>
                        <tr>
                            <th colspan="4">发包公司收款情况</th>
                        </tr>
                        <tr>
                            <th>收款日期</th>
                            <th>收款金额</th>
                            {{--<th>备注</th>--}}
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($subCompanies as $company)
                        <tr >
                            <template >
                                <td>{{ $company->date }}</td>
                                <td>{{ $company->price }} ￥</td>
                                {{--<td>@{{ item.remark }}</td>--}}
                                <td>
                                    <button class="ui mini button primary">修改</button>
                                </td>
                            </template>
                        </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>合计</th>
                            <th colspan="3">{{$project->collects()->where('type','=',4)->sum('price')}} ￥</th>
                        </tr>
                        </tfoot>
                    </table>
                    <h4 v-else class="ui horizontal divider header" style="padding-top:20px;">暂无数据</h4>
                </div>
                <!-- / 发包公司收款情况 -->

                <!-- 主合同收款 -->
                <h4 class="ui dividing header blue">主合同收款</h4>
                <div class="check-item">
                    <table class="ui celled structured table center aligned" v-if="masterContract.data && masterContract.data.length">
                        <thead>
                        <tr>
                            <th colspan="6">主合同收款</th>
                        </tr>
                        <tr>
                            <th>收款日期</th>
                            <th>收款金额</th>
                            <th>收款银行</th>
                            <th>收款账号</th>
                            {{--<th>备注</th>--}}
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            @if(empty($masterContract))
                            <template>
                                <td>
                                    <el-date-picker v-model="editForm.masterContract.date" value-format="yyyy-MM-dd" type="date" placeholder="收款日期">
                                    </el-date-picker>
                                </td>
                                <td>
                                    <div class="ui input">
                                        <input v-model.number="editForm.masterContract.amount" type="number" placeholder="收款金额">
                                    </div>
                                </td>
                                <td>
                                    <div class="ui input">
                                        <input v-model="editForm.masterContract.bank" type="text" placeholder="收款银行">
                                    </div>
                                </td>
                                <td>
                                    <div class="ui input">
                                        <input v-model.number="editForm.masterContract.account" type="number" placeholder="收款账号账号">
                                    </div>
                                </td>
                                {{--<td>--}}
                                    {{--<div class="ui input">--}}
                                        {{--<input v-model="editForm.masterContract.remark" type="text" placeholder="备注D">--}}
                                    {{--</div>--}}
                                {{--</td>--}}
                                <td>
                                    <button class="ui mini button green" @click="masterContractSave(item, index)">保存</button>
                                    <button @click="window._helper.fullWindow('../check/collect_master_print.html?id='+item.id)" class="ui mini button primary">凭证</button>
                                </td>
                            </template>
                            @else
                            <template>
                                @foreach($masterContract as $item)
                                <td>{{ $item->date }}</td>
                                <td>{{ $item->price }} ￥</td>
                                <td>{{ $item->bank }}</td>
                                <td>{{ $item->account }}</td>
                                {{--<td>{{ $item.remark }}</td>--}}
                                <td>
                                    <button class="ui mini button primary" @click="EditFnc(item, index, 'masterContract')">修改</button>
                                    <button @click="window._helper.fullWindow('{{url('check/master/print')}}?id={{$item->id}}')" class="ui mini button primary">凭证</button>
                                </td>
                                    @endforeach
                            </template>
                                @endif
                        </tr>
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>合计</th>
                            <th colspan="5">{{$project->collects()->where('type','=',2)->sum('price')}} ￥</th>
                        </tr>
                        </tfoot>
                    </table>
                    <h4 v-else class="ui horizontal divider header" style="padding-top:20px;">暂无数据</h4>
                </div>
                <!-- / 主合同收款 -->

                <!-- 分包合同收款 -->
                <h4 class="ui dividing header blue">分包合同收款</h4>
                <div class="check-item">
                    <table class="ui celled structured table center aligned" v-if="subContract.data && subContract.data.length">
                        <thead>
                        <tr>
                            <th colspan="6">分包合同收款</th>
                        </tr>
                        <tr>
                            <th>收款日期</th>
                            <th>收款金额</th>
                            <th>收款银行</th>
                            <th>收款账号</th>
                            {{--<th>备注</th>--}}
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>

                        <tr >
                            @if(empty($subContract))
                            <template >
                                <td>
                                    <el-date-picker v-model="editForm.subContract.date" value-format="yyyy-MM-dd" type="date" placeholder="收款日期">
                                    </el-date-picker>
                                </td>
                                <td>
                                    <div class="ui input">
                                        <input v-model.number="editForm.subContract.amount" type="number" placeholder="收款金额">
                                    </div>
                                </td>
                                <td>
                                    <div class="ui input">
                                        <input v-model="editForm.subContract.bank" type="text" placeholder="收款银行">
                                    </div>
                                </td>
                                <td>
                                    <div class="ui input">
                                        <input v-model.number="editForm.subContract.account" type="number" placeholder="收款账号账号">
                                    </div>
                                </td>
                                {{--<td>--}}
                                    {{--<div class="ui input">--}}
                                        {{--<input v-model="editForm.subContract.remark" type="text" placeholder="备注D">--}}
                                    {{--</div>--}}
                                {{--</td>--}}
                                <td>
                                    <button class="ui mini button green" @click="subContractSave(item, index)">保存</button>
                                    <button @click="window._helper.fullWindow('../check/collect_sub_print.html?id='+item.id)" class="ui mini button primary">凭证</button>
                                </td>
                            </template>
                            @else
                                @foreach($subContract as $item)
                            <template >
                                <td>{{ $item->date }}</td>
                                <td>{{ $item->price}} ￥</td>
                                <td>{{ $item->bank }}</td>
                                <td>{{ $item->account }}</td>

                                <td>
                                    <button class="ui mini button primary" @click="EditFnc(item, index, 'subContract')">修改</button>
                                    <button @click="window._helper.fullWindow('{{url('check/sub/print')}}?id={{$item->id}}')" class="ui mini button primary">凭证</button>
                                </td>

                            </template>
                                @endforeach
                                @endif
                        </tr>
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>合计</th>
                            <th colspan="5">{{$project->collects()->where('type','=',3)->sum('price')}} ￥</th>
                        </tr>
                        </tfoot>
                    </table>
                    <h4 v-else class="ui horizontal divider header" style="padding-top:20px;">暂无数据</h4>
                </div>
                <!-- / 分包合同收款 -->
            </div>
            <!-- / Vue 渲染部分 -->
            <div class="flex-row flex-center margin-top-50 btns">
                <a class="ui icon button primary" href="javascript:_helper.fullWindow('{{url('project/acceptance')}}?id={{$project->id}}');">
                    <i class="icon pin"></i>
                    <span>验收</span>
                </a>
                <a class="ui icon button primary" href="javascript:_helper.fullWindow('{{url('create/tips')}}?id={{$project->id}}');">
                    <i class="icon bookmark"></i>
                    <span>收款提示</span>
                </a>
                <a class="ui icon button primary" href="javascript:_helper.fullWindow('{{url('check/invoice')}}?id={{$project->id}}');">
                    <i class="icon write"></i>
                    <span>开票</span>
                </a>
                <a class="ui icon button primary" href="javascript:_helper.fullWindow('{{url('check/collect')}}?id={{$project->id}}');">
                    <i class="icon yen"></i>
                    <span>收款</span>
                </a>
            </div>
        </div>

    </div>
    <!-- /主体内容 === 不可复用 -->
            <!-- / Vue 渲染部分 -->
@endsection
@section('pageJs')
    <script src="{{url('js/check_detail.js')}}"></script>
@endsection