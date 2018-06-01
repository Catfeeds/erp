@extends('layouts.main_no_nav')
@section('title','已立项清单')
@section('content')
    <!-- 没有导航的单独窗口页面 -->
    <div class="normal-content print-no-padding">

        <div class="ui breadcrumb">
            <a class="section">施工管理</a>
            <div class="divider"> / </div>
            <a class="section" href="../build/finish_list.html">完工请款清单</a>
            <div class="divider"> / </div>
            <div class="active section">请款查询 - {{$apply->number}}</div>
        </div>
        <input id="getId" type="hidden" value="{{$apply->id}}" />
        <h2 class="ui header aligned center">请款编号 - {{$apply->number}}</h2>
        <h4 class="ui dividing header blue">基本信息</h4>
        <div id="buildFinishSingle">
            <div class="ui form">
                <div class="ui three column doubling stackable grid">
                    <div class="column">
                        <div class="inline fields">
                            <label class="six wide field flex-center">施工队</label>
                            <div class="eleven wide field">
                                <div class="fake-input">{{$apply->team}}</div>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="six wide field flex-center">施工经理</label>
                            <div class="eleven wide field">
                                <div class="fake-input">{{$apply->manager}}</div>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="six wide field flex-center">项目编号</label>
                            <div class="eleven wide field">
                                <div class="fake-input">{{$apply->project_number}}</div>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="six wide field flex-center">项目内容</label>
                            <div class="eleven wide field">
                                <div class="fake-input">{{$apply->project_content}}</div>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="six wide field flex-center">项目经理</label>
                            <div class="eleven wide field">
                                <div class="fake-input">{{$apply->project_manager}}</div>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="six wide field flex-center">请款日期</label>
                            <div class="eleven wide field">
                                <div class="fake-input">{{$apply->request_date}}</div>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="six wide field flex-center">请款金额</label>
                            <div class="eleven wide field">
                                <div class="fake-input">{{number_format($apply->price,2)}} ￥</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <h4 class="ui dividing header blue">请款清单</h4>

            <table class="ui center aligned table selectable">
                <thead>
                <tr>
                    <th>序号</th>
                    <th>设备名称</th>
                    <th>性能参数</th>
                    <th>数量</th>
                    <th>单位</th>
                    <th>含税单价</th>
                    <th>含税总价</th>
                    <th>备注</th>
                </tr>
                </thead>
                <tbody>
                @foreach($lists as $list)
                <tr>
                    <td>{{$list->id}}</td>
                    <td>{{$list->name}}</td>
                    <td>{{$list->param}}</td>
                    <td>{{$list->number}}</td>
                    <td>{{$list->unit}}</td>
                    <td>{{number_format($list->price,2)}}</td>
                    <td>{{number_format($list->total,2)}} ￥</td>
                    <td>{{$list->remark}}</td>
                </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <th colspan="6">合计</th>
                    <th>{{number_format($apply->lists()->sum('total'),2)}} ￥</th>
                    <th></th>
                </tr>
                </tfoot>
            </table>

            <div class="flex-row flex-center margin-top-50" id="btnGroup">
                @if($apply->state<=3)
                <a class="ui icon button" href="{{url('build/finish/edit')}}?id={{$apply->id}}" style="margin:0 10px;">
                    <i class="icon edit"></i>
                    <span>修改</span>
                </a>
                    <button class="ui icon button negative" @click="removeFnc" style="margin:0 10px;">
                        <i class="icon delete"></i>
                        <span>删除</span>
                    </button>
                @else
                    @endif
                @if(checkRole('build_finish_check',$apply->id)&&$apply->state==1)
                <button class="ui icon button primary" @click="recheckFnc"  style="margin:0 10px;">
                    <i class="icon legal"></i>
                    <span>复核</span>
                </button>
                @else
                    @endif
                @if(checkRole('build_finish_pass',$apply->id)&&$apply->state==2)
                <a class="ui icon button primary"  @click="passFnc" style="margin:0 10px;">
                    <i class="icon edit"></i>
                    <span>审批</span>
                </a>
                @else
                    @endif

                <a class="ui icon button positive" href="javascript:_helper.fullWindow('{{url('build/finish/print')}}?id={{$apply->id}}')" style="margin:0 10px;">
                    <i class="icon print"></i>
                    <span>凭证</span>
                </a>
            </div>

            <div class="ui page dimmer">
                <div class="simple dimmer content">
                    <div class="center">
                        <div class="buy_dialog">
                            <div class="dialog_header">选择{{$apply->state==2?'复核':'审批'}}人</div>
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
    <script src="{{url('js/build_finish_single.js')}}"></script>
@endsection