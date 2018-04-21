@extends('layouts.main_no_nav')
@section('title','已立项清单')
@section('content')
    <!-- 没有导航的单独窗口页面 -->
    <div class="normal-content print-no-padding">

        <div class="ui breadcrumb">
            <a class="section">报销与借款管理</a>
            <div class="divider"> / </div>
            <a class="section" href="{{url('loan/submit/list')}}">报销申请清单</a>
            <div class="divider"> / </div>
            <div class="active section">报销申请查询 - {{$loan->number}}</div>
        </div>
        <input type="hidden" id="type" value="{{$loan->type}}">
        <input type="hidden" id="projectId" value="{{$loan->project_id}}">
        <input type="hidden" id="loanId" value="{{$loan->id}}">
        <h3 class="ui header center aligned">报销申请查询 - {{$loan->number}}</h3>
        <table class="ui celled center aligned table selectable">
            <thead>
            <tr>
                <th>报销编号</th>
                <th class="fake-td">{{$loan->number}}</th>
                <th>报销日期</th>
                <th class="fake-td">{{$loan->date}}</th>
                <th>报销金额</th>
                <th class="fake-td">{{$loan->price}}￥</th>
            </tr>
            @if($loan->project_id!=0)
            <tr>
                <th>项目编号</th>
                <th class="fake-td">{{\App\Models\Project::find($loan->project_id)->number}}</th>
                <th>项目内容</th>
                <th colspan="3" class="fake-td">{{\App\Models\Project::find($loan->project_id)->name}}</th>
            </tr>
            @else
                @endif

            <tr>
                <th>报销人</th>
                <th class="fake-td">黄其中</th>
                <th>复核人</th>
                <th class="fake-td">刘科奇</th>
                <th>审批人</th>
                <th class="fake-td">陈子欣</th>
            </tr>
            <tr>
                <th>报销单据</th>
                <th>费用类别</th>
                <th>具体事项</th>
                <th>备注</th>
                <th>单据张数</th>
                <th>金额</th>
            </tr>
            </thead>
            <tbody>
            @foreach($loan->lists as $list)
            <tr>
                <td>{{$list->id}}</td>
                <td>{{\App\Models\Category::find($list->category_id)->title}}</td>
                @if($list->kind_id!=0)
                <td>{{\App\Models\Detail::find($list->kind_id)->title}}</td>
                @else
                    <td></td>
                    @endif
                <td>{{$list->remark}}</td>
                <td>{{$list->number}}</td>
                <td>{{$list->price}}￥</td>
            </tr>
            @endforeach
            </tbody>
            <tfoot>
            <tr>
                <th colspan="5">合计</th>
                <th>{{$loan->lists()->sum('price')}}￥</th>
            </tr>
            </tfoot>
        </table>

        <div class="flex-row flex-center margin-top-50">
            <a class="ui icon button" href="javascript:_helper.fullWindow('../loan/submit_add.html?id=1')" style="margin:0 20px;">
                <i class="icon edit"></i>
                <span>修改</span>
            </a>
            <button class="ui icon button primary" id="submitSingleCheck" style="margin:0 20px;">
                <i class="icon legal"></i>
                <span>复核</span>
            </button>
            <a class="ui icon button primary" id="submitSinglePass" style="margin:0 20px;">
                <i class="icon edit"></i>
                <span>审批</span>
            </a>
            <a class="ui icon button positive" href="javascript:_helper.fullWindow('../loan/submit_print.html?id=1')" style="margin:0 20px;">
                <i class="icon print"></i>
                <span>凭证</span>
            </a>
        </div>


        <div class="ui page dimmer" id="submitSingleDialog">
            <div class="simple dimmer content">
                <div class="center">
                    <div class="buy_dialog">
                        <div class="dialog_header">选择审批人</div>
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
    <!-- /主体内容 === 不可复用 -->
@endsection
@section('pageJs')
    <script src="{{url('js/loan_submit_single.js')}}"></script>
@endsection