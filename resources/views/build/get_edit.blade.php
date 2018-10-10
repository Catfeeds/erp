@extends('layouts.main_no_nav')
@section('title','收票信息修改')
@section('content')
    <!-- 没有导航的单独窗口页面 -->
    <div class="normal-content print-no-padding">

        <div class="ui breadcrumb">
            <a class="section">施工管理</a>
            <div class="divider"> / </div>
            <a class="section" >施工收票清单</a>
            <div class="divider"> / </div>
            <a class="section" >施工收票查询</a>
            <div class="divider"> / </div>
            <div class="active section">收票信息修改</div>
        </div>

        <div id="invoiceTypeList" style="display:none;">{{json_encode($invoices)}}</div>
        <input type="hidden" id="invoiceDate" value="{{$invoice->invoice_date}}">
        <input type="hidden" id="getDate" value="{{$invoice->date}}">
        <input type="hidden" id="invoiceType" value="{{$invoice->type}}">
        <input type="hidden" id="tax" value="{{$invoice->tax}}">
        <input type="hidden" id="withoutTax" value="{{$invoice->without_tax}}">
        <input type="hidden" id="number" value="{{$invoice->number}}">
        <h1 class="ui red header blue center aligned">收票信息修改</h1>
        <div class="invisible" id="buildGetEdit">
            <h4 class="ui dividing header blue">收票信息</h4>

            <form method="post" novalidate="false" >
                <div class="ui form form-item">
                    <div class="ui three column doubling stackable grid">
                        <input type="hidden" name="id" value="{{$invoice->id}}">
                        <div class="column">
                            <div class="inline fields">
                                <label class="four wide field">收票日期</label>
                                <div class="twelve wide field">
                                    <el-date-picker v-model="form.get_date" name="get_date" type="date" placeholder="请选择收票日期" value-format="yyyy-MM-dd">
                                    </el-date-picker>
                                    <input type="hidden" id="getDate" value="2018-02-13">
                                </div>
                            </div>
                        </div>
                        <div class="column">
                            <div class="inline fields">
                                <label class="four wide field">开票日期</label>
                                <div class="twelve wide field">
                                    <el-date-picker v-model="form.invoice_date" name="invoice_date" type="date" placeholder="请选择开票日期" value-format="yyyy-MM-dd">
                                    </el-date-picker>
                                    <input type="hidden" id="invoiceDate" value="2018-03-13">
                                </div>
                            </div>
                        </div>
                        <div class="column">
                            <div class="inline fields">
                                <label class="four wide field">发票号码</label>
                                <div class="twelve wide field">
                                    <input type="text" name="number" v-model="form.number" placeholder="请输入发票号码">
                                </div>
                            </div>
                        </div>
                        <div class="column">
                            <div class="inline fields">
                                <label class="four wide field">发票类型</label>
                                <div class="twelve wide field">
                                    <el-select v-model="form.type" placeholder="发票类型" name="type">
                                        <el-option v-for="item in invoiceType" :key="item.id" :label="item.name" :value="item.id">
                                        </el-option>
                                    </el-select>
                                    {{--<input type="hidden" id="invoiceType" value="1">--}}
                                </div>
                                {{--<input v-model="form.type">--}}
                            </div>
                        </div>
                        <div class="column">
                            <div class="inline fields">
                                <label class="four wide field">不含税金额</label>
                                <div class="twelve wide field">
                                    <input type="number" v-model="form.without_tax" name="amount_without_tax" placeholder="请输入不含税金额" value="200000.00">
                                </div>
                            </div>
                        </div>
                        <div class="column">
                            <div class="inline fields">
                                <label class="four wide field">税额</label>
                                <div class="twelve wide field">
                                    <input type="number"  v-model="form.tax" name="tax" placeholder="请输入税额" value="200000.00">
                                </div>
                            </div>
                        </div>
                        <div class="column">
                            <div class="inline fields">
                                <label class="four wide field">含税金额</label>
                                <div class="twelve wide field">

                                    <!-- <input type="number" name="amount" placeholder="请输入含税金额" value="200000.00"> -->
                                    <div class="fake-input">@{{ parseFloat(form.tax)+parseFloat(form.without_tax) }}￥</div>
                                </div>
                            </div>
                        </div>
                        <div class="column">
                            <div class="inline fields">
                                <label class="four wide field">收票经办人</label>
                                <div class="twelve wide field">
                                    <div class="fake-input">{{$invoice->worker}}</div>
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