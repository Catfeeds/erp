<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- 获取通用样式 -->
    <!-- 全局依赖 ==== 所有页面都要有 -->

    <link rel="stylesheet" type="text/css" href="{{url('plugins/semantic/semantic.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{url('plugins/element-ui/index.css')}}">
    <!-- <link rel="stylesheet" href="../../plugins/nprogress/nprogress.css"> -->
    <link rel="stylesheet" type="text/css" href="{{url('css/erp.css')}}">
    <script src="{{url('plugins/jquery/jquery.3.2.1.min.js')}}"></script>
    <script src="{{url('layer/layer.js')}}"></script>
    <!-- /全局依赖 -->
    <!-- 获取通用样式 -->

    <title>登录</title>
</head>

<body id="login">
<div class="ui middle aligned center aligned grid">
    <div class="column">
        <h2 class="ui blue image header">
            <div class="content">登录</div>
        </h2>
        <form method="post" class="ui large form ">
            <div class="ui stacked segment">
                <div class="field">
                    <div class="ui left icon input">
                        <i class="user icon"></i>
                        <input id="phoneValidate" type="text" name="username" placeholder="输入用户名">
                    </div>
                </div>
                <div class="field">
                    <div class="ui left icon input">
                        <i class="lock icon"></i>
                        <input type="password" name="password" placeholder="输入密码">
                    </div>
                </div>
                {{--<div class="field">--}}
                    {{--<div class="ui left icon input action">--}}
                        {{--<i class="keyboard icon"></i>--}}
                        {{--<input type="text" name="sms" placeholder="验证码">--}}
                        {{--<div class="ui button disabled blue" id="smsBtn">获取验证码</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
                <div class="ui fluid large blue submit button">登录</div>
            </div>

            <div class="ui error message"></div>

        </form>
    </div>
    @include('layouts.error')
</div>

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
<!-- <script src="../../src/js/api.js"></script> -->
<script src="{{url('js/schema.js')}}"></script>
<script src="{{url('js/global.js')}}"></script>
<!-- / 全局依赖 js === 通用 -->


<!-- 独立 js === 每个页面独有-->
<script src="{{url('js/login.js')}}"></script>
<!-- /独立 js -->
</body>

</html>