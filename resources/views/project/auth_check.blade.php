@extends('layouts.main')
@section('title','查看权限')
@section('content')
    <!-- 没有导航的单独窗口页面 -->
    <div class="normal-content print-no-padding">

        <div class="ui breadcrumb">
            <a class="section">项目立项管理</a>
            <div class="divider"> / </div>
            <a class="section" href="{{url('project/detail')}}" >项目明细清单</a>
            <div class="divider"> / </div>
            <a class="section" href="{{url('project/auth?id=')}}{{$project->id}}" >权限设置 - {{$project->number}}</a>
            <div class="divider"> / </div>
            <div class="active section">查看权限 - {{$user->name}}</div>
        </div>
        <h4 class="ui header">操作人员：
            <span class="font-normal">{{\Illuminate\Support\Facades\Auth::user()->name}}</span>
        </h4>
        <div class="table-head-nowrap">
            <table class="ui celled structured table unstackable center aligned">
                <thead>
                <tr>
                    <th></th>
                    <th>十个模块</th>
                    <th>操作细项</th>
                    <th colspan="3">操作子项</th>
                    <th>操作人权限</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>

                <!-- 第一栏 -->
                <tr>
                    <td rowspan="2">1</td>
                    <td rowspan="2">查询项目明细</td>
                    <td rowspan="2"></td>
                    <td colspan="3" rowspan="2"></td>
                    <td>可查看</td>
                    <td>
                        @if(in_array('project_detail',$lists))
                            <i class='large green checkmark icon'></i>
                        @else
                        @endif
                    </td>
                </tr>

                <tr>
                    <td>不可查看</td>
                    <td>
                        @if(!in_array('project_detail',$lists))
                            <i class='large green checkmark icon'></i>
                        @else
                        @endif
                    </td>
                </tr>
                <!-- / 第一栏 -->



                <!-- 第二栏 -->
                <tr>
                    <td rowspan="2">2</td>
                    <td rowspan="2">项目立项</td>
                    <td rowspan="2">已立项项目清单</td>
                    <td colspan="3" rowspan="2"></td>
                    <td>可查看</td>
                    <td>
                        @if(in_array('project_list',$lists))
                            <i class='large green checkmark icon'></i>
                        @else
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>不可查看</td>
                    <td>
                        @if(!in_array('project_list',$lists))
                            <i class='large green checkmark icon'></i>
                        @else
                        @endif
                    </td>
                </tr>

                <!-- / 第二栏 -->

                <!-- 第三栏 -->
                <tr>
                    <td rowspan="4">3</td>
                    <td rowspan="4">预算管理</td>
                    <td rowspan="2">预算管理清单</td>
                    <td rowspan="2" colspan="3"></td>
                    <td>可查看</td>
                    <td>
                        @if(in_array('budget_list',$lists))
                            <i class='large green checkmark icon'></i>
                        @else
                        @endif
                    </td>
                </tr>

                <tr>
                    <td>不可查看</td>
                    <td>
                        @if(!in_array('budget_list',$lists))
                            <i class='large green checkmark icon'></i>
                        @else
                        @endif
                    </td>
                </tr>
                <tr>
                    <td rowspan="2">录入与修改预算清单</td>
                    <td colspan="3" rowspan="2"></td>
                    <td>有此权限</td>
                    <td>
                        @if(in_array('budget_edit',$lists))
                            <i class='large green checkmark icon'></i>
                        @else
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>无此权限</td>
                    <td>
                        @if(!in_array('budget_edit',$lists))
                            <i class='large green checkmark icon'></i>
                        @else
                        @endif
                    </td>
                </tr>
                <!-- / 第三栏 -->

                <!-- 第四栏 -->
                <tr>
                    <td rowspan="18">4</td>
                    <td rowspan="18">验收与收款管理</td>
                    <td rowspan="2">验收与收款清单</td>
                    <td rowspan="2" colspan="3"></td>
                    <td>可查看</td>
                    <td>
                        @if(in_array('check_list',$lists))
                            <i class='large green checkmark icon'></i>
                        @else
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>不可查看</td>
                    <td>
                        @if(!in_array('check_list',$lists))
                            <i class='large green checkmark icon'></i>
                        @else
                        @endif
                    </td>
                </tr>

                <tr>
                    <td rowspan="2">验收操作</td>
                    <td colspan="3" rowspan="2"></td>
                    <td>有此权限</td>
                    <td>
                        @if(in_array('check_operate',$lists))
                            <i class='large green checkmark icon'></i>
                        @else
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>无此权限</td>
                    <td>
                        @if(!in_array('check_operate',$lists))
                            <i class='large green checkmark icon'></i>
                        @else
                        @endif
                    </td>
                </tr>
                <tr>
                    <td rowspan="4">收款提示录入</td>
                    <td rowspan="2">预计收回履约保证金</td>
                    <td colspan="2" rowspan="2"></td>
                    <td>有此权限</td>
                    <td>
                        @if(in_array('check_tip_eidt_margins',$lists))
                            <i class='large green checkmark icon'></i>
                        @else
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>无此权限</td>
                    <td>
                        @if(!in_array('check_tip_eidt_margins',$lists))
                            <i class='large green checkmark icon'></i>
                        @else
                        @endif
                    </td>
                </tr>
                <tr>
                    <td rowspan="2">预计请款</td>
                    <td colspan="2" rowspan="2"></td>
                    <td>有此权限</td>
                    <td>
                        @if(in_array('check_tip_eidt_money',$lists))
                            <i class='large green checkmark icon'></i>
                        @else
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>无此权限</td>
                    <td>
                        @if(!in_array('check_tip_eidt_money',$lists))
                            <i class='large green checkmark icon'></i>
                        @else
                        @endif
                    </td>
                </tr>
                <tr>
                    <td rowspan="2">开票录入</td>
                    <td colspan="3" rowspan="2"></td>
                    <td>有此权限</td>
                    <td>
                        @if(in_array('check_invoice',$lists))
                            <i class='large green checkmark icon'></i>
                        @else
                        @endif
                    </td>
                </tr>

                <tr>
                    <td>无此权限</td>
                    <td>
                        @if(!in_array('check_invoice',$lists))
                            <i class='large green checkmark icon'></i>
                        @else
                        @endif
                    </td>
                </tr>
                <tr>
                    <td rowspan="8">收款录入</td>
                    <td rowspan="2">收回履约保证金</td>
                    <td colspan="2" rowspan="2"></td>
                    <td>有此权限</td>
                    <td>
                        @if(in_array('check_get_margins',$lists))
                            <i class='large green checkmark icon'></i>
                        @else
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>无此权限</td>
                    <td>
                        @if(!in_array('check_get_margins',$lists))
                            <i class='large green checkmark icon'></i>
                        @else
                        @endif
                    </td>
                </tr>
                <tr>
                    <td rowspan="2">主合同收款</td>
                    <td colspan="2" rowspan="2"></td>
                    <td>有此权限</td>
                    <td>
                        @if(in_array('check_get_master',$lists))
                            <i class='large green checkmark icon'></i>
                        @else
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>无此权限</td>
                    <td>
                        @if(!in_array('check_get_master',$lists))
                            <i class='large green checkmark icon'></i>
                        @else
                        @endif
                    </td>
                </tr>
                <tr>
                    <td rowspan="2">分包合同收款</td>
                    <td colspan="2" rowspan="2"></td>
                    <td>有此权限</td>
                    <td>
                        @if(in_array('check_get_sub',$lists))
                            <i class='large green checkmark icon'></i>
                        @else
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>无此权限</td>
                    <td>
                        @if(!in_array('check_get_sub',$lists))
                            <i class='large green checkmark icon'></i>
                        @else
                        @endif
                    </td>
                </tr>
                <tr>
                    <td rowspan="2">发包公司收款</td>
                    <td colspan="2" rowspan="2"></td>
                    <td>有此权限</td>
                    <td>
                        @if(in_array('check_get_divide',$lists))
                            <i class='large green checkmark icon'></i>
                        @else
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>无此权限</td>
                    <td>
                        @if(!in_array('check_get_divide',$lists))
                            <i class='large green checkmark icon'></i>
                        @else
                        @endif
                    </td>
                </tr>
                <!-- / 第四栏 -->

                <!-- 第五栏 -->
                <tr>
                    <td rowspan="10">5</td>
                    <td rowspan="10">采购管理</td>
                    <td rowspan="2">采购清单</td>
                    <td colspan="3" rowspan="2"></td>
                    <td>可查看</td>
                    <td>
                        @if(in_array('buy_list',$lists))
                            <i class='large green checkmark icon'></i>
                        @else
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>不可查看</td>
                    <td>
                        @if(!in_array('buy_list',$lists))
                            <i class='large green checkmark icon'></i>
                        @else
                        @endif
                    </td>
                </tr>
                <tr>
                    <td rowspan="2">项目采购物料清单</td>
                    <td rowspan="2" colspan="3"></td>
                    <td>可查看</td>
                    <td>
                        @if(in_array('buy_whole_list',$lists))
                            <i class='large green checkmark icon'></i>
                        @else
                        @endif
                    </td>
                </tr>

                <tr>
                    <td>不可查看</td>
                    <td>@if(!in_array('buy_whole_list',$lists))
                            <i class='large green checkmark icon'></i>
                        @else
                        @endif</td>
                </tr>
                <tr>
                    <td rowspan="2">采购立项</td>
                    <td rowspan="2">采购立项清单</td>
                    <td colspan="2" rowspan="2"></td>
                    <td>可查看</td>
                    <td>
                        @if(in_array('buy_project_list',$lists))
                            <i class='large green checkmark icon'></i>
                        @else
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>不可查看</td>
                    <td>
                        @if(!in_array('buy_project_list',$lists))
                            <i class='large green checkmark icon'></i>
                        @else
                        @endif
                    </td>
                </tr>




                <tr>
                    <td rowspan="2">采购付款</td>
                    <td rowspan="2">采购付款清单</td>
                    <td rowspan="2" colspan="2"></td>
                    <td>可查看</td>
                    <td>
                        @if(in_array('buy_pay_list',$lists))
                            <i class='large green checkmark icon'></i>
                        @else
                        @endif
                    </td>
                </tr>

                <tr>
                    <td>不可查看</td>
                    <td>
                        @if(!in_array('buy_pay_list',$lists))
                            <i class='large green checkmark icon'></i>
                        @else
                        @endif
                    </td>
                </tr>

                <tr>
                    <td rowspan="2">采购收票</td>
                    <td rowspan="2">采购收票清单</td>
                    <td colspan="2" rowspan="2"></td>
                    <td>可查看</td>
                    <td>
                        @if(in_array('buy_invoice_list',$lists))
                            <i class='large green checkmark icon'></i>
                        @else
                        @endif
                    </td>
                </tr>

                <tr>
                    <td>不可查看</td>
                    <td>
                        @if(!in_array('buy_invoice_list',$lists))
                            <i class='large green checkmark icon'></i>
                        @else
                        @endif
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
                    <td>可查看</td>
                    <td>
                        @if(in_array('stock_buy_list',$lists))
                            <i class='large green checkmark icon'></i>
                        @else
                        @endif
                    </td>
                </tr>

                <tr>
                    <td>不可查看</td>
                    <td>
                        @if(!in_array('stock_buy_list',$lists))
                            <i class='large green checkmark icon'></i>
                        @else
                        @endif
                    </td>
                </tr>

                <tr>
                    <td rowspan="4">退料入库</td>
                    <td rowspan="2">退料入库清单</td>
                    <td colspan="2" rowspan="2"></td>
                    <td>可查看</td>
                    <td>
                        @if(in_array('stock_return_list',$lists))
                            <i class='large green checkmark icon'></i>
                        @else
                        @endif
                    </td>
                </tr>

                <tr>
                    <td>不可查看</td>
                    <td>
                        @if(!in_array('stock_return_list',$lists))
                            <i class='large green checkmark icon'></i>
                        @else
                        @endif
                    </td>
                </tr>
                <tr>
                    <td rowspan="2">新增退料入库</td>
                    <td colspan="2" rowspan="2"></td>
                    <td>可查看</td>
                    <td>
                        @if(in_array('stock_return_edit',$lists))
                            <i class='large green checkmark icon'></i>
                        @else
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>不可查看</td>
                    <td>
                        @if(!in_array('stock_return_edit',$lists))
                            <i class='large green checkmark icon'></i>
                        @else
                        @endif
                    </td>
                </tr>
                <tr>
                    <td rowspan="4">领料出库</td>
                    <td rowspan="2">领料出库清单</td>
                    <td colspan="2" rowspan="2"></td>
                    <td>可查看</td>
                    <td>
                        @if(in_array('stock_get_list',$lists) )
                            <i class='large green checkmark icon'></i>
                        @else
                        @endif
                    </td>
                </tr>

                <tr>
                    <td>不可查看</td>
                    <td>
                        @if(!in_array('stock_get_list',$lists))
                            <i class='large green checkmark icon'></i>
                        @else
                        @endif
                    </td>
                </tr>
                <tr>
                    <td rowspan="2">新增领料出库</td>
                    <td colspan="2" rowspan="2"></td>
                    <td>可查看</td>
                    <td>
                        @if(in_array('stock_get_edit',$lists))
                            <i class='large green checkmark icon'></i>
                        @else
                        @endif
                    </td>
                </tr>

                <tr>
                    <td>不可查看</td>
                    <td>
                        @if(!in_array('stock_get_edit',$lists))
                            <i class='large green checkmark icon'></i>
                        @else
                        @endif
                    </td>
                </tr>
                <tr>
                    <td rowspan="2">退货出库</td>
                    <td rowspan="2">退货出库清单</td>
                    <td colspan="2" rowspan="2"></td>
                    <td>可查看</td>
                    <td>
                        @if(in_array('stock_out_list',$lists))
                            <i class='large green checkmark icon'></i>
                        @else
                        @endif
                    </td>
                </tr>

                <tr>
                    <td>不可查看</td>
                    <td>
                        @if(!in_array('stock_out_list',$lists))
                            <i class='large green checkmark icon'></i>
                        @else
                        @endif
                    </td>
                </tr>

                <!-- / 第六栏 -->

                <!-- 第七栏 -->
                <tr>
                    <td rowspan="16">7</td>
                    <td rowspan="16">施工管理</td>
                    <td rowspan="2">施工费清单</td>
                    <td colspan="3" rowspan="2"></td>
                    <td>可查看</td>
                    <td>
                        @if(in_array('build_list',$lists))
                            <i class='large green checkmark icon'></i>
                        @else
                        @endif
                    </td>
                </tr>

                <tr>
                    <td>不可查看</td>
                    <td>
                        @if(!in_array('build_list',$lists))
                            <i class='large green checkmark icon'></i>
                        @else
                        @endif
                    </td>
                </tr>
                <tr>
                    <td rowspan="4">施工合同备案</td>
                    <td rowspan="2">备案合同清单</td>
                    <td colspan="2" rowspan="2"></td>
                    <td>可查看</td>
                    <td>
                        @if(in_array('build_contract_list',$lists))
                            <i class='large green checkmark icon'></i>
                        @else
                        @endif
                    </td>
                </tr>

                <tr>
                    <td>不可查看</td>
                    <td>
                        @if(!in_array('build_contract_list',$lists))
                            <i class='large green checkmark icon'></i>
                        @else
                        @endif
                    </td>
                </tr>
                <tr>
                    <td rowspan="2">录入合同</td>
                    <td colspan="2" rowspan="2"></td>
                    <td>可全部查看</td>
                    <td>
                        @if(in_array('build_contract_edit',$lists))
                            <i class='large green checkmark icon'></i>
                        @else
                        @endif
                    </td>
                </tr>

                <tr>
                    <td>不可查看</td>
                    <td>
                        @if(!in_array('build_contract_edit',$lists))
                            <i class='large green checkmark icon'></i>
                        @else
                        @endif
                    </td>
                </tr>
                <tr>
                    <td rowspan="6">完工请款</td>
                    <td rowspan="2">完工请款清单</td>
                    <td colspan="2" rowspan="2"></td>
                    <td>可查看</td>
                    <td>
                        @if(in_array('build_finish_list',$lists))
                            <i class='large green checkmark icon'></i>
                        @else
                        @endif
                    </td>
                </tr>

                <tr>
                    <td>不可查看</td>
                    <td>
                        @if(!in_array('build_finish_list',$lists))
                            <i class='large green checkmark icon'></i>
                        @else
                        @endif
                    </td>
                </tr>
                <tr>
                    <td rowspan="2">完工请款录入、修改、凭证</td>
                    <td colspan="2" rowspan="2"></td>
                    <td>可查看</td>
                    <td>
                        @if(in_array('build_finish_edit',$lists))
                            <i class='large green checkmark icon'></i>
                        @else
                        @endif
                    </td>
                </tr>

                <tr>
                    <td>不可查看</td>
                    <td>
                        @if(!in_array('build_finish_edit',$lists))
                            <i class='large green checkmark icon'></i>
                        @else
                        @endif
                    </td>
                </tr>
                <tr>
                    <td rowspan="2">完工请款复核</td>
                    <td colspan="2" rowspan="2"></td>
                    <td>有此权限</td>
                    <td>
                        @if(in_array('build_finish_check',$lists))
                            <i class='large green checkmark icon'></i>
                        @else
                        @endif
                    </td>
                </tr>

                <tr>
                    <td>无此权限</td>
                    <td>
                        @if(!in_array('build_finish_check',$lists))
                            <i class='large green checkmark icon'></i>
                        @else
                        @endif
                    </td>
                </tr>

                <tr>
                    <td rowspan="2">施工付款</td>
                    <td rowspan="2">施工付款清单</td>
                    <td rowspan="2" colspan="2"></td>
                    <td>可查看</td>
                    <td>
                        @if(in_array('build_pay_list',$lists))
                            <i class='large green checkmark icon'></i>
                        @else
                        @endif
                    </td>
                </tr>

                <tr>
                    <td>不可查看</td>
                    <td>
                        @if(!in_array('build_pay_list',$lists))
                            <i class='large green checkmark icon'></i>
                        @else
                        @endif
                    </td>
                </tr>

                <tr>
                    <td rowspan="2">施工收票</td>
                    <td rowspan="2">施工收票清单</td>
                    <td colspan="2" rowspan="2"></td>
                    <td>可查看</td>
                    <td>
                        @if(in_array('build_invoice_list',$lists))
                            <i class='large green checkmark icon'></i>
                        @else
                        @endif
                    </td>
                </tr>

                <tr>
                    <td>不可查看</td>
                    <td>
                        @if(!in_array('build_invoice_list',$lists))
                            <i class='large green checkmark icon'></i>
                        @else
                        @endif
                    </td>
                </tr>

                <!-- / 第七栏 -->

                <!-- 第八栏 -->
                <tr>
                    <td rowspan="5">8</td>
                    <td rowspan="5">报销与借款</td>

                </tr>


                <tr>
                    <td rowspan="4">报销申请</td>
                    <td rowspan="2">报销清单</td>
                    <td colspan="2" rowspan="2"></td>
                    <td>可查看</td>
                    <td>
                        @if(in_array('loan_submit_list',$lists))
                            <i class='large green checkmark icon'></i>
                        @else
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>不可查看</td>
                    <td>
                        @if(!in_array('loan_submit_list',$lists))
                            <i class='large green checkmark icon'></i>
                        @else
                        @endif
                    </td>
                </tr>


                <tr>
                    <td rowspan="2">项目成本报销</td>
                    <td rowspan="2">报销申请录入、修改、凭证</td>
                    <td  rowspan="2"></td>
                    <td>有此权限</td>
                    <td>
                        @if(in_array('loan_project_submit_edit',$lists))
                            <i class='large green checkmark icon'></i>
                        @else
                        @endif
                    </td>
                </tr>

                <tr>
                    <td>无此权限</td>
                    <td>
                        @if(!in_array('loan_project_submit_edit',$lists))
                            <i class='large green checkmark icon'></i>
                        @else
                        @endif
                    </td>
                </tr>

                <!-- / 第八栏 -->

                <!-- 第九栏 -->
                <tr>
                    <td rowspan="4">9</td>
                    <td rowspan="4">费用付款</td>
                    <td rowspan="2">付款审批清单</td>
                    <td rowspan="2" colspan="3"></td>
                    <td>可查看</td>
                    <td>
                        @if(in_array('pay_list',$lists))
                            <i class='large green checkmark icon'></i>
                        @else
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>不可查看</td>
                    <td>
                        @if(!in_array('pay_list',$lists))
                            <i class='large green checkmark icon'></i>
                        @else
                        @endif
                    </td>
                </tr>

                <tr>
                    <td rowspan="2">付款申请</td>
                    <td colspan="3" rowspan="2"></td>
                    <td>有此权限</td>
                    <td>
                        @if(in_array('pay_add',$lists))
                            <i class='large green checkmark icon'></i>
                        @else
                        @endif
                    </td>
                </tr>

                <tr>
                    <td>无此权限</td>
                    <td>
                        @if(!in_array('pay_add',$lists))
                            <i class='large green checkmark icon'></i>
                        @else
                        @endif
                    </td>
                </tr>

                <!-- / 第九栏 -->
                </tbody>
            </table>
        </div>


        <div class="flex-row flex-center margin-top-20">
            <a class="ui icon button primary" href="javascript:_helper.fullWindow('{{url('project/auth_edit')}}?project_id={{$project->id}}&type={{$type}}&user_id={{$user->id}}')" style="margin:0 20px;">
                <i class="icon edit"></i>
                <span>修改权限</span>
            </a>
        </div>
    </div>
    <!-- /主体内容 === 不可复用 -->
@endsection
@section('pageJs')
    {{--<script src="{{url('js/project_list.js')}}"></script>--}}
@endsection