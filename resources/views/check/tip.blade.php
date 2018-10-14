@extends('layouts.main')
@section('title','收款提示')
@section('content')
    <!-- 没有导航的单独窗口页面 -->
    <div class="normal-content print-no-padding">

        <div class="ui breadcrumb">
            <a class="section">验收与收款管理</a>
            <div class="divider"> / </div>
            <a class="section" >验收与收款清单</a>
            <div class="divider"> / </div>
            <a class="section" >项目明细 - 项目号 {{$project->number}}</a>
            <div class="divider"> / </div>
            <div class="active section">收款提示</div>
        </div>

        <h1 class="ui red header blue center aligned">收款提示</h1>
        <div class="invisible" id="checkCreateTips">
            <!-- 基本信息 -->
            <h4 class="ui dividing header blue">基本信息</h4>
            <div class="ui form form-item">
                <div class="ui three column doubling stackable grid">
                    <div class="column">
                        <div class="inline fields">
                            <label class="four wide field">项目编号</label>
                            <div class="twelve wide field">
                                <input type="hidden" id="projectId" value="{{$project->id}}">
                                <div class="fake-input">{{$project->number}}</div>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="four wide field">项目内容</label>
                            <div class="twelve wide field">
                                <div class="fake-input">{{$project->name}}</div>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="four wide field">验收日期</label>
                            <div class="twelve wide field">
                                <div class="fake-input">{{$project->acceptance_date}}</div>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="four wide field">履约保证金余额</label>
                            <div class="twelve wide field">
                                <div class="fake-input">{{$project->bail()->sum('pay_price')-$project->collects()->where('type','=',1)->sum('price')}}￥</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- / 基本信息 -->



            <!-- 预计请款 -->
            <h4 class="ui red header blue center aligned">预计收款信息修改</h4>
            <div  id="buyInvoiceEdit">

                <form method="post">
                    <div class="ui form form-item">
                        <div class="ui three column doubling stackable grid">
                            <div class="column">
                                <div class="inline fields">
                                    <label class="four wide field">请款日期</label>
                                    <div class="twelve wide field">
                                        {{--<el-date-picker v-model="form.date" name="date" type="date" placeholder="请选择收票日期" value-format="yyyy-MM-dd">--}}
                                        {{--</el-date-picker>--}}
                                        {{--<input type="hidden" id="getDate" value="2018-02-13">--}}
                                        <input type="date" name="pay_date" value="{{$tip->pay_date}}">
                                    </div>
                                </div>
                            </div>
                            <div class="column">
                                <div class="inline fields">
                                    <label class="four wide field">请款金额</label>
                                    <div class="twelve wide field">
                                        <input type="number" name="price" value="{{$tip->price}}">
                                        {{--<div class="fake-input">{{\App\User::find($invoice->worker)->username}}</div>--}}
                                    </div>
                                </div>
                            </div>
                            <div class="column">
                                <div class="inline fields">
                                    <label class="four wide field">付款单位</label>
                                    <div class="twelve wide field">
                                        <input name="pay_unit" type="text" value="{{$tip->pay_unit}}">
                                        {{--<el-date-picker v-model="form.invoice_date" name="invoice_date" type="date" placeholder="请选择开票日期" value-format="yyyy-MM-dd">--}}
                                        {{--</el-date-picker>--}}
                                    </div>
                                </div>
                            </div>
                            <div class="column">
                                <div class="inline fields">
                                    <label class="four wide field">备注</label>
                                    <div class="twelve wide field">
                                        <input type="text" name="remark" value="{{$tip->remark}}">
                                        {{--<input type="text" v-model="form.number" name="number"  placeholder="请输入发票号码">--}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="inline-center margin-top-20">
                        <button class="ui button green large">
                            <i class="icon hand pointer"></i>
                            <span>提交</span>
                        </button>
                    </div>
                </form>
            </div>
            <!-- / 预计请款 -->

        </div>

    </div>
    <!-- /主体内容 === 不可复用 -->
@endsection
@section('pageJs')
    <script src="{{url('js/check_createTips.js')}}"></script>
@endsection