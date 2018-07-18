@extends('layouts.main_no_nav')
@section('title','修改密码')
@section('content')
    <!-- 没有导航的单独窗口页面 -->
    <div class="normal-content print-no-padding">

        <div class="ui breadcrumb">
            <a class="section">数据维护</a>
            <div class="divider"> / </div>
            <a class="section" href="{{url('user/list')}}">人员列表</a>
            <div class="divider"> / </div>
            <div class="active section">修改密码</div>
        </div>

        <h1 class="ui header blue aligned center">修改密码</h1>
        <div id="dataAuthAdd">
            <form method="post">
            <h4 class="ui dividing header blue">信息录入</h4>
            <div class="ui form">
                <div class="ui three column doubling stackable grid">
                    <div class="column">
                        <div class="inline fields">
                            <label class="six wide field flex-center">原密码</label>
                            <div class="eleven wide field">
                                {{--<input type="hidden" id="authId" value="{{$user->id}}">
                                --}}

                                {{--<input type="hidden" id="currentId" value="{{$user->id}}">--}}
                                {{--<input type="hidden" id="authName" value="{{$user->name}}">--}}
                                <input type="text" name="old"  placeholder="请输入原密码">
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="six wide field flex-center">新密码</label>
                            <div class="eleven wide field">
                                {{--<input type="hidden" id="authDepartment" value="{{$user->department}}">--}}
                                <input type="text" name="new"  placeholder="请输入新密码">
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="six wide field flex-center">确认密码</label>
                            <div class="eleven wide field">
                                {{--<input type="hidden" id="authNumber" value="{{$user->phone}}">--}}
                                <input type="text" name="confirm" placeholder="请输入确认密码">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="inline-center margin-top-20">
                <button class="ui button primary large" type="submit">
                    <i class="icon hand pointer"></i>
                    <span>确定</span>
                </button>
            </div>
            </form>
        </div>
    </div>
    <!-- /主体内容 === 不可复用 -->
@endsection
@section('pageJs')
{{--    <script src="{{url('js/data_auth_add.js')}}"></script>--}}
@endsection