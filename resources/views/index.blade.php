@extends('layouts.main')
@section('title','首页')
@section('content')
<div id="test">test</div>
<div>这是具体内容</div>
@endsection
@section('pageJs')
    <script src="{{url('js/index.js')}}"></script>
@endsection
