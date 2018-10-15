@extends('layouts.main_no_nav')
@section('title','录入权限-'.$user->name)
@section('content')
    <!-- 没有导航的单独窗口页面 -->
    <div class="normal-content print-no-padding">

        <div class="ui breadcrumb">
            <a class="section">项目立项管理</a>
            <div class="divider"> / </div>
            <a class="section" href="{{url('project/detail')}}"  >项目明细清单</a>
            <div class="divider"> / </div>
            <a class="section" href="{{url('project/auth?id=')}}{{$project->id}}" >权限设置 - {{$project->number}}</a>
            <div class="divider"> / </div>
            <div class="active section">录入权限 - {{$user->name}}</div>
        </div>

        <h4 class="ui header">操作人员：
            <span class="font-normal">{{\Illuminate\Support\Facades\Auth::user()->name}}</span>
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
                        <td rowspan="2">1</td>
                        <td rowspan="2">查询项目明细</td>
                        <td rowspan="2"></td>
                        <td colspan="3" rowspan="2"></td>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="all" name="project_detail">
                                <label>有此权限</label>
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
                        <td rowspan="2">2</td>
                        <td rowspan="2">项目立项</td>
                        <td rowspan="2">已立项项目清单</td>
                        <td colspan="3" rowspan="2"></td>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="all" name="project_list">
                                <label>可查看</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="off" name="project_list">
                                <label>不可查看</label>
                            </div>
                        </td>
                        <span class="fake-a authCheck"></span>
                    </tr>

                    <!-- / 第二栏 -->

                    <!-- 第三栏 -->
                    <tr>
                        <td rowspan="4">3</td>
                        <td rowspan="4">预算管理</td>
                        <td rowspan="2">预算管理清单</td>
                        <td rowspan="2" colspan="3"></td>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="all" name="budget_list">
                                <label>可查看</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="off" name="budget_list">
                                <label>不可查看</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="2">录入与修改预算清单</td>
                        <td colspan="3" rowspan="2"></td>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="all" name="budget_edit">
                                <label>有此权限</label>
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
                        <td rowspan="18">4</td>
                        <td rowspan="18">验收与收款管理</td>
                        <td rowspan="2">验收与收款清单</td>
                        <td rowspan="2" colspan="3"></td>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="all" name="check_list">
                                <label>可查看</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="off" name="check_list">
                                <label>不可查看</label>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td rowspan="2">验收操作</td>
                        <td colspan="3" rowspan="2"></td>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="all" name="check_operate">
                                <label>有此权限</label>
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
                        <td rowspan="4">收款提示录入</td>
                        <td rowspan="2">预计收回履约保证金</td>
                        <td colspan="2" rowspan="2"></td>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="all" name="check_tip_eidt_margins">
                                <label>有此权限</label>
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
                        <td rowspan="2">预计请款</td>
                        <td colspan="2" rowspan="2"></td>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="all" name="check_tip_eidt_money">
                                <label>有此权限</label>
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
                        <td rowspan="2">开票录入</td>
                        <td colspan="3" rowspan="2"></td>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="all" name="check_invoice">
                                <label>有此权限</label>
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
                        <td rowspan="8">收款录入</td>
                        <td rowspan="2">收回履约保证金</td>
                        <td colspan="2" rowspan="2"></td>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="all" name="check_get_margins">
                                <label>有此权限</label>
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
                        <td rowspan="2">主合同收款</td>
                        <td colspan="2" rowspan="2"></td>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="all" name="check_get_master">
                                <label>有此权限</label>
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
                        <td rowspan="2">分包合同收款</td>
                        <td colspan="2" rowspan="2"></td>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="all" name="check_get_sub">
                                <label>有此权限</label>
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
                        <td rowspan="2">发包公司收款</td>
                        <td colspan="2" rowspan="2"></td>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="all" name="check_get_divide">
                                <label>有此权限</label>
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
                        <td rowspan="10">5</td>
                        <td rowspan="10">采购管理</td>
                        <td rowspan="2">采购清单</td>
                        <td colspan="3" rowspan="2"></td>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="all" name="buy_list">
                                <label>有此权限</label>
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
                        <td rowspan="2">项目采购物料清单</td>
                        <td rowspan="2" colspan="3"></td>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="all" name="buy_whole_list">
                                <label>有此权限</label>
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
                        <td rowspan="2">采购立项</td>
                        <td rowspan="2">采购立项清单</td>
                        <td colspan="2" rowspan="2"></td>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="all" name="buy_project_list">
                                <label>可查看</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="off" name="buy_project_list">
                                <label>不可查看</label>
                            </div>
                        </td>
                    </tr>





                    <tr>
                        <td rowspan="2">采购付款</td>
                        <td rowspan="2">采购付款清单</td>
                        <td rowspan="2" colspan="2"></td>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="all" name="buy_pay_list">
                                <label>可查看</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="off" name="buy_pay_list">
                                <label>不可查看</label>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td rowspan="2">采购收票</td>
                        <td rowspan="2">采购收票清单</td>
                        <td colspan="2" rowspan="2"></td>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="all" name="buy_invoice_list">
                                <label>可查看</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="off" name="buy_invoice_list">
                                <label>不可查看</label>
                            </div>
                        </td>
                    </tr>
                    <!-- / 第五栏 -->

                    <!-- 第六栏 -->
                    <tr>
                        <td rowspan="13">6</td>
                        <td rowspan="13">库存管理</td>
                    </tr>
                    <tr>
                        <td rowspan="2">采购收货入库</td>
                        <td rowspan="2">采购收货入库清单</td>
                        <td colspan="2" rowspan="2"></td>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="all" name="stock_buy_list">
                                <label>可查看</label>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="off" name="stock_buy_list">
                                <label>不可查看</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="4">退料入库</td>
                        <td rowspan="2">退料入库清单</td>
                        <td colspan="2" rowspan="2"></td>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="all" name="stock_return_list">
                                <label>可查看</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="off" name="stock_return_list">
                                <label>不可查看</label>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td rowspan="2">新增退料入库</td>
                        <td colspan="2" rowspan="2"></td>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="all" name="stock_return_edit">
                                <label>可查看</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="off" name="stock_return_edit">
                                <label>不可查看</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="4">领料出库</td>
                        <td rowspan="2">领料出库清单</td>
                        <td colspan="2" rowspan="2"></td>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="all" name="stock_get_list">
                                <label>可查看</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="off" name="stock_get_list">
                                <label>不可查看</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="2">新增领料出库</td>
                        <td colspan="2" rowspan="2"></td>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="all" name="stock_get_edit">
                                <label>可查看</label>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="off" name="stock_get_edit">
                                <label>不可查看</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="2">退货出库</td>
                        <td rowspan="2">退货出库清单</td>
                        <td colspan="2" rowspan="2"></td>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="all" name="stock_out_list">
                                <label>可查看</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="off" name="stock_out_list">
                                <label>不可查看</label>
                            </div>
                        </td>
                    </tr>
                    <!-- / 第六栏 -->

                    <!-- 第七栏 -->
                    <tr>
                        <td rowspan="16">7</td>
                        <td rowspan="16">施工管理</td>
                        <td rowspan="2">施工费清单</td>
                        <td colspan="3" rowspan="2"></td>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="all" name="build_list">
                                <label>可查看</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="off" name="build_list">
                                <label>不可查看</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="4">施工合同备案</td>
                        <td rowspan="2">备案合同清单</td>
                        <td colspan="2" rowspan="2"></td>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="all" name="build_contract_list">
                                <label>可查看</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="off" name="build_contract_list">
                                <label>不可查看</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="2">录入合同</td>
                        <td colspan="2" rowspan="2"></td>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="all" name="build_contract_edit">
                                <label>有此权限</label>
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
                        <td rowspan="6">完工请款</td>
                        <td rowspan="2">完工请款清单</td>
                        <td colspan="2" rowspan="2"></td>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="all" name="build_finish_list">
                                <label>可查看</label>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="off" name="build_finish_list">
                                <label>不可查看</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="2">完工请款录入、修改、凭证</td>
                        <td colspan="2" rowspan="2"></td>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="all" name="build_finish_edit">
                                <label>有此权限</label>
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
                        <td rowspan="2">完工请款复核</td>
                        <td colspan="2" rowspan="2"></td>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="all" name="build_finish_check">
                                <label>有此权限</label>
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
                        <td rowspan="2">施工付款</td>
                        <td rowspan="2">施工付款清单</td>
                        <td rowspan="2" colspan="2"></td>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="all" name="build_pay_list">
                                <label>可查看</label>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="off" name="build_pay_list">
                                <label>不可查看</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="2">施工收票</td>
                        <td rowspan="2">施工收票清单</td>
                        <td colspan="2" rowspan="2"></td>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="all" name="build_invoice_list">
                                <label>可查看</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="off" name="build_invoice_list">
                                <label>不可查看</label>
                            </div>
                        </td>
                    </tr>

                    <!-- / 第七栏 -->

                    <!-- 第八栏 -->
                    <tr>
                        <td rowspan="5">8</td>
                        <td rowspan="5">报销与借款</td>

                    </tr>





                    <tr>
                        <td rowspan="2">报销申请</td>
                        <td rowspan="2">报销清单</td>
                        <td colspan="2" rowspan="2"></td>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="all" name="loan_submit_list">
                                <label>可查看</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="off" name="loan_submit_list">
                                <label>不可查看</label>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td rowspan="2">项目成本报销</td>
                        <td rowspan="2">报销申请录入、修改、凭证</td>
                        <td colspan="2" rowspan="2"></td>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="all" name="loan_project_submit_edit">
                                <label>有此权限</label>
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

                    <!-- / 第八栏 -->

                    <!-- 第九栏 -->
                    <tr>
                        <td rowspan="4">9</td>
                        <td rowspan="4">费用付款</td>
                        <td rowspan="2">付款审批清单</td>
                        <td rowspan="2" colspan="3"></td>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="all" name="pay_list">
                                <label>可查看</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="off" name="pay_list">
                                <label>不可查看</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="2">付款申请</td>
                        <td colspan="3" rowspan="2"></td>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="all" name="pay_add">
                                <label>可查看</label>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <div class="ui radio checkbox">
                                <input type="radio" value="off" name="pay_add">
                                <label>不可查看</label>
                            </div>
                        </td>
                    </tr>


                    <!-- / 第九栏 -->
                    </tbody>
                </table>
            </div>

            <div class="flex-row flex-center margin-top-20">
                <button type="submit" class="ui button primary">确认添加</button>
            </div>

        </form>

    </div>
    <!-- /主体内容 === 不可复用 -->
@endsection
@section('pageJs')
    <script src="{{url('js/project_auth.js')}}"></script>
@endsection