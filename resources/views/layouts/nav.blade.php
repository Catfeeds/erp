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
                <a href="{{url('stock/list')}}">库存清单</a>
            </el-menu-item>
            <el-menu-item index="stockBuyList">
                <a href="{{url('stock/buy/list')}}">采购收货清单</a>
            </el-menu-item>
            <el-menu-item index="stockReturnList">
                <a href="{{url('stock/return/list')}}">退料入库清单</a>
            </el-menu-item>
            <el-menu-item index="stockGetList">
                <a href="{{url('stock/get/list')}}">领料出库清单</a>
            </el-menu-item>
            <el-menu-item index="stockOutList">
                <a href="{{url('stock/out/list')}}">退货出库清单</a>
            </el-menu-item>
        </el-submenu>
        <el-submenu index="build">
            <template slot="title">
                <i class="icon legal"></i>
                <span>施工管理</span>
            </template>
            <el-menu-item index="buildList">
                <a href="{{url('build/list')}}">施工费清单</a>
            </el-menu-item>
            <el-menu-item index="buildDealList">
                <a href="{{url('build/deal/list')}}">备案合同清单</a>
            </el-menu-item>
            <el-menu-item index="buildFinishList">
                <a href="{{url('build/finish/list')}}">完工请款清单</a>
            </el-menu-item>
            <el-menu-item index="buildPayList">
                <a href="{{url('build/pay/list')}}">施工付款清单</a>
            </el-menu-item>
            <el-menu-item index="buildGetList">
                <a href="{{url('build/get/list')}}">施工收票清单</a>
            </el-menu-item>
        </el-submenu>
        <el-submenu index="loan">
            <template slot="title">
                <i class="icon ordered list"></i>
                <span>报销与借款管理</span>
            </template>
            <el-menu-item index="loanList">
                <a href="{{url('loan/list')}}">报销与借款清单</a>
            </el-menu-item>
            {{--<el-menu-item index="loanDetailList">--}}
            {{--<a href="{{url('loan/detail/list')}}">查询明细</a>--}}
            {{--</el-menu-item>--}}
            <el-menu-item index="loanLoanList">
                <a href="{{url('loan/loan/list')}}">借款清单</a>
            </el-menu-item>
            <el-menu-item index="loanSubmitList">
                <a href="{{url('loan/submit/list')}}">报销申请清单</a>
            </el-menu-item>
            <el-menu-item index="loanPayList">
                <a href="{{url('loan/pay/list')}}">报销付款清单</a>
            </el-menu-item>
        </el-submenu>
        <el-submenu index="pay">
            <template slot="title">
                <i class="icon yen"></i>
                <span>费用付款管理</span>
            </template>
            <el-menu-item index="payList">
                <a href="{{url('pay/list')}}">付款审批清单</a>
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
                <a href="{{url('category/list')}}">报销费用类型</a>
            </el-menu-item>
        </el-submenu>
    </el-menu>
</div>