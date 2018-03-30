<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    @include('layouts.header')

    <title>{{isset($title)?$title:'Erp'}}</title>
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
            <a href="../index/index.html" slot="title" style="padding-left:20px">
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
                <a href="../project/detail.html">项目明细清单</a>
            </el-menu-item>
            <el-menu-item index="projectList">
                <a href="../project/list.html">已立项清单</a>
            </el-menu-item>
        </el-submenu>
        <el-submenu index="budget">
            <template slot="title">
                <i class="icon hashtag"></i>
                <span>预算管理</span>
            </template>
            <el-menu-item index="budgetList">
                <a href="../budget/list">预算清单</a>
            </el-menu-item>
        </el-submenu>
        <el-submenu index="check">
            <template slot="title">
                <i class="icon suitcase"></i>
                <span>验收与收款管理</span>
            </template>
            <el-menu-item index="checkCheck">
                <a href="../check/list.html">验收与收款清单</a>
            </el-menu-item>
            <el-menu-item index="checkTips">
                <a href="../check/tips.html">收款提示</a>
            </el-menu-item>
        </el-submenu>
        <el-submenu index="buy">
            <template slot="title">
                <i class="icon shopping basket"></i>
                <span>采购管理</span>
            </template>
            <el-menu-item index="buyList">
                <a href="../buy/list.html">采购清单</a>
            </el-menu-item>
            <el-menu-item index="buyProjectList">
                <a href="../buy/project_list.html">采购立项清单</a>
            </el-menu-item>
            <el-menu-item index="buyPayList">
                <a href="#">采购付款清单</a>
            </el-menu-item>
            <el-menu-item index="buyChargeList">
                <a href="#">采购收票清单</a>
            </el-menu-item>
            <el-menu-item index="buyCollect">
                <a href="../buy/collect.html">采购汇总清单</a>
            </el-menu-item>
            <el-menu-item index="buyParity">
                <a href="../buy/parity.html">物料采购比价</a>
            </el-menu-item>
        </el-submenu>
        <el-submenu index="stock">
            <template slot="title">
                <i class="icon archive"></i>
                <span>库存管理</span>
            </template>
            <el-menu-item index="stockList">
                <a href="#">库存清单</a>
            </el-menu-item>
            <el-menu-item index="stockBuyList">
                <a href="#">采购收货清单</a>
            </el-menu-item>
            <el-menu-item index="stockReturnList">
                <a href="#">退料入货清单</a>
            </el-menu-item>
            <el-menu-item index="stockGetList">
                <a href="#">领料出货清单</a>
            </el-menu-item>
        </el-submenu>
        <el-submenu index="build">
            <template slot="title">
                <i class="icon legal"></i>
                <span>施工管理</span>
            </template>
            <el-menu-item index="buildList">
                <a href="#">施工费清单</a>
            </el-menu-item>
            <el-menu-item index="buildDealList">
                <a href="#">备案合同清单</a>
            </el-menu-item>
            <el-menu-item index="buildFinishList">
                <a href="#">完工请款清单</a>
            </el-menu-item>
            <el-menu-item index="buildPayList">
                <a href="#">施工付款清单</a>
            </el-menu-item>
            <el-menu-item index="buildGetList">
                <a href="#">施工收票清单</a>
            </el-menu-item>
        </el-submenu>
        <el-submenu index="loan">
            <template slot="title">
                <i class="icon ordered list"></i>
                <span>报销与借款管理</span>
            </template>
            <el-menu-item index="loanList">
                <a href="#">报销与借款清单</a>
            </el-menu-item>
        </el-submenu>
        <el-submenu index="pay">
            <template slot="title">
                <i class="icon yen"></i>
                <span>费用付款管理</span>
            </template>
            <el-menu-item index="payList">
                <a href="#">付款审批清单</a>
            </el-menu-item>
        </el-submenu>
        <el-submenu index="data">
            <template slot="title">
                <i class="icon database"></i>
                <span>数据维护</span>
            </template>
            <el-menu-item index="dataAuth">
                <a href="#">人员权限</a>
            </el-menu-item>
            <el-menu-item index="dataSupplier">
                <a href="#">供应商</a>
            </el-menu-item>
            <el-menu-item index="dataMateriel">
                <a href="#">物料</a>
            </el-menu-item>
            <el-menu-item index="dataWarehouse">
                <a href="#">仓库</a>
            </el-menu-item>
            <el-menu-item index="dataBank">
                <a href="#">银行账户</a>
            </el-menu-item>
            <el-menu-item index="dataTeam">
                <a href="#">施工队</a>
            </el-menu-item>
            <el-menu-item index="dataPayment">
                <a href="#">报销费用类型</a>
            </el-menu-item>
        </el-submenu>
    </el-menu>
</div>
<!-- /通用布局 -->

<!-- 主体内容 === 不可复用 -->
<div class="index-content print-no-padding">