@extends('layouts.main')
@section('title','凭证')
@section('content')
    <!-- 没有导航的单独窗口页面 -->
    <div class="normal-content print-no-padding">

        <div class="ui breadcrumb">
            <a class="section">费用付款管理</a>
            <div class="divider"> / </div>
            <a class="section" href="../pay/list.html">付款审批清单</a>
            <div class="divider"> / </div>
            <div class="active section">付款审批查询 - {{$cost->number}}</div>
        </div>

        <input type="hidden" id="payId" value="">

        <h3 class="ui header center aligned">付款审批查询 - {{$cost->number}}</h3>
        <table class="ui celled center aligned table unstackable">
            <thead>
            <tr>
                <th>付款编号</th>
                <th class="fake-td" colspan="2">{{$cost->number}}</th>
                <th>付款金额</th>
                <th class="fake-td" colspan="2">{{number_format($cost->apply_price,2)}}￥</th>
            </tr>
            <tr>
                <th>收款人</th>
                <th class="fake-td">{{$cost->supplier_id==0?'':\App\Models\Supplier::find($cost->supplier_id)->name}}</th>
                <th>收款银行</th>
                <th class="fake-td">{{$cost->supplier_id==0?'':\App\Models\Supplier::find($cost->supplier_id)->bank}}</th>
                <th>收款账号</th>
                <th class="fake-td">{{$cost->supplier_id==0?'':\App\Models\Supplier::find($cost->supplier_id)->account}}</th>
            </tr>
            <tr>
                <th>用途</th>
                <th colspan="2" class="fake-td">{{$cost->application}}</th>
                <th>备注</th>
                <th colspan="2" class="fake-td">{{$cost->remark}}</th>
            </tr>
            <tr>
                <th>项目编号</th>
                <th class="fake-td">{{$cost->project_id==0?'':\App\Models\Project::find($cost->project_id)->number}}</th>
                <th>项目内容</th>
                <th colspan="3" class="fake-td">{{$cost->project_id==0?'':\App\Models\Project::find($cost->project_id)->name}}</th>
            </tr>
            <tr>
                <th>费用类型</th>
                <th class="fake-td">{{$cost->pay_type==0?'':\App\PayType::find($cost->pay_type)->title}}</th>
                <th>具体事项</th>
                <th class="fake-td">{{$cost->pay_detail==0?'':\App\PayTypeDetail::find($cost->pay_detail)->title}}</th>
                <th>发票类型</th>
                <th class="fake-td">{{$cost->invoice_type==0?'':\App\Models\Invoice::find($cost->invoice_type)->name}}</th>
            </tr>
            <tr>
                <th>申请人</th>
                <th class="fake-td" colspan="2">瑞茜</th>
                <th>审批人</th>
                <th class="fake-td" colspan="2">何福清</th>
            </tr>
            <!-- <tr>
              <th colspan="5">付款信息</th>
            </tr>
            <tr>
              <th>付款日期</th>
              <th class="fake-td">2018-03-11</th>
              <th>付款金额</th>
              <th colspan="2" class="fake-td">123,523￥</th>
            </tr>
            <tr>
              <th colspan="5">付款方式</th>
            </tr> -->
            </thead>
            <!-- <tbody>
              <tr>
                <td>1</td>
                <td>现金</td>
                <td colspan="3">11,231￥</td>
              </tr>
              <tr>
                <td>2</td>
                <td>转账</td>
                <td>123,523￥</td>
                <td>银行及账号</td>
                <td>中国银行 653234322234363312</td>
              </tr>
              <tr>
                <td>3</td>
                <td>其他</td>
                <td colspan="3">0</td>
              </tr>
            </tbody>
            <tfoot>
              <tr>
                <th>备注</th>
                <th class="fake-td" colspan="4">这是一些备注</th>
              </tr>
              <tr>
                <th>付款经办人</th>
                <th class="fake-td" colspan="4">海子</th>
              </tr>
            </tfoot> -->
        </table>

        <h4 class="ui header center aligned">付款信息</h4>
        <div class="flex-row flex-end">
            <a class="ui icon button" href="javascript:_helper.fullWindow('../pay/pay.html?id=1')" style="margin:0 20px;">
                <i class="icon yen"></i>
                <span>修改付款信息</span>
            </a>
        </div>
        <table class="ui celled center aligned table unstackable">
            <thead>
            <tr>
                <th>序号</th>
                <th>付款日期</th>
                <th>付款金额</th>
                <th>付款方式</th>
                <th>银行账号</th>
                <th>备注</th>
                <th>付款经办人</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>1</td>
                <td>2018-02-11</td>
                <td>1,222,222￥</td>
                <td>现金</td>
                <td>中国银行 634341354233423423</td>
                <td>这是备注</td>
                <td>黄晓明</td>
            </tr>
            </tbody>
            <tfoot>
            <tr>
                <th>合计</th>
                <th colspan="6">1,222,222￥</th>
            </tr>
            <tr>
                <th>应收账款余额</th>
                <th colspan="6">1,222,222￥</th>
            </tr>
            </tfoot>
        </table>


        <h4 class="ui header center aligned">收票记录</h4>
        <div class="flex-row flex-end">
            <a class="ui icon button" href="javascript:_helper.fullWindow('../pay/invoice_create.html?id=1')" style="margin:0 20px;">
                <i class="icon yen"></i>
                <span>修改收票记录</span>
            </a>
        </div>
        <table class="ui celled center aligned table unstackable">
            <thead>
            <tr>
                <th>序号</th>
                <th>收票日期</th>
                <th>开票日期</th>
                <th>发票号码</th>
                <th>发票类型</th>
                <th>不含税金额</th>
                <th>税额</th>
                <th>含税金额</th>
                <th>收票经办人</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>1</td>
                <td>2018-02-11</td>
                <td>2018-02-11</td>
                <td>122512312322</td>
                <td>发票类型</td>
                <td>1,222,222￥</td>
                <td>1,222,222￥</td>
                <td>1,222,222￥</td>
                <td>黄晓明</td>
            </tr>
            </tbody>
            <tfoot>
            <tr>
                <th>合计</th>
                <th colspan="8">1,222,222￥</th>
            </tr>
            <tr>
                <th>应收账款余额</th>
                <th colspan="8">1,222,222￥</th>
            </tr>
            </tfoot>
        </table>

        <h4 class="ui header center aligned">合同</h4>
        <table class="ui celled center aligned table unstackable">
            <thead>
            <tr>
                <th>序号</th>
                <th>名称</th>
                <th>链接</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>1</td>
                <td>xxx</td>
                <td>
                    <a href="aaa" target="_blank">aaa</a>
                </td>
            </tr>
            </tbody>
        </table>

        <div class="flex-row flex-center margin-top-50" id="paySingleBtn">
            <button class="ui icon button negative" id="paySingleCancel" style="margin:0 20px;">
                <i class="icon delete"></i>
                <span>撤销</span>
            </button>
            <button class="ui icon button primary" id="paySingleCheck" style="margin:0 20px;">
                <i class="icon edit"></i>
                <span>审批</span>
            </button>
            <a class="ui icon button primary" href="javascript:_helper.fullWindow('../pay/pay.html')" style="margin:0 20px;">
                <i class="icon yen"></i>
                <span>付款</span>
            </a>
            <a class="ui icon button primary" href="javascript:_helper.fullWindow('../pay/invoice_create.html')" style="margin:0 20px;">
                <i class="icon yen"></i>
                <span>收票</span>
            </a>
            <a class="ui icon button positive" href="javascript:_helper.fullWindow('../pay/print.html?id=1')" style="margin:0 20px;">
                <i class="icon print"></i>
                <span>凭证</span>
            </a>
        </div>


    </div>
    <!-- /主体内容 === 不可复用 -->
@endsection
@section('pageJs')
    <script src="{{url('js/new_pay_single.js')}}"></script>
@endsection