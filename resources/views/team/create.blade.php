@extends('layouts.main')
@section('title','新增施工队')
@section('content')
    <!-- 没有导航的单独窗口页面 -->
    <div class="normal-content print-no-padding">

        <div class="ui breadcrumb">
            <a class="section">数据维护</a>
            <div class="divider"> / </div>
            <a class="section" >施工队列表</a>
            <div class="divider"> / </div>
            <div class="active section">新增施工队</div>
        </div>

        <h1 class="ui header blue aligned center">新增施工队</h1>
        <div id="dataTeamAdd">
            <h4 class="ui dividing header blue">信息录入</h4>
            <div class="ui form">
                <div class="ui three column doubling stackable grid">
                    <div class="column">
                        <div class="inline fields">
                            <label class="six wide field flex-center">施工队名称</label>
                            <div class="eleven wide field">
                                <input type="hidden" id="teamId" value="{{$team->id}}">
                                <input type="hidden" id="teamName" value="{{$team->name}}">
                                <input type="text" v-model="teamForm.name" placeholder="请输入施工队名称">
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="six wide field flex-center">施工队经理</label>
                            <div class="eleven wide field">
                                <input type="hidden" id="teamManager" value="{{$team->manager}}">
                                <input type="text" v-model="teamForm.manager" placeholder="请输入施工队经理">
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="six wide field flex-center">开户银行</label>
                            <div class="eleven wide field">
                                <input type="hidden" id="teamBank" value="{{$team->bank}}">
                                <input type="text" v-model="teamForm.bank" placeholder="请输入开户银行">
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="six wide field flex-center">账号</label>
                            <div class="eleven wide field">
                                <input type="hidden" id="teamAccount" value="{{$team->account}}">
                                <input type="text" v-model="teamForm.account" placeholder="请输入账号">
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
    <script src="{{url('js/data_team_add.js')}}"></script>
@endsection