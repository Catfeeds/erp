@extends('layouts.main')
@section('title','新增费用类型')
@section('content')

    <!-- 没有导航的单独窗口页面 -->
    <div class="normal-content print-no-padding">

        <div class="ui breadcrumb">
            <a class="section" href="{{url('')}}">数据维护</a>
            <div class="divider"> / </div>
            <a class="section" href="{{url('category/list')}}" >报销费用类型</a>
            <div class="divider"> / </div>
            <div class="active section">新增费用类型</div>
        </div>

        <h1 class="ui header blue aligned center">新增费用类型</h1>
        <div id="dataPaymentAdd" class="invisible">
            <h4 class="ui dividing header blue">信息录入</h4>
            <div class="ui form">
                <div class="ui three column doubling stackable grid">
                    <div class="column">
                        <div class="inline fields">
                            <label class="six wide field flex-center">费用类型</label>
                            <div class="eleven wide field">
                                <input class="special-input" type="text" v-model="paymentForm.title" placeholder="请输入费用类型">
                            </div>
                        </div>
                    </div>
                    <div class="column fifteen wide">
                        <div class="inline fields">
                            <label class="two wide field flex-center">具体事项</label>
                            <div class="eleven wide field">
                                <el-tag :key="tag" v-for="(tag, index) in paymentForm.kinds" closable :disable-transitions="false" @close="handleClose(tag, index)">
                                    @{{tag}}
                                </el-tag>
                                <el-input class="input-new-tag" v-if="inputVisible" v-model="inputValue" ref="saveTagInput" size="small" @keyup.enter.native="handleInputConfirm"
                                          @blur="handleInputConfirm">
                                </el-input>
                                <el-button v-else class="button-new-tag" size="small" @click="showInput">新增事项</el-button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="inline-center margin-top-20">
                <button class="ui button primary large" @click="submit">
                    <i class="icon hand pointer"></i>
                    <span>确定</span>
                </button>
            </div>

        </div>
    </div>
    <!-- /主体内容 === 不可复用 -->
@endsection
@section('pageJs')
<script src="{{url('js/data_payment_add.js')}}"></script>
@endsection