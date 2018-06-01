@extends('layouts.main')
@section('title','已立项清单')
@section('content')
    <!-- 主体内容 === 不可复用 -->
    <div class="index-content print-no-padding">

        <div class="ui breadcrumb">
            <a class="section">报销与借款管理</a>
            <div class="divider"> / </div>
            <div class="active section">查询明细</div>
        </div>

        <!-- 操作 -->
        <input type="hidden" value="" id="originName">
        <h4 class="ui dividing header blue">录入基本信息</h4>
        <div class="content-operation invisible" id="loanDetailList">
            <form action="">
                <div class="ui form">
                    <div class="ui three column doubling stackable grid">
                        <div class="column">
                            <div class="inline fields">
                                <label class="six wide field flex-center">人员名称</label>
                                <div class="ten wide field">
                                    <input type="hidden" id="userName" name="name" placeholder="请输入人员名称">
                                    <el-autocomplete popper-class="my-autocomplete" v-model="search.name" :fetch-suggestions="querySearchMen" placeholder="请输入报销人"
                                                     @select="handleSelectMen">
                                        <i class="el-icon-edit el-input__icon" slot="suffix">
                                        </i>
                                        <template slot-scope="props">
                                            <div class="name">@{{ props.item }}</div>
                                        </template>
                                    </el-autocomplete>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="margin-top-20 flex-row flex-between flex-wrap">
                    <div>
                        <a class="ui green button" href="{{url('export/loan/detail').'?name='.$name.'&&s='.$s.'&&e='.$e}}">
                            <i class="icon download"></i>
                            <span>Excel 导出</span>
                        </a>
                    </div>
                    <div>
                        <el-date-picker v-model="date" name="search-date" type="datetimerange" :picker-options="dateOption" range-separator="至" start-placeholder="开始日期"
                                        end-placeholder="结束日期" align="right"  format="yyyy-MM-dd">
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


        <div class="content-wrap table-head-nowrap">

            <table class="ui celled structured center aligned table selectable unstackable">
                <thead>
                <tr>
                    <th rowspan="2">日期</th>
                    <th colspan="2">借款</th>
                    <th colspan="2">报销申请</th>
                    <th colspan="5">报销支付</th>
                    <th rowspan="2">未支付报销余额</th>
                    <th rowspan="2">借款余额</th>
                </tr>
                <tr>
                    <th>借款编号</th>
                    <th>借款金额</th>
                    <th>报销编号</th>
                    <th>报销金额</th>
                    <th>付款编号</th>
                    <th>付款金额</th>
                    <th>其中：抵扣借款</th>
                    <th>其中：现金付款</th>
                    <th>其中：银行转账</th>
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
                    <td>{{$start}}￥</td>
                    <td>{{$loanStart}}￥</td>
                </tr>
                @foreach($lists as $list)
                    @if(strstr($list['number'],'BXFK'))
                <tr>
                    <td>{{$list['date']}}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>{{$list['number']}}</td>
                    <td>{{number_format($list['price'],2)}}￥</td>
                    <td>{{number_format($list['deduction'],2)}}￥</td>
                    <td>{{number_format($list['cash'],2)}}</td>
                    <td>{{number_format($list['transfer'],2)}}￥</td>
                    <td>{{number_format($list['submitBalance'],2)}}￥</td>
                    <td>{{number_format($list['loanBalance'],2)}}￥</td>
                </tr>
                @elseif(strstr($list['number'],'JK'))
                        <tr>
                            <td>{{$list['date']}}</td>
                            <td>{{$list['number']}}</td>
                            <td>{{number_format($list['price'],2)}}￥</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>{{number_format($list['submitBalance'],2)}}￥</td>
                            <td>{{number_format($list['loanBalance'],2)}}￥</td>
                        </tr>
                        @else
                        <tr>
                            <td>{{$list['date']}}</td>
                            <td></td>
                            <td></td>
                            <td>{{$list['number']}}</td>
                            <td>{{number_format($list['price'],2)}} ￥</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>{{number_format($list['submitBalance'],2)}}￥</td>
                            <td>{{number_format($list['loanBalance'],2)}}￥</td>
                        </tr>
                        @endif

                @endforeach
                </tbody>

                <!-- 无数据时候，使用这个 -->
                <!-- <tbody>
                  <td colspan="12">暂无数据</td>
                </tbody> -->
                <!-- /无数据时候，使用这个 -->
            </table>
        </div>

    </div>
    <!-- /主体内容 === 不可复用 -->
@endsection
@section('pageJs')
    <script src="{{url('js/loan_detail_list.js')}}"></script>
@endsection