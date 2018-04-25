@extends('layouts.main')
@section('title','首页')
@section('content')
    <!-- 主体内容 === 不可复用 -->
    <div class="index-content print-no-padding">
        <div class="ui breadcrumb">
            <a class="section">首页</a>
            <div class="divider"> / </div>
            <div class="active section">待处理事项清单</div>
        </div>

        <div class="invisible margin-top-20" id="indexPending">
            <table class="ui center aligned table selectable">
                <thead>
                <tr>
                    <th>序号</th>
                    <th>业务品种</th>
                    <th>业务编号</th>
                    <th>系统状态</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($tasks as $task)
                <template >
                    <tr>
                        <td>{{$task->id}}</td>
                        <td>{{$task->title}}</td>
                        <td>{{$task->number}}</td>
                        <td>待处理</td>
                        <td>
                            <a class="ui mini button positive" href="{{url($task->url)}}">查看</a>
                        </td>
                    </tr>
                </template>
                @endforeach

                <template v-else>
                    <tr>
                        <td colspan="5">暂无数据</td>
                    </tr>
                </template>

                </tbody>
            </table>
        </div>

    </div>
    <!-- /主体内容 === 不可复用 -->
@endsection
@section('pageJs')
    <script src="{{url('js/index.js')}}"></script>
@endsection
