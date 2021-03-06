@extends('layouts.main')
@section('title','新增项目成本报销')
@section('content')
    <!-- 没有导航的单独窗口页面 -->
    <div class="normal-content print-no-padding">

        <div class="ui breadcrumb">
            <a class="section">报销与借款管理</a>
            <div class="divider"> / </div>
            <a class="section" href="{{url('loan/submit/list')}}" >报销申请清单</a>
            <div class="divider"> / </div>
            <div class="active section">新增项目成本报销</div>
        </div>
        @if(!empty($submit))
        <input type="hidden" id="loanUser" value="{{$submit->loan_user}}">
        <input type="hidden" id="date" value="{{$submit->date}}">
        <input type="hidden" id="topAmount" value="{{$submit->price}}">
        <input type="hidden" id="projectId" value="{{$submit->project_id}}">
        <input type="hidden" id="Id" value="{{$submit->id}}">
        <input type="hidden" id="projectNumber" value="{{\App\Models\Project::find($submit->project_id)->number}}">
        <input type="hidden" id="projectContent" value="{{\App\Models\Project::find($submit->project_id)->name}}">
        <div style="display: none;" id="lists">{{json_encode($lists)}}</div>
        @else
            <input type="hidden" id="loanUser" value="{{\Illuminate\Support\Facades\Auth::user()->username}}">
        @endif
        <h1 class="ui header blue aligned center">新增项目成本报销</h1>
        <div id="loanSubmitOther">
            <h4 class="ui dividing header blue">信息录入</h4>
            <div class="ui form">
                <div class="ui three column doubling stackable grid">
                    <div class="column">
                        <div class="inline fields">
                            <label class="six wide field flex-center">报销人</label>
                            <div class="eleven wide field">
                                <input type="text" v-model="submitProjectForm.loan_user" placeholder="请输入报销人">
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="six wide field flex-center">报销日期</label>
                            <div class="eleven wide field">
                                <el-date-picker v-model="submitProjectForm.date" type="date" placeholder="请选择报销日期" value-format="yyyy-MM-dd">
                                </el-date-picker>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="six wide field flex-center">报销金额</label>
                            <div class="eleven wide field">
                                <input type="number" v-model.number="submitProjectForm.price" placeholder="请选择报销金额">
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="six wide field flex-center">项目编号</label>
                            <div class="eleven wide field">
                                <el-autocomplete popper-class="my-autocomplete" v-model="submitProjectForm.project_number" :fetch-suggestions="querySearchProjectId"
                                                 placeholder="请输入项目编号" @select="handleSelectProjectId">
                                    <i class="el-icon-edit el-input__icon" slot="suffix">
                                    </i>
                                    <template slot-scope="props">
                                        <div class="name" :title="props.item.name">@{{ props.item.number }}</div>
                                        <span class="addr" :title="props.item.name">@{{ props.item.name }}</span>
                                    </template>
                                </el-autocomplete>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="six wide field flex-center">项目内容</label>
                            <div class="eleven wide field">
                                <el-autocomplete popper-class="my-autocomplete" v-model="submitProjectForm.project_content" :fetch-suggestions="querySearchProjectContent"
                                                 placeholder="请输入项目内容" @select="handleSelectProjectContent">
                                    <i class="el-icon-edit el-input__icon" slot="suffix">
                                    </i>
                                    <template slot-scope="props">
                                        <div class="name" :title="props.item.name">@{{ props.item.name }}</div>
                                        <span class="addr" :title="props.item.name">@{{ props.item.number }}</span>
                                    </template>
                                </el-autocomplete>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <h4 class="ui dividing header blue">报销单据录入</h4>
            <div class="flex-row">
                <el-select @change="typeChange" style="width:250px;margin-right:30px;" v-model="paymentData.currentTypeIndex" placeholder="请选择费用类别">
                    <el-option v-for="(item, index) in paymentData.typeList" :key="item.id" :label="item.title" :value="index">
                    </el-option>
                </el-select>
                <el-select @change="detailTypeChange" style="width:250px;margin-right:30px;" v-model="paymentData.currentDetailTypeIndex"
                           placeholder="请选择具体事项">
                    <el-option v-for="(item, index) in paymentData.detailTypeList" :key="item.id" :label="item.title" :value="index">
                    </el-option>
                </el-select>
                <button class="ui button positive" @click="addItem">新增单据</button>
            </div>
            <h4 class="inline-center">报销单据清单</h4>
            <h5 class="ui header right aligned">合计总额：@{{ sumAmount.toLocaleString('en-US') }} ￥</h5>
            <div class="ui form form-item">
                <div class="ui five column doubling stackable grid font-size-13">
                    <div class="one wide column form-thead">序号</div>
                    <div class="three wide column form-thead">费用类别</div>
                    <div class="three wide column form-thead">具体事项</div>
                    <div class="three wide column form-thead">备注</div>
                    <div class="two wide column form-thead">单据张数</div>
                    <div class="two wide column form-thead">金额</div>
                    <div class="two wide column form-thead">操作</div>
                </div>
                <transition-group name="slide-down" tag="div" class="form-wrap special-form">
                    <div class="ui column doubling stackable grid center aligned" v-for="(item, index) in submitProjectForm.lists" :key="item.id">
                        <div class="one wide column">
                            <div class="fake-input">@{{ index + 1 }}</div>
                        </div>
                        <div class="three wide column">
                            <div class="fake-input">@{{ item.type }}</div>
                        </div>
                        <div class="three wide column">
                            <div class="fake-input">@{{ item.detailType }}</div>
                        </div>
                        <div class="three wide column">
                            <input type="text" v-model="item.remark" placeholder="备注">
                        </div>
                        <div class="two wide column">
                            <input type="number" v-model.number="item.number" placeholder="单据张数">
                        </div>
                        <div class="two wide column">
                            <input type="number" v-model.number="item.price" placeholder="金额">
                        </div>
                        <div class="two wide column flex-row">
                            <div class="fake-input">
                                <i class="icon minus red" style="cursor:pointer;" @click="deleteItem('lists', item, index)"></i>
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

            <div class="ui page dimmer">
                <div class="simple dimmer content">
                    <div class="center">
                        <div class="buy_dialog">
                            <div class="dialog_header">选择复核人</div>
                            <div class="dialog_content">
                                <el-checkbox-group v-model="checkedMen" @change="handleCheckManChange">
                                    <el-checkbox v-for="man in menList" :label="man.id" :key="man.id">@{{man.name}}</el-checkbox>
                                </el-checkbox-group>
                            </div>
                            <div class="diolag_footer">
                                <button class="ui button primary" @click="confirmRecheck">确 定</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /主体内容 === 不可复用 -->
@endsection
@section('pageJs')
    <script src="{{url('js/loan_submit_project.js')}}"></script>
@endsection