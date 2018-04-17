@extends('layouts.main')
@section('title','已立项清单')
@section('content')
    <!-- 没有导航的单独窗口页面 -->
    <div class="normal-content print-no-padding">

        <div class="ui breadcrumb">
            <a class="section">数据维护</a>
            <div class="divider"> / </div>
            <a class="section" href="../data/bank_list.html">人员列表</a>
            <div class="divider"> / </div>
            <div class="active section">权限编辑 - 陈巧笑</div>
        </div>
        <h4 class="ui header">操作人员：
            <span class="font-normal">陈巧笑</span>
        </h4>
        <form action="" method="POST">
            <div class="table-head-nowrap">
                <table class="ui celled structured table unstackable center aligned">
                    <thead>
                    <tr>
                        <th></th>
                        <th>十个模块</th>
                        <th>操作细项</th>
                        <th colspan="3">操作子项</th>
                        <th>操作人权限</th>
                    </tr>
                    </thead>
                    <tbody>

                    <!-- 第一栏 -->
                    <tr>
                        <td rowspan="3">1</td>
                        <td rowspan="3">查询项目明细</td>
                        <td rowspan="3"></td>
                        <td colspan="3" rowspan="3"></td>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="all" name="project_detail">
                                <label>可全部查看</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="any" name="project_detail">
                                <label>指定项目查看</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="off" name="project_detail">
                                <label>无此权限</label>
                            </div>
                        </td>
                    </tr>
                    <!-- / 第一栏 -->



                    <!-- 第二栏 -->
                    <tr>
                        <td rowspan="5">2</td>
                        <td rowspan="5">项目立项</td>
                        <td rowspan="3">已立项项目清单</td>
                        <td colspan="3" rowspan="3"></td>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="all" name="project_list">
                                <label>可全部查看</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="any" name="project_list">
                                <label>指定项目查看</label>
                            </div>
                        </td>
                        <span class="fake-a authCheck"></span>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="off" name="project_list">
                                <label>无此权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="2">新增立项录入与修改</td>
                        <td colspan="3" rowspan="2"></td>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="all" name="project_edit">
                                <label>有此权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="off" name="project_edit">
                                <label>无此权限</label>
                            </div>
                        </td>
                    </tr>
                    <!-- / 第二栏 -->

                    <!-- 第三栏 -->
                    <tr>
                        <td rowspan="6">3</td>
                        <td rowspan="6">预算管理</td>
                        <td rowspan="3">预算管理清单</td>
                        <td rowspan="3" colspan="3"></td>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="all" name="budget_list">
                                <label>可全部查看</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="any" name="budget_list">
                                <label>指定项目查看</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="off" name="budget_list">
                                <label>无此权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="3">录入与修改预算清单</td>
                        <td colspan="3" rowspan="3"></td>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="all" name="budget_edit">
                                <label>所有项目有权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="any" name="budget_edit">
                                <label>指定项目有权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="off" name="budget_edit">
                                <label>无此权限</label>
                            </div>
                        </td>
                    </tr>
                    <!-- / 第三栏 -->

                    <!-- 第四栏 -->
                    <tr>
                        <td rowspan="29">4</td>
                        <td rowspan="29">验收与收款管理</td>
                        <td rowspan="3">验收与收款清单</td>
                        <td rowspan="3" colspan="3"></td>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="all" name="check_list">
                                <label>可全部查看</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="any" name="check_list">
                                <label>指定项目查看</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="off" name="check_list">
                                <label>无此权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="2">收款提示查询</td>
                        <td colspan="3" rowspan="2"></td>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="all" name="check_tip">
                                <label>有此权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="off" name="check_tip">
                                <label>无此权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="3">验收操作</td>
                        <td colspan="3" rowspan="3"></td>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="all" name="check_operate">
                                <label>所有项目有次权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="any" name="check_operate">
                                <label>指定项目有此权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="off" name="check_operate">
                                <label>无此权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="6">收款提示录入</td>
                        <td rowspan="3">预计收回履约保证金</td>
                        <td colspan="2" rowspan="3"></td>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="all" name="check_tip_eidt_margins">
                                <label>所有项目有权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="any" name="check_tip_eidt_margins">
                                <label>指定项目有此权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="off" name="check_tip_eidt_margins">
                                <label>无此权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="3">预计请款</td>
                        <td colspan="2" rowspan="3"></td>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="all" name="check_tip_eidt_money">
                                <label>所有项目有权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="any" name="check_tip_eidt_money">
                                <label>指定项目有此权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="off" name="check_tip_eidt_money">
                                <label>无此权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="3">开票录入</td>
                        <td colspan="3" rowspan="3"></td>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="all" name="check_invoice">
                                <label>所有项目有权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="any" name="check_invoice">
                                <label>指定项目有此权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="off" name="check_invoice">
                                <label>无此权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="12">收款录入</td>
                        <td rowspan="3">收回履约保证金</td>
                        <td colspan="2" rowspan="3"></td>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="all" name="check_get_margins">
                                <label>所有项目有权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="any" name="check_get_margins">
                                <label>指定项目有此权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="off" name="check_get_margins">
                                <label>无此权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="3">主合同收款</td>
                        <td colspan="2" rowspan="3"></td>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="all" name="check_get_master">
                                <label>所有项目有权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="any" name="check_get_master">
                                <label>指定项目有此权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="off" name="check_get_master">
                                <label>无此权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="3">分包合同收款</td>
                        <td colspan="2" rowspan="3"></td>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="all" name="check_get_sub">
                                <label>所有项目有权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="any" name="check_get_sub">
                                <label>指定项目有此权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="off" name="check_get_sub">
                                <label>无此权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="3">发包公司收款</td>
                        <td colspan="2" rowspan="3"></td>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="all" name="check_get_divide">
                                <label>所有项目有权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="any" name="check_get_divide">
                                <label>指定项目有此权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="off" name="check_get_divide">
                                <label>无此权限</label>
                            </div>
                        </td>
                    </tr>
                    <!-- / 第四栏 -->

                    <!-- 第五栏 -->
                    <tr>
                        <td rowspan="37">5</td>
                        <td rowspan="37">采购管理</td>
                        <td rowspan="3">采购清单</td>
                        <td colspan="3" rowspan="3"></td>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="all" name="buy_list">
                                <label>可全部查看</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="any" name="buy_list">
                                <label>指定项目查看</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="off" name="buy_list">
                                <label>无此权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="3">项目采购物料清单</td>
                        <td rowspan="3" colspan="3"></td>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="all" name="buy_whole_list">
                                <label>可全部查看</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="any" name="buy_whole_list">
                                <label>指定项目查看</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="off" name="buy_whole_list">
                                <label>无此权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="2">物料采购比价</td>
                        <td rowspan="2" colspan="3"></td>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="all" name="buy_parity">
                                <label>有此权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="off" name="buy_parity">
                                <label>无此权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="15">采购立项</td>
                        <td rowspan="3">采购立项清单</td>
                        <td colspan="2" rowspan="3"></td>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="all" name="buy_project_list">
                                <label>可全部查看</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="any" name="buy_project_list">
                                <label>指定项目查看</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="off" name="buy_project_list">
                                <label>无此权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="12">新增立项</td>
                        <td rowspan="6">预算内采购</td>
                        <td rowspan="2">录入、修改、凭证</td>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="all" name="buy_bugetary_edit">
                                <label>有此权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="off" name="buy_bugetary_edit">
                                <label>无此权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="2">复核</td>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="all" name="buy_bugetary_check">
                                <label>有此权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="off" name="buy_bugetary_check">
                                <label>无此权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="2">审批</td>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="all" name="buy_bugetary_pass">
                                <label>有此权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="off" name="buy_bugetary_pass">
                                <label>无此权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="6">预算外采购</td>
                        <td rowspan="2">录入、修改、凭证</td>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="all" name="buy_extrabugetary_edit">
                                <label>有此权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="off" name="buy_extrabugetary_edit">
                                <label>无此权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="2">复核</td>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="all" name="buy_extrabugetary_check">
                                <label>有此权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="off" name="buy_extrabugetary_check">
                                <label>无此权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="2">审批</td>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="all" name="buy_extrabugetary_pass">
                                <label>有此权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="off" name="buy_extrabugetary_pass">
                                <label>无此权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="9">采购付款</td>
                        <td rowspan="3">采购付款清单</td>
                        <td rowspan="3" colspan="2"></td>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="all" name="buy_pay_list">
                                <label>可全部查看</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="any" name="buy_pay_list">
                                <label>指定项目查看</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="off" name="buy_pay_list">
                                <label>无此权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="2">采购付款申请、修改、凭证</td>
                        <td colspan="2" rowspan="2"></td>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="all" name="buy_pay_edit">
                                <label>有此权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="off" name="buy_pay_edit">
                                <label>无此权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="2">采购付款复核</td>
                        <td colspan="2" rowspan="2"></td>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="all" name="buy_pay_pass">
                                <label>有此权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="off" name="buy_pay_pass">
                                <label>无此权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="2">录入采购付款信息</td>
                        <td colspan="2" rowspan="2"></td>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="all" name="buy_pay_add">
                                <label>有此权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="off" name="buy_pay_add">
                                <label>无此权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="5">采购收票</td>
                        <td rowspan="3">采购收票清单</td>
                        <td colspan="2" rowspan="3"></td>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="all" name="buy_invoice_list">
                                <label>可全部查看</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="any" name="buy_invoice_list">
                                <label>指定项目查看</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="off" name="buy_invoice_list">
                                <label>无此权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="2">采购收票录入、修改、凭证</td>
                        <td colspan="2" rowspan="2"></td>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="all" name="buy_invoice_edit">
                                <label>有此权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="off" name="buy_invoice_edit">
                                <label>无此权限</label>
                            </div>
                        </td>
                    </tr>
                    <!-- / 第五栏 -->

                    <!-- 第六栏 -->
                    <tr>
                        <td rowspan="26">6</td>
                        <td rowspan="26">库存管理</td>
                        <td rowspan="2">库存清单</td>
                        <td colspan="3" rowspan="2"></td>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="all" name="stock_list">
                                <label>有此权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="off" name="stock_list">
                                <label>无此权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="2">查询出入库记录</td>
                        <td colspan="3" rowspan="2"></td>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="all" name="stock_record_list">
                                <label>有此权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="off" name="stock_record_list">
                                <label>无此权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="5">采购收货入库</td>
                        <td rowspan="3">采购收货入库清单</td>
                        <td colspan="2" rowspan="3"></td>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="all" name="stock_buy_list">
                                <label>可全部查看</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="any" name="stock_buy_list">
                                <label>指定项目查看</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="off" name="stock_buy_list">
                                <label>无此权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="2">采购收货入库操作</td>
                        <td colspan="2" rowspan="2"></td>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="all" name="stock_buy_edit">
                                <label>有此权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="off" name="stock_buy_edit">
                                <label>无此权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="6">退料入库</td>
                        <td rowspan="3">退料入库清单</td>
                        <td colspan="2" rowspan="3"></td>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="all" name="stock_return_list">
                                <label>可全部查看</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="any" name="stock_return_list">
                                <label>指定项目查看</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="off" name="stock_return_list">
                                <label>无此权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="3">新增退料入库</td>
                        <td colspan="2" rowspan="3"></td>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="all" name="stock_return_edit">
                                <label>可全部查看</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="any" name="stock_return_edit">
                                <label>指定项目查看</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="off" name="stock_return_edit">
                                <label>无此权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="6">领料出库</td>
                        <td rowspan="3">领料出库清单</td>
                        <td colspan="2" rowspan="3"></td>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="all" name="stock_get_list">
                                <label>可全部查看</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="any" name="stock_get_list">
                                <label>指定项目查看</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="off" name="stock_get_list">
                                <label>无此权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="3">新增领料出库</td>
                        <td colspan="2" rowspan="3"></td>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="all" name="stock_get_edit">
                                <label>可全部查看</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="any" name="stock_get_edit">
                                <label>指定项目查看</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="off" name="stock_get_edit">
                                <label>无此权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="5">退货出库</td>
                        <td rowspan="3">退货出库清单</td>
                        <td colspan="2" rowspan="3"></td>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="all" name="stock_out_list">
                                <label>可全部查看</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="any" name="stock_out_list">
                                <label>指定项目查看</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="off" name="stock_out_list">
                                <label>无此权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="2">新增退货出库</td>
                        <td colspan="2" rowspan="2"></td>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="all" name="stock_out_edit">
                                <label>有此权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="off" name="stock_out_edit">
                                <label>无此权限</label>
                            </div>
                        </td>
                    </tr>
                    <!-- / 第六栏 -->

                    <!-- 第七栏 -->
                    <tr>
                        <td rowspan="34">7</td>
                        <td rowspan="34">施工管理</td>
                        <td rowspan="3">施工费清单</td>
                        <td colspan="3" rowspan="3"></td>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="all" name="build_list">
                                <label>可全部查看</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="any" name="build_list">
                                <label>指定项目查看</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="off" name="build_list">
                                <label>无此权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="6">施工合同备案</td>
                        <td rowspan="3">备案合同清单</td>
                        <td colspan="2" rowspan="3"></td>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="all" name="build_contract_list">
                                <label>可全部查看</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="any" name="build_contract_list">
                                <label>指定项目查看</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="off" name="build_contract_list">
                                <label>无此权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="3">录入合同</td>
                        <td colspan="2" rowspan="3"></td>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="all" name="build_contract_edit">
                                <label>可全部查看</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="any" name="build_contract_edit">
                                <label>指定项目查看</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="off" name="build_contract_edit">
                                <label>无此权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="11">完工请款</td>
                        <td rowspan="3">完工请款清单</td>
                        <td colspan="2" rowspan="3"></td>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="all" name="build_finish_list">
                                <label>可全部查看</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="any" name="build_finish_list">
                                <label>指定项目查看</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="off" name="build_finish_list">
                                <label>无此权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="3">完工请款录入、修改、凭证</td>
                        <td colspan="2" rowspan="3"></td>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="all" name="build_finish_edit">
                                <label>可全部查看</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="any" name="build_finish_edit">
                                <label>指定项目查看</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="off" name="build_finish_edit">
                                <label>无此权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="3">完工请款复核</td>
                        <td colspan="2" rowspan="3"></td>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="all" name="build_finish_check">
                                <label>所有项目有权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="any" name="build_finish_check">
                                <label>指定项目有权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="off" name="build_finish_check">
                                <label>无此权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="2">完工请款审批</td>
                        <td colspan="2" rowspan="2"></td>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="all" name="build_finish_pass">
                                <label>有此权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="off" name="build_finish_pass">
                                <label>无此权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="9">施工付款</td>
                        <td rowspan="3">施工付款清单</td>
                        <td rowspan="3" colspan="2"></td>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="all" name="build_pay_list">
                                <label>可全部查看</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="any" name="build_pay_list">
                                <label>指定项目查看</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="off" name="build_pay_list">
                                <label>无此权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="2">付款申请录入、修改、凭证</td>
                        <td colspan="2" rowspan="2"></td>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="all" name="build_pay_edit">
                                <label>有此权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="off" name="build_pay_edit">
                                <label>无此权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="2">付款申请复核</td>
                        <td colspan="2" rowspan="2"></td>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="all" name="build_pay_check">
                                <label>有此权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="off" name="build_pay_check">
                                <label>无此权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="2">付款申请审批</td>
                        <td colspan="2" rowspan="2"></td>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="all" name="build_pay_pass">
                                <label>有此权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="off" name="build_pay_pass">
                                <label>无此权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="5">施工收票</td>
                        <td rowspan="3">施工收票清单</td>
                        <td colspan="2" rowspan="3"></td>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="all" name="build_invoice_list">
                                <label>可全部查看</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="any" name="build_invoice_list">
                                <label>指定项目查看</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="off" name="build_invoice_list">
                                <label>无此权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="2">施工收票录入、修改、凭证</td>
                        <td colspan="2" rowspan="2"></td>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="off" name="build_invoice_edit">
                                <label>有此权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="off" name="build_invoice_edit">
                                <label>无此权限</label>
                            </div>
                        </td>
                    </tr>
                    <!-- / 第七栏 -->

                    <!-- 第八栏 -->
                    <tr>
                        <td rowspan="32">8</td>
                        <td rowspan="32">报销与借款</td>
                        <td rowspan="2">报销与借款清单</td>
                        <td colspan="3" rowspan="2"></td>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="all" name="loan_list">
                                <label>可查看全部人员</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="only" name="loan_list">
                                <label>只能查看本人</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="2">查询明细</td>
                        <td colspan="3" rowspan="2"></td>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="all" name="loan_detail">
                                <label>可查看全部人员</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="only" name="loan_detail">
                                <label>只能查看本人</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="8">借款</td>
                        <td rowspan="2">借款清单</td>
                        <td colspan="2" rowspan="2"></td>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="all" name="loan_loan_list">
                                <label>可查看全部人员</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="only" name="loan_loan_list">
                                <label>只能查看本人</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="2">新增借款申请</td>
                        <td colspan="2" rowspan="2"></td>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="all" name="loan_loan_add">
                                <label>有此权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="off" name="loan_loan_add">
                                <label>无此权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="2">借款申请审批</td>
                        <td colspan="2" rowspan="2"></td>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="all" name="loan_loan_pass">
                                <label>有此权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="off" name="loan_loan_pass">
                                <label>无此权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="2">借款付款操作</td>
                        <td colspan="2" rowspan="2"></td>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="all" name="loan_loan_operate">
                                <label>有此权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="off" name="loan_loan_operate">
                                <label>无此权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="16">报销申请</td>
                        <td rowspan="3">报销清单</td>
                        <td colspan="2" rowspan="3"></td>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="all" name="loan_submit_list">
                                <label>可全部查看</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="only" name="loan_submit_list">
                                <label>可查看本人所有记录</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="any" name="loan_submit_list">
                                <label>可查看指定项目和空白项目</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="6">期间费用报销</td>
                        <td rowspan="2">报销申请录入、修改、凭证</td>
                        <td rowspan="2"></td>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="all" name="loan_submit_edit">
                                <label>有此权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="off" name="loan_submit_edit">
                                <label>无此权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="2">报销复核</td>
                        <td rowspan="2"></td>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="all" name="loan_submit_check">
                                <label>有此权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="off" name="loan_submit_check">
                                <label>无此权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="2">报销审批</td>
                        <td rowspan="2"></td>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="all" name="loan_submit_pass">
                                <label>有此权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="off" name="loan_submit_pass">
                                <label>无此权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="7">项目成本报销</td>
                        <td rowspan="3">报销申请录入、修改、凭证</td>
                        <td rowspan="3"></td>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="all" name="loan_project_submit_edit">
                                <label>所有项目报销</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="any" name="loan_project_submit_edit">
                                <label>指定项目报销</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="off" name="loan_project_submit_edit">
                                <label>无此权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="2">报销复核</td>
                        <td rowspan="2"></td>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="all" name="loan_project_submit_check">
                                <label>有此权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="off" name="loan_project_submit_check">
                                <label>无此权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="2">报销审批</td>
                        <td rowspan="2"></td>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="all" name="loan_project_submit_pass">
                                <label>有此权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="off" name="loan_project_submit_pass">
                                <label>无此权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="4">报销付款</td>
                        <td rowspan="2">报销付款清单</td>
                        <td colspan="2" rowspan="2"></td>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="all" name="loan_pay_list">
                                <label>可查看全部人员</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="only" name="loan_pay_list">
                                <label>只查看本人</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="2">新增报销付款</td>
                        <td colspan="2" rowspan="2"></td>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="all" name="loan_pay_edit">
                                <label>可查看全部人员</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="only" name="loan_pay_edit">
                                <label>只查看本人</label>
                            </div>
                        </td>
                    </tr>
                    <!-- / 第八栏 -->

                    <!-- 第九栏 -->
                    <tr>
                        <td rowspan="10">9</td>
                        <td rowspan="10">费用付款</td>
                        <td rowspan="3">付款审批清单</td>
                        <td rowspan="3" colspan="3"></td>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="all" name="pay_list">
                                <label>可全部查看</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="only" name="pay_list">
                                <label>只能查看本人记录</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="any" name="pay_list">
                                <label>可查看指定项目和空白项目</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="3">付款申请</td>
                        <td colspan="3" rowspan="3"></td>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="all" name="pay_add">
                                <label>所有项目</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="any" name="pay_add">
                                <label>可查看指定项目和空白项目</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="off" name="pay_add">
                                <label>无此权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="2">付款审批</td>
                        <td colspan="3" rowspan="2"></td>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="all" name="pay_pass">
                                <label>有此权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="off" name="pay_pass">
                                <label>无此权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="2">付款操作</td>
                        <td colspan="3" rowspan="2"></td>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="all" name="pay_operate">
                                <label>有此权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="off" name="pay_operate">
                                <label>无此权限</label>
                            </div>
                        </td>
                    </tr>
                    <!-- / 第九栏 -->

                    <!-- 第十栏 -->
                    <tr>
                        <td rowspan="18">10</td>
                        <td rowspan="18">数据维护</td>
                        <td rowspan="2">操作人员管理</td>
                        <td rowspan="2" colspan="3"></td>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="all" name="data_user">
                                <label>有此权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="off" name="data_user">
                                <label>无此权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="2">项目类别管理</td>
                        <td rowspan="2" colspan="3"></td>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="all" name="data_project_type">
                                <label>有此权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="off" name="data_project_type">
                                <label>无此权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="2">供应商管理</td>
                        <td rowspan="2" colspan="3"></td>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="all" name="data_supplier">
                                <label>有此权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="off" name="data_supplier">
                                <label>无此权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="2">物料管理</td>
                        <td rowspan="2" colspan="3"></td>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="all" name="data_material">
                                <label>有此权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="off" name="data_material">
                                <label>无此权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="2">仓库管理</td>
                        <td rowspan="2" colspan="3"></td>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="all" name="data_stock">
                                <label>有此权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="off" name="data_stock">
                                <label>无此权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="2">银行账户</td>
                        <td rowspan="2" colspan="3"></td>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="all" name="data_bank">
                                <label>有此权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="off" name="data_bank">
                                <label>无此权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="2">发票类型管理</td>
                        <td rowspan="2" colspan="3"></td>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="all" name="data_invoice_type">
                                <label>有此权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="off" name="data_invoice_type">
                                <label>无此权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="2">施工队管理</td>
                        <td rowspan="2" colspan="3"></td>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="all" name="data_build_team">
                                <label>有此权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="off" name="data_build_team">
                                <label>无此权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="2">报销费用类别管理</td>
                        <td rowspan="2" colspan="3"></td>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="all" name="data_payment">
                                <label>有此权限</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="off" name="data_payment">
                                <label>无此权限</label>
                            </div>
                        </td>
                    </tr>
                    <!-- / 第十栏 -->
                    </tbody>
                </table>
            </div>

            <div class="flex-row flex-center margin-top-20">
                <button type="submit" class="ui button primary">提交</button>
            </div>

        </form>
    </div>
    <!-- /主体内容 === 不可复用 -->
@endsection
@section('pageJs')
    {{--<script src="{{url('js/project_list.js')}}"></script>--}}
@endsection