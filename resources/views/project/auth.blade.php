@extends('layouts.main_no_nav')
@section('title','项目权限设置')
@section('content')
    <!-- 没有导航的单独窗口页面 -->
    <div class="normal-content print-no-padding">

        <div class="ui breadcrumb">
            <a class="section">项目立项管理</a>
            <div class="divider"> / </div>
            <a class="section" href="{{url('project/detail')}}" >项目明细清单</a>
            <div class="divider"> / </div>
            <div class="active section">权限设置 - {{$project->number}}</div>
        </div>

        <div style="display: none" id="person">{{json_encode($users)}}</div>
        <input type="hidden" value="{{$project->id}}" id="projectId">

        <h4 class="ui dividing header blue">项目基本信息</h4>
        <div class="ui form form-item">
            <div class="ui three column doubling stackable grid">
                <div class="column">
                    <div class="inline fields">
                        <label class="four wide field">项目号</label>
                        <div class="twelve wide field">
                            <div class="fake-input">{{$project->number}}</div>
                        </div>
                    </div>
                </div>
                <div class="column">
                    <div class="inline fields">
                        <label class="four wide field">立项日期</label>
                        <div class="twelve wide field">
                            <div class="fake-input">{{date('Y-m-d',$project->createTime)}}</div>
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
                        <label class="four wide field">项目经理</label>
                        <div class="twelve wide field">
                            <div class="fake-input">{{$project->pm}}</div>
                        </div>
                    </div>
                </div>
                <div class="column">
                    <div class="inline fields">
                        <label class="four wide field">预计完工日期</label>
                        <div class="twelve wide field">
                            <div class="fake-input">{{date('Y-m-d',$project->finishTime)}}</div>
                        </div>
                    </div>
                </div>
                <div class="column">
                    <div class="inline fields">
                        <label class="four wide field">保修截止日期</label>
                        <div class="twelve wide field">
                            <div class="fake-input">{{$project->deadline}}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 第一项 -->
        <h4 class="ui dividing header blue">立项日期
            <span style="margin: 0 30px;">{{date('Y-m-d',$project->createTime)}}至预计完工日期{{date('Y-m-d',$project->finishTime)}}</span> 权限设置情况</h4>
        <div style="text-align: right;">
            <button class="ui button positive auth-add" data-type="1">新增人员</button>
        </div>
        <table class="ui center aligned table unstackable">
            <thead>
            <tr>
                {{--<th></th>--}}
                <th>开放人员</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach($lists1 as $item)
            <tr>
                {{--<td>{{$item->id}}</td>--}}
                <td>{{\App\User::find($item->user_id)->name}}</td>
                <td>
                    <a href="javascript:_helper.fullWindow('{{url('project/auth/edit')}}?user_id={{$item->user_id}}&&type=1&&project_id={{$project->id}}')" class="ui primary mini button">查询权限设置</a>
                    <a href="javascript:_helper.fullWindow('{{url('project/auth/del')}}?user_id={{$item->user_id}}&&type=1&&project_id={{$project->id}}')" class="ui primary mini button">删除</a>
                    {{--<button class="ui negative mini button auth-delete" data-id="{{$item->id}}">删除</button>--}}
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
        <!-- /第一项 -->

        <!-- 第二项 -->
        <h4 class="ui dividing header blue">验收日期
            <span style="margin: 0 30px;">{{$project->acceptance_date}}至保修截止日期{{$project->deadline}}</span> 权限设置情况</h4>
        <div style="text-align: right;">
            <button class="ui button positive auth-add" data-type="2">新增人员</button>
        </div>
        <table class="ui center aligned table unstackable">
            <thead>
            <tr>
                <th></th>
                <th>开放人员</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach($lists2 as $item)
            <tr>
                {{--<td>{{$item->id}}</td>--}}
                <td>{{\App\User::find($item->user_id)->name}}</td>
                <td>
                    <a href="javascript:_helper.fullWindow('{{url('project/auth/edit')}}?user_id={{$item->user_id}}&&type=2&&project_id={{$project->id}}')" class="ui primary mini button">查询权限设置</a>
                    <a href="javascript:_helper.fullWindow('{{url('project/auth/del')}}?user_id={{$item->user_id}}&&type=2&&project_id={{$project->id}}')" class="ui primary mini button">删除</a>
                    <button class="ui negative mini button auth-delete" data-id="{{$item->id}}">删除</button>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
        <!-- /第二项 -->
        <!-- 第三项 -->
        <h4 class="ui dividing header blue">保修截止日期
            <span style="margin: 0 30px;">{{$project->deadline}}至{{date('Y-m-d',strtotime($project->deadline)+63158400)}}</span> 权限设置情况</h4>
        <div style="text-align: right;">
            <button class="ui button positive auth-add" data-type="3">新增人员</button>
        </div>
        <table class="ui center aligned table unstackable">
            <thead>
            <tr>
                <th></th>
                <th>开放人员</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach($lists3 as $item)
            <tr>
                {{--<td>1</td>--}}
                <td>{{\App\User::find($item->user_id)->name}}</td>
                <td>
                    <a href="javascript:_helper.fullWindow('.{{url('project/auth/edit')}}?user_id={{$item->user_id}}&&type=3&&project_id={{$project->id}}')" class="ui primary mini button">查询权限设置</a>
                    <a href="javascript:_helper.fullWindow('.{{url('project/auth/del')}}?user_id={{$item->user_id}}&&type=3&&project_id={{$project->id}}')" class="ui primary mini button">删除</a>
                    <button class="ui negative mini button auth-delete " data-id="{{$item->id}}">删除</button>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
        <!-- /第三项 -->


        <div class="ui page dimmer" id="memberChoose">
            <div class="content">
                <div class="center">
                    <div class="buy_dialog">
                        <div class="dialog_header">选择人员</div>
                        <div class="dialog_content">
                            <el-radio-group v-model="checkedMen" @change="handleCheckManChange">
                                <el-radio v-for="man in menList" :label="man.id" :key="man.id">@{{man.name}}</el-radio>
                            </el-radio-group>
                        </div>
                        <div class="diolag_footer">
                            <button class="ui button negative" @click="cancelClick">取 消</button>
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
    <script src="{{url('js/project_auth.js')}}"></script>
@endsection