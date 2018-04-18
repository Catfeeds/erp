@extends('layouts.main_no_nav')
@section('title','已立项清单')
@section('content')
    <!-- 没有导航的单独窗口页面 -->
    <div class="normal-content print-no-padding">

        <div class="ui breadcrumb">
            <a class="section">采购管理</a>
            <div class="divider"> / </div>
            <a class="section" href="../buy/project_list.html">采购立项清单</a>
            <div class="divider"> / </div>
            <a class="section" href="../buy/budgetary.html">预算内采购</a>
            <div class="divider"> / </div>
            <div class="active section">查询</div>
        </div>

        <h1 class="ui header blue center aligned">预算内采购 - 查询</h1>
        <h4 class="ui dividing header blue">基本信息</h4>
        <table class="ui celled structured center aligned table selectable unstackable">
            <thead>
            <tr>
                <th>采购编号</th>
                <th class="font-normal bg-white">{{$purchase->number}}</th>
                <th>采购日期</th>
                <th class="font-normal bg-white">{{$purchase->date}}</th>
            </tr>
            <tr>
                <th rowspan="3">供货商</th>
                <th>供货商名称</th>
                <th class="font-normal bg-white" colspan="2">{{$purchase->supplier}}</th>
            </tr>
            <tr>
                <th>供货商收款银行</th>
                <th class="font-normal bg-white" colspan="2">{{$purchase->bank}}</th>
            </tr>
            <tr>
                <th>供货商收款银行</th>
                <th class="font-normal bg-white" colspan="2">{{$purchase->account}}</th>
            </tr>
            <tr>
                <th>采购金额</th>
                <th colspan="3" class="font-normal bg-white">{{$purchase->lists()->sum('price')}} ￥</th>
            </tr>
            <tr>
                <th>项目编号</th>
                <th colspan="3" class="font-normal bg-white">{{\App\Models\Project::find($purchase->project_id)->number}}</th>
            </tr>
            <tr>
                <th>项目内容</th>
                <th colspan="3" class="font-normal bg-white">{{\App\Models\Project::find($purchase->project_id)->name}}</th>
            </tr>
            <tr>
                <th>发票条件</th>
                <th colspan="3" class="font-normal bg-white">专用票17%</th>
            </tr>
            <tr>
                <th>付款条件</th>
                <th colspan="3" class="font-normal bg-white">付款条件一</th>
            </tr>
            </thead>
        </table>


        <h4 class="ui dividing header blue">采购物料清单</h4>
        <div class="table-head-nowrap">
            <table class="ui celled center aligned table selectable unstackable">
                <thead>
                <tr>
                    <th>物料名称</th>
                    <th>性能及技术参数</th>
                    <th>品牌型号</th>
                    <th>生产厂家</th>
                    <th>单位</th>
                    <th>预算单价</th>
                    <th>预算数量</th>
                    <th>已采购数量</th>
                    <th>剩余未采购数量</th>
                    <th>本次采购数量</th>
                    <th>本次采购单价</th>
                    <th>本次采购金额 </th>
                    <th>保修截止日期</th>
                    <th>保修时间</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>物料一</td>
                    <td>性能xxx参数xxx</td>
                    <td>ak-47</td>
                    <td>xxx厂家</td>
                    <td>个</td>
                    <td>123 ￥</td>
                    <td>23,231</td>
                    <td>20,000</td>
                    <td>3,000</td>
                    <td>2,000</td>
                    <td>200 ￥</td>
                    <td>523,523 ￥</td>
                    <td>2018-03-06</td>
                    <td>30 天</td>
                </tr>
                <tr>
                    <td>物料三</td>
                    <td>性能xxx参数xxx性能xxx参数xxx</td>
                    <td>ak-47</td>
                    <td>xxx厂家</td>
                    <td>个</td>
                    <td>123 ￥</td>
                    <td>23,231</td>
                    <td>20,000</td>
                    <td>3,000</td>
                    <td>2,000</td>
                    <td>200 ￥</td>
                    <td>523,523 ￥</td>
                    <td>2018-03-06</td>
                    <td>30 天</td>
                </tr>
                </tbody>
            </table>
        </div>

        <div class="flex-row flex-center margin-top-50">
            <a class="ui icon button primary" href="#" style="margin:0 10px;">
                <i class="icon edit"></i>
                <span>修改</span>
            </a>
            <button class="ui icon button primary" id="budgetaryCheckRecheck" style="margin:0 10px;">
                <i class="icon legal"></i>
                <span>复核</span>
            </button>
            <a class="ui icon button primary" href="#" style="margin:0 10px;">
                <i class="icon write"></i>
                <span>审批</span>
            </a>
            <a class="ui icon button green" href="javascript:_helper.fullWindow('../buy/budgetary_print.html')" style="margin:0 10px;">
                <i class="icon print"></i>
                <span>凭证</span>
            </a>
        </div>

        <div class="ui page dimmer" id="budgetaryCheck">
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
    <!-- /主体内容 === 不可复用 -->

@endsection
@section('pageJs')
    <script src="{{url('js/buy_budgetary_check.js')}}"></script>
@endsection