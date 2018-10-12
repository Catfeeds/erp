@extends('layouts.main_no_nav')
@section('title','付款录入')
@section('content')
    <!-- 没有导航的单独窗口页面 -->
    <div class="normal-content print-no-padding">

        <div class="ui breadcrumb">
            <a class="section">费用付款管理</a>
            <div class="divider"> / </div>
            <a class="section" >付款审批清单</a>
            <div class="divider"> / </div>
            <a class="section" >付款审批查询 - {{$cost->number}}</a>
            <div class="divider"> / </div>
            <div class="active section">付款</div>
        </div>

        <!-- <input type="hidden" id="payId" value="">
        <input type="hidden" id="manager" value=""> -->
        <div style="display: none;" id="bankList">{{json_encode($banks)}}</div>
        <div style="display: none;" id="payList">{{json_encode($pays)}}</div>
        <input id="requestId" style="display:none" type="text" value="{{$cost->id}}">
        <input id="worker" style="display:none" type="text" value="{{\Illuminate\Support\Facades\Auth::user()->username}}">

        <h1 class="ui header blue aligned center">付款录入</h1>
        <div id="payPay">
            <!-- <h4 class="ui dividing header blue">信息录入</h4> -->
        <!-- <div class="ui form">
    <div class="ui three column doubling stackable grid">
      <div class="column">
        <div class="inline fields">
          <label class="six wide field flex-center">付款日期</label>
          <div class="eleven wide field">
            <el-date-picker v-model="payForm.pay_date" type="date" placeholder="请选择付款日期" value-format="yyyy-MM-dd">
            </el-date-picker>
          </div>
        </div>
      </div>
      <div class="column">
        <div class="inline fields">
          <label class="six wide field flex-center">现金</label>
          <div class="eleven wide field">
            <input type="number" v-model.number="payForm.cash" placeholder="请输入现金">
          </div>
        </div>
      </div>
      <div class="column">
        <div class="inline fields">
          <label class="six wide field flex-center">转账金额</label>
          <div class="eleven wide field">
            <input type="number" v-model.number="payForm.transfer" placeholder="请输入转账金额">
          </div>
        </div>
      </div>
      <div class="column">
        <div class="inline fields">
          <label class="six wide field flex-center">其他金额</label>
          <div class="eleven wide field">
            <input type="number" v-model.number="payForm.other" placeholder="请输入其他金额">
          </div>
        </div>
      </div>
      <div class="column">
        <div class="inline fields">
          <label class="six wide field flex-center">转账银行</label>
          <div class="eleven wide field">
          <el-select v-model="payForm.bankIndex" placeholder="请选择转账银行" @change="selectBank">
            <el-option v-for="(item, index) in bankList" :key="item.id" :label="item.name + item.account" :value="index">
            </el-option>
          </el-select>
          </div>
        </div>
      </div>
      <div class="column">
        <div class="inline fields">
          <label class="six wide field flex-center">转账账户</label>
          <div class="eleven wide field">
            <div class="fake-input">@{{ payForm.account || '无' }}</div>
          </div>
        </div>
      </div>
      <div class="column">
        <div class="inline fields">
          <label class="six wide field flex-center">付款经办人</label>
          <div class="eleven wide field">
            <input type="text" v-model="payForm.manager" placeholder="请输入付款经办人">
          </div>
        </div>
      </div>
    </div>
  </div> -->


            <!-- <h4 class="ui dividing header blue">付款录入</h4> -->
            <div class="flex-row flex-end">
                <button class="ui icon button positive" @click="addItem">
                    <i class="icon plus"></i>
                    <span>添加付款</span>
                </button>
            </div>
            <h4 class="inline-center">付款清单</h4>
            <div class="ui form form-item margin-top-50">
                <div class="ui five column doubling stackable grid font-size-13">
                    <div class="one wide column form-thead">序号</div>
                    <div class="two wide column form-thead">付款日期</div>
                    <div class="two wide column form-thead">现金</div>
                    <div class="two wide column form-thead">转账金额</div>
                    <div class="two wide column form-thead">其他金额</div>
                    <div class="two wide column form-thead">转账银行</div>
                    <div class="two wide column form-thead">转账账户</div>
                    <div class="two wide column form-thead">付款经办人</div>
                    <div class="one wide column form-thead">操作</div>
                </div>
                <transition-group name="slide-down" tag="div" class="form-wrap special-form">
                    <div class="ui column doubling stackable grid center aligned" v-for="(item, index) in postForm.lists" :key="index">
                        <div class="one wide column">
                            <div class="fake-input">@{{index+1}}</div>
                        </div>
                        <div class="two wide column">
                            <el-date-picker v-model="item.pay_date" type="date" placeholder="付款日期" value-format="yyyy-MM-dd">
                            </el-date-picker>
                        </div>
                        <div class="two wide column">
                            <input type="number" v-model.number="item.cash" placeholder="现金">
                        </div>
                        <div class="two wide column">
                            <input type="number" v-model.number="item.transfer" placeholder="转账金额">
                        </div>
                        <div class="two wide column">
                            <input type="number" v-model.number="item.other" placeholder="其他金额">
                        </div>
                        <div class="two wide column">
                            <el-select :value="item.bank" placeholder="转账银行" @change="selectBank($event, index)">
                                <el-option v-for="(item, index) in bankList" :key="item.id" :label="item.name + item.account" :value="item.id">
                                </el-option>
                            </el-select>
                        </div>
                        <div class="two wide column">
                            <div class="fake-input">@{{ item.account || '暂未选择' }}</div>
                        </div>
                        <div class="two wide column">
                            <input type="text" v-model="item.worker" placeholder="付款经办人">
                        </div>
                        <div class="one wide column">
                            <div class="fake-input">
                                <i class="icon minus red" style="cursor:pointer;" @click="deleteItem(item, index)"></i>
                            </div>
                        </div>
                    </div>
                </transition-group>
            </div>

            <div class="inline-center margin-top-20">
                <button class="ui button primary large" @click="submit">
                    <i class="icon hand pointer"></i>
                    <span>提交</span>
                </button>
            </div>

        </div>
    </div>
    <!-- /主体内容 === 不可复用 -->
@endsection
@section('pageJs')
    <script src="{{url('js/new_pay_pay.js')}}"></script>
@endsection