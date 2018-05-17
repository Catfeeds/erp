@extends('layouts.main_no_nav')
@section('title','收票信息修改')
@section('content')
    <!-- 没有导航的单独窗口页面 -->
    <div class="normal-content print-no-padding">

        <div class="ui breadcrumb">
            <a class="section">施工管理</a>
            <div class="divider"> / </div>
            <a class="section" href="../build/get_list.html">施工收票清单</a>
            <div class="divider"> / </div>
            <a class="section" href="../build/get_single.html?id=">施工收票查询</a>
            <div class="divider"> / </div>
            <div class="active section">收票信息修改</div>
        </div>

        <div id="invoiceTypeList" style="display:none;">{{json_encode($invoices)}}</div>
        <h1 class="ui red header blue center aligned">收票信息修改</h1>
        <div class="invisible" id="buildGetEdit">
            <h4 class="ui dividing header blue">收票信息</h4>

            <form method="post">
                <div class="ui form form-item">
                    <div class="ui three column doubling stackable grid">
                        <div class="column">
                            <div class="inline fields">
                                <label class="four wide field">收票日期</label>
                                <div class="twelve wide field">
                                    <input type="hidden" name="id" value="{{$invoice->id}}">
                                    <el-date-picker v-model="form.get_date" name="get_date" type="date" placeholder="请选择收票日期" value-format="yyyy-MM-dd">
                                    </el-date-picker>
                                    <input type="hidden" id="getDate" value="{{$invoice->date}}">
                                </div>
                            </div>
                        </div>
                        <div class="column">
                            <div class="inline fields">
                                <label class="four wide field">开票日期</label>
                                <div class="twelve wide field">
                                    <el-date-picker v-model="form.invoice_date" name="invoice_date" type="date" placeholder="请选择开票日期" value-format="yyyy-MM-dd">
                                    </el-date-picker>
                                    <input type="hidden" id="invoiceDate" value="{{$invoice->invoice_date}}">
                                </div>
                            </div>
                        </div>
                        <div class="column">
                            <div class="inline fields">
                                <label class="four wide field">发票号码</label>
                                <div class="twelve wide field">
                                    <input type="text" value="{{$invoice->number}}" placeholder="请输入发票号码">
                                </div>
                            </div>
                        </div>
                        <div class="column">
                            <div class="inline fields">
                                <label class="four wide field">发票类型</label>
                                <div class="twelve wide field">
                                    <el-select v-model="form.type" placeholder="发票类型" name="type">
                                        <el-option v-for="(item, index) in invoice_type" :key="index" :label="item.name" :value="item.id">
                                        </el-option>
                                    </el-select>
                                    <input type="hidden" id="invoiceType" value="{{$invoice->type}}">
                                </div>
                            </div>
                        </div>
                        <div class="column">
                            <div class="inline fields">
                                <label class="four wide field">不含税金额</label>
                                <div class="twelve wide field">
                                    <input type="number" name="amount_without_tax" placeholder="请输入不含税金额" value="{{$invoice->without_tax}}">
                                </div>
                            </div>
                        </div>
                        <div class="column">
                            <div class="inline fields">
                                <label class="four wide field">税额</label>
                                <div class="twelve wide field">
                                    <input type="number" name="tax" placeholder="请输入税额" value="{{$invoice->tax}}">
                                </div>
                            </div>
                        </div>
                        <div class="column">
                            <div class="inline fields">
                                <label class="four wide field">含税金额</label>
                                <div class="twelve wide field">
                                    <input type="number" name="amount" placeholder="请输入含税金额" value="{{$invoice->with_tax}}">
                                </div>
                            </div>
                        </div>
                        <div class="column">
                            <div class="inline fields">
                                <label class="four wide field">收票经办人</label>
                                <div class="twelve wide field">
                                    <input type="text" name="worker"  value="{{$invoice->worker}}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="inline-center margin-top-20">
                    <button class="ui button primary large">
                        <i class="icon hand pointer"></i>
                        <span>提交</span>
                    </button>
                </div>
            </form>
        </div>


    </div>
    <!-- /主体内容 === 不可复用 -->
@endsection
@section('pageJs')
    <script src="{{url('js/build_get_edit.js')}}"></script>
@endsection