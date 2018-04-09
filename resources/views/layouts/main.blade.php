<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- 全局依赖 ==== 所有页面都要有 -->
    <script src="{{url('plugins/jquery/jquery.3.2.1.min.js')}}"></script>
    <script src="{{url('layer/layer.js')}}"></script>
    <link rel="stylesheet" type="text/css" href="{{url('plugins/semantic/semantic.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{url('plugins/element-ui/index.css')}}">
    <!-- <link rel="stylesheet" href="../../plugins/nprogress/nprogress.css"> -->
    <link rel="stylesheet" type="text/css" href="{{url('css/erp.css')}}">
    <!-- /全局依赖 -->

    <title>@yield('title')</title>
</head>

<body>
<!-- 通用布局 === 复用 -->
<div class="index-navbar ui menu blue-background print-hide">
    <span id="sidebarBtn" class="index-navbar-item-left pull-left">
      <i class="sidebar icon"></i>
      <span>森乾科技</span>
    </span>
    <div class="index-navbar-item-show right menu">
        <a class="item">
            <i class="user icon"></i>
            <span>{{\Illuminate\Support\Facades\Auth::user()->name}}</span>
        </a>
        <a class="item">
            <i class="help circle icon"></i>
            <span>帮助</span>
        </a>
        <a class="item">
            <i class="sound icon"></i>
            <span>客服</span>
        </a>
        <a class="item">
            <i class="power icon"></i>
            <span>退出</span>
        </a>
    </div>
    <div class="index-navbar-item-hidden margin-right ui dropdown">操作
        <i class="dropdown icon"></i>
        <div class="menu">
            <a class="item" href="#">
                <i class="user icon"></i>
                <span>管理员</span>
            </a>
            <a class="item">
                <i class="help circle icon"></i>
                <span>帮助</span>
            </a>
            <a class="item">
                <i class="sound icon"></i>
                <span>客服</span>
            </a>
            <a class="item">
                <i class="power icon"></i>
                <span>退出</span>
            </a>
        </div>
    </div>
