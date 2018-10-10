@extends('layouts.main_no_nav')
@section('title','已立项清单')
@section('content')
    <!-- 没有导航的单独窗口页面 -->
    <div class="normal-content print-no-padding">

        <div class="ui breadcrumb">
            <a class="section">施工管理</a>
            <div class="divider"> / </div>
            <a class="section" >施工付款款清单</a>
            <div class="divider"> / </div>
            {{--<div class="active section">付款查询 - SGFK20171103001</div>--}}
        </div>

        <h4 class="ui dividing header blue">基本信息</h4>
        <div class="ui form">
            <div class="ui three column doubling stackable grid">
                <div class="column">
                    <div class="inline fields">
                        <label class="six wide field flex-center">施工队</label>
                        <div class="eleven wide field">
                            <div class="fake-input">{{$contract->team}}</div>
                        </div>
                    </div>
                </div>
                <div class="column">
                    <div class="inline fields">
                        <label class="six wide field flex-center">施工经理</label>
                        <div class="eleven wide field">
                            <div class="fake-input">{{$contract->manager}}</div>
                        </div>
                    </div>
                </div>
                <div class="column">
                    <div class="inline fields">
                        <label class="six wide field flex-center">项目经理</label>
                        <div class="eleven wide field">
                            <div class="fake-input">{{$contract->project_manager}}</div>
                        </div>
                    </div>
                </div>
                <div class="column">
                    <div class="inline fields">
                        <label class="six wide field flex-center">项目编号</label>
                        <div class="eleven wide field">
                            <div class="fake-input">{{$contract->project_number}}</div>
                        </div>
                    </div>
                </div>
                <div class="column">
                    <div class="inline fields">
                        <label class="six wide field flex-center">项目内容</label>
                        <div class="eleven wide field">
                            <div class="fake-input">{{$contract->project_content}}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <h4 class="ui dividing header blue">合同列表</h4>

        <table class="ui celled center aligned table selectable unstackable">

            <tbody>
            @foreach($pictures as $picture)
                <tr>
                    {{--<td>{{$i+1}}</td>--}}
                    <td>{{$picture->name}}</td>
                    {{--<td>{{$types[$i]->rate}}%</td>--}}
                    <td>
                        <a class="ui mini button primary" href="javascript:_helper.fullWindow('{{url($picture->href)}}')">查看</a>
                        {{--<button class="ui mini button negative dataTypeDelete" data-id="{{$types[$i]->id}}">删除</button>--}}
                    </td>
                </tr>
            @endforeach
            </tbody>

        </table>




    </div>


    <!-- /主体内容 === 不可复用 -->
@endsection
@section('pageJs')
    {{--<script src="{{url('js/build_pay_single.js')}}"></script>--}}
@endsection