@extends('layouts.main')
@section('title','报销与借款清单')
@section('content')
    <!-- 主体内容 === 不可复用 -->
    <div class="index-content print-no-padding">

        <div class="ui breadcrumb">
            <a class="section">报销与借款管理</a>
            <div class="divider"> / </div>
            <div class="active section">报销与借款清单</div>
        </div>


        <div class="content-wrap table-head-nowrap">
            <table class="ui center aligned table selectable unstackable">
                <thead>
                <tr>
                    <th>人员</th>
                    <th>借款余额</th>
                    <th>未支付报销余额</th>
                </tr>
                </thead>
                <tbody>
                @if(count($lists)!=0)
                @foreach($lists as $list)
                <tr>
                    <td>{{$list['name']}}</td>
                    <td>{{number_format($list['loan_price'],2)}}</td>
                    <td>{{number_format($list['submit_price'],2)}}</td>
                </tr>
                @endforeach
                    @else
                    <tr>
                        <td colspan="3">暂无数据</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
        {{--{{$lists->links()}}--}}
    </div>
    <!-- /主体内容 === 不可复用 -->
@endsection
@section('pageJs')
    <script src="{{url('js/loan_list.js')}}"></script>
@endsection