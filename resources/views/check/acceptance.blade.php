@extends('layouts.main')
@section('title','验收录入')
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
            <div class="active section">验收录入</div>
        </div>

        <input type="hidden" id="getProjectId" value="{{$project->id}}">

        <h4 class="ui dividing header blue">基本信息</h4>

        <div class="invisible" id="checkAcceptance">

            <!-- 基本信息 -->
            <div class="ui form form-item">
                <div class="ui three column doubling stackable grid">
                    <div class="column">
                        <div class="inline fields">
                            <label class="four wide field">项目编号</label>
                            <div class="twelve wide field">
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
                            <label class="four wide field">合同约定完工日期</label>
                            <div class="twelve wide field">
                                <div class="fake-input">{{date('Y-m-d',$project->finishTime)}}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- / 基本信息 -->

            <!-- 验收 -->
            <h4 class="ui dividing header blue">验收</h4>
            <div class="ui form form-item">
                <div class="ui two column doubling stackable grid">
                    <div class="column">
                        <div class="inline fields">
                            <label class="four wide field">验收日期</label>
                            <div class="twelve wide field">
                                <el-date-picker v-model="acceptanceForm.acceptance_date" type="date" placeholder="请选择验收日期" value-format="yyyy-MM-dd">
                                </el-date-picker>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="four wide field">备注</label>
                            <div class="twelve wide field">
                                <input v-model="acceptanceForm.remark" type="text" placeholder="请输入备注">
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <el-checkbox v-model="acceptanceForm.to_warranty">验收完毕项目进入保修期</el-checkbox>
                    </div>
                </div>
            </div>
            <!-- / 验收 -->

            <!-- 项目维护 -->
            <transition name="slide-down">
                <h4 class="ui dividing header blue" v-if="acceptanceForm.to_warranty">项目维护</h4>
            </transition>
            <transition name="slide-down">
                <div class="ui form form-item" v-if="acceptanceForm.to_warranty">
                    <div class="ui two column doubling stackable grid">
                        <div class="column">
                            <div class="inline fields">
                                <label class="four wide field">项目维护条件</label>
                                <div class="twelve wide field">{{$project->condition}}</div>
                            </div>
                        </div>
                        <div class="column">
                            <div class="inline fields">
                                <label class="four wide field">保修截至日期</label>
                                <div class="twelve wide field">
                                    <el-date-picker v-model="acceptanceForm.deadline" type="date" placeholder="请选择保修截至日期" value-format="yyyy-MM-dd">
                                    </el-date-picker>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </transition>
            <!-- / 项目维护 -->
            <div class="inline-center margin-top-20">
                <button class="ui button green large" @click="submit">
                    <i class="icon hand pointer"></i>
                    <span>提交</span>
                </button>
            </div>
        </div>

    </div>
    <!-- /主体内容 === 不可复用 -->
@endsection
@section('pageJs')
    <script src="{{url('js/check_acceptance.js')}}"></script>
@endsection