</div>
<div class="index-aside invisible print-hide" id="navbar">
    <el-menu :unique-opened="true" :default-active="navActive" class="el-menu-vertical-demo">
        <el-menu-item index="index" style="padding:0;">
            <a href="{{url('')}}" slot="title" style="padding-left:20px">
                <i class="icon home"></i>
                <span>首页</span>
            </a>
        </el-menu-item>
        <el-submenu index="project">
            <template slot="title">
                <i class="icon sticky note"></i>
                <span>项目立项管理</span>
            </template>
            <el-menu-item index="projectDetail">
                <a href="{{url('project/detail')}}">项目明细清单</a>
            </el-menu-item>
            <el-menu-item index="projectList">
                <a href="{{url('project/list')}}">已立项清单</a>
            </el-menu-item>
        </el-submenu>
        <el-submenu index="budget">
            <template slot="title">
                <i class="icon hashtag"></i>
                <span>预算管理</span>
            </template>
            <el-menu-item index="budgetList">
                <a href="{{url('budget/list')}}">预算清单</a>
            </el-menu-item>
        </el-submenu>
        <el-submenu index="check">
            <template slot="title">
                <i class="icon suitcase"></i>
                <span>验收与收款管理</span>
            </template>
            <el-menu-item index="checkCheck">
                <a href="{{url('check/list')}}">验收与收款清单</a>
            </el-menu-item>
            <el-menu-item index="checkTips">
                <a href="{{url('check/tips')}}">收款提示</a>
            </el-menu-item>
        </el-submenu>
        <el-submenu index="buy">
            <template slot="title">
                <i class="icon shopping basket"></i>
                <span>采购管理</span>
            </template>
            <el-menu-item index="buyList">
                <a href="{{url('purchases/list')}}">采购清单</a>
            </el-menu-item>
            <el-menu-item index="buyProjectList">
                <a href="{{url('project/purchases/list')}}">采购立项清单</a>
            </el-menu-item>
            <el-menu-item index="buyPayList">
                <a href="{{url('purchase/pay/list')}}">采购付款清单</a>
            </el-menu-item>
            <el-menu-item index="buyChargeList">
                <a href="{{url('purchase/charge/list')}}">采购收票清单</a>
            </el-menu-item>
            <el-menu-item index="buyCollect">
                <a href="{{url('purchase/collect/list')}}">采购汇总清单</a>
            </el-menu-item>
            <el-menu-item index="buyParity">
                <a href="{{url('purchase/parity/list')}}">物料采购比价</a>
            </el-menu-item>
        </el-submenu>
        <el-submenu index="stock">
            <template slot="title">
                <i class="icon archive"></i>
                <span>库存管理</span>
            </template>
            <el-menu-item index="stockList">
                <a href="../stock/list.html">库存清单</a>
            </el-menu-item>
            <el-menu-item index="stockBuyList">
                <a href="../stock/buy_list.html">采购收货清单</a>
            </el-menu-item>
            <el-menu-item index="stockReturnList">
                <a href="../stock/return_list.html">退料入库清单</a>
            </el-menu-item>
            <el-menu-item index="stockGetList">
                <a href="../stock/get_list.html">领料出库清单</a>
            </el-menu-item>
            <el-menu-item index="stockOutList">
                <a href="../stock/out_list.html">退货出库清单</a>
            </el-menu-item>
        </el-submenu>
        <el-submenu index="build">
            <template slot="title">
                <i class="icon legal"></i>
                <span>施工管理</span>
            </template>
            <el-menu-item index="buildList">
                <a href="../build/list.html">施工费清单</a>
            </el-menu-item>
            <el-menu-item index="buildDealList">
                <a href="../build/deal_list.html">备案合同清单</a>
            </el-menu-item>
            <el-menu-item index="buildFinishList">
                <a href="../build/finish_list.html">完工请款清单</a>
            </el-menu-item>
            <el-menu-item index="buildPayList">
                <a href="../build/pay_list.html">施工付款清单</a>
            </el-menu-item>
            <el-menu-item index="buildGetList">
                <a href="../build/get_list.html">施工收票清单</a>
            </el-menu-item>
        </el-submenu>
        <el-submenu index="loan">
            <template slot="title">
                <i class="icon ordered list"></i>
                <span>报销与借款管理</span>
            </template>
            <el-menu-item index="loanList">
                <a href="../loan/list.html">报销与借款清单</a>
            </el-menu-item>
            <el-menu-item index="loanDetailList">
                <a href="../loan/detail_list.html">查询明细</a>
            </el-menu-item>
            <el-menu-item index="loanLoanList">
                <a href="../loan/loan_list.html">借款清单</a>
            </el-menu-item>
            <el-menu-item index="loanSubmitList">
                <a href="../loan/submit_list.html">报销申请清单</a>
            </el-menu-item>
            <el-menu-item index="loanPayList">
                <a href="../loan/pay_list.html">报销付款清单</a>
            </el-menu-item>
        </el-submenu>
        <el-submenu index="pay">
            <template slot="title">
                <i class="icon yen"></i>
                <span>费用付款管理</span>
            </template>
            <el-menu-item index="payList">
                <a href="../pay/list.html">付款审批清单</a>
            </el-menu-item>
        </el-submenu>
        <el-submenu index="data">
            <template slot="title">
                <i class="icon database"></i>
                <span>数据维护</span>
            </template>
            <el-menu-item index="dataAuth">
                <a href="{{url('user/list')}}">人员权限</a>
            </el-menu-item>
            <el-menu-item index="dataType">
                <a href="{{url('project/types/list')}}">项目类别</a>
            </el-menu-item>
            <el-menu-item index="dataSupplier">
                <a href="{{url('supplier/list')}}">供应商</a>
            </el-menu-item>
            <el-menu-item index="dataMateriel">
                <a href="{{url('material/list')}}">物料</a>
            </el-menu-item>
            <el-menu-item index="dataWarehouse">
                <a href="{{url('warehouse/list')}}">仓库</a>
            </el-menu-item>
            <el-menu-item index="dataBank">
                <a href="{{url('bank/list')}}">银行账户</a>
            </el-menu-item>
            <el-menu-item index="dataInvoice">
                <a href="{{url('invoice/list')}}">发票类型</a>
            </el-menu-item>
            <el-menu-item index="dataTeam">
                <a href="{{url('team/list')}}">施工队</a>
            </el-menu-item>
            <el-menu-item index="dataPayment">
                <a href="{{url('project/types/list')}}">报销费用类型</a>
            </el-menu-item>
        </el-submenu>
    </el-menu>
</div>
<!-- /通用布局 -->

<!-- 主体内容 === 不可复用 -->
@yield('content')
<!-- /主体内容 === 不可复用 -->

<!-- 全局依赖 js === 通用 -->

<script src="{{url('plugins/vue/vue.min.js')}}"></script>
<script src="{{url('plugins/semantic/semantic.min.js')}}"></script>
<script src="{{url('plugins/element-ui/index.min.js')}}"></script>
<!-- <script src="../../plugins/lodash/lodash.min.js"></script> -->
<script src="{{url('plugins/axios/axios.min.js')}}"></script>
<script src="{{url('plugins/axios/qs.min.js')}}"></script>
<!-- <script src="../../plugins/nprogress/nprogress.js"></script> -->
<!-- <script src="../../plugins/layDate/laydate.js"></script> -->
<script src="{{url('src/js/helper.js')}}"></script>
<script src="{{url('src/js/api.js')}}"></script>
<script src="{{url('src/js/schema.js')}}"></script>
<script src="{{url('src/js/global.js')}}"></script>
<!-- / 全局依赖 js === 通用 -->
<!-- 独立 js -->
@yield('pageJs')
<!-- / 独立 js -->
</body>

</html>