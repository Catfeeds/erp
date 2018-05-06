@extends('layouts.main_no_nav')
@section('title','已立项清单')
@section('content')

    <!-- 没有导航的单独窗口页面 -->
    <div class="normal-content print-no-padding">

        <style>
            html,
            body {
                position: relative;
                height: 100%;
            }

            body {
                background: #eee;
                font-family: Helvetica Neue, Helvetica, Arial, sans-serif;
                font-size: 14px;
                color: #000;
                margin: 0;
                padding: 0;
            }

            .swiper-container {
                width: 100%;
                height: 100%;
            }

            .swiper-slide {
                text-align: center;
                font-size: 18px;
                background: #fff;

                /* Center slide text vertically */
                display: -webkit-box;
                display: -ms-flexbox;
                display: -webkit-flex;
                display: flex;
                -webkit-box-pack: center;
                -ms-flex-pack: center;
                -webkit-justify-content: center;
                justify-content: center;
                -webkit-box-align: center;
                -ms-flex-align: center;
                -webkit-align-items: center;
                align-items: center;
            }

            .hetong-img {
                height: 85%;
            }
        </style>
        <link rel="stylesheet" type="text/css" href="{{url('plugins/swiper/swiper-4.2.2.min.css')}}">

        <!-- Swiper -->
        <div class="swiper-container" style="position: fixed;top: 0;left: 0">
            <div class="swiper-wrapper">
                @foreach($pictures as $picture)
                <div class="swiper-slide">
                    <img class="hetong-img" src="{{$picture->href}}" >
                </div>
                    @endforeach
            </div>
            <!-- Add Pagination -->
            <div class="swiper-pagination"></div>
        </div>

        <!-- Swiper JS -->
        <script src="{{url('plugins/swiper/swiper-4.2.2.min.js')}}"></script>

    </div>
    <!-- /主体内容 === 不可复用 -->
@endsection
@section('pageJs')
    <script src="{{url('js/build_detail_single.js')}}"></script>
@endsection