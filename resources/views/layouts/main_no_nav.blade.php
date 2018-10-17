<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- 全局依赖 ==== 所有页面都要有 -->
    <script src="{{url('plugins/jquery/jquery.3.2.1.min.js')}}"></script>
    <script src="{{url('layer/layer.js')}}"></script>
    <link rel="stylesheet" type="text/css" href="{{url('plugins/semantic/semantic.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{url('plugins/element-ui/index.css')}}">
    <!-- <link rel="stylesheet" href="../../plugins/nprogress/nprogress.css"> -->
    <link rel="stylesheet" type="text/css" href="{{url('css/erp.css')}}">
    <script src="{{url('plugins/jquery/jquery.3.2.1.min.js')}}"></script>
    <script src="{{url('plugins/bignumber/bignumber.min.js')}}"></script>
    <script src="{{url('layer/layer.js')}}"></script>
    <!-- /全局依赖 -->

    <title>@yield('title')</title>
</head>

<body>
<!-- 通用布局 === 复用 -->
<div class="index-navbar ui menu blue-background print-hide">
    <a href="{{url('')}}">
    <span  id="sidebarBtn" class="index-navbar-item-left pull-left">
      <i class="sidebar icon"></i>
{{--        <a href="{{url('')}}" class="item">--}}
      <span >广东思域</span>
        {{--</a>--}}
    </span>
        </a>
    <div class="index-navbar-item-show right menu">
        <a class="item" href="{{url('')}}">
            <i class="home icon"></i>
            <span>首页</span>
        </a>
        <a class="item">
            <i class="user icon"></i>
            <span>{{\Illuminate\Support\Facades\Auth::user()->name}}</span>
        </a>
        <a class="item" href="{{url('modify/password')}}">
            <i class="user icon"></i>
            <span>修改密码</span>
        </a>

        <a class="item" href="{{url('logout')}}">
            <i class="power icon"></i>
            <span>退出</span>
        </a>
    </div>
    <div class="index-navbar-item-hidden margin-right ui dropdown">操作
        <i class="dropdown icon"></i>
        <div class="menu">
            <a class="item" href="#">
                <i class="user icon"></i>
                <span>管理员</span>
            </a>
            <a class="item" href="{{url('logout')}}">
                <i class="power icon"></i>
                <span>退出</span>
            </a>
        </div>
    </div>
</div>
<!-- /通用布局 -->

@yield('content')
@include('layouts.error')
<!-- 全局依赖 js === 通用 -->

<script src="{{url('plugins/vue/vue.min.js')}}"></script>
<script src="{{url('plugins/semantic/semantic.min.js')}}"></script>
<script src="{{url('plugins/element-ui/index.min.js')}}"></script>
<!-- <script src="../../plugins/lodash/lodash.min.js"></script> -->
<script src="{{url('plugins/axios/axios.min.js')}}"></script>
<script src="{{url('plugins/axios/qs.min.js')}}"></script>
<!-- <script src="../../plugins/nprogress/nprogress.js"></script> -->
<!-- <script src="../../plugins/layDate/laydate.js"></script> -->
<script src="{{url('js/helper.js')}}"></script>
<script src="{{url('js/api.js')}}"></script>
<script src="{{url('js/schema.js')}}"></script>
<script src="{{url('js/global.js')}}"></script>
<!-- / 全局依赖 js === 通用 -->
<!-- 独立 js -->
@yield('pageJs')
<!-- / 独立 js -->
</body>

</html>