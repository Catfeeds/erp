@extends('layouts.main')
@section('title','新增物料')
@section('content')
    <!-- 没有导航的单独窗口页面 -->
    <div class="normal-content print-no-padding">

        <div class="ui breadcrumb">
            <a class="section">数据维护</a>
            <div class="divider"> / </div>
            <a class="section" href="{{url('material/list')}}" >物料列表</a>
            <div class="divider"> / </div>
            <div class="active section">新增物料</div>
        </div>

        <h1 class="ui header blue aligned center">新增物料</h1>
        <div id="dataMaterialAdd">
            <h4 class="ui dividing header blue">信息录入</h4>
            <div class="ui form">
                <div class="ui three column doubling stackable grid">
                    <div class="column">
                        <div class="inline fields">
                            <label class="six wide field flex-center">物料名称</label>
                            <div class="fifteen wide field">
                                <input type="hidden" id="materialId" value="{{$material->id}}">
                                <input type="hidden" id="materialName"  value="{{$material->name}}">
                                <!-- <input type="text" v-model="materialForm.name" placeholder="请输入物料名称"> -->
                                <el-autocomplete popper-class="my-autocomplete" v-model="materialForm.name" :fetch-suggestions="querySearchMaterial" placeholder="请输入物料名称"
                                                 @select="handleSelectMaterial">
                                    <i class="el-icon-edit el-input__icon" slot="suffix">
                                    </i>
                                    <template slot-scope="props" style="cursor: not-allowed;">
                                        <div class="name">@{{ props.item.name }}</div>
                                        <span class="addr">@{{ props.item.model }} @{{ props.item.factory }}</span>
                                        <div class="addr name" :title="props.item.param">@{{ props.item.param }}</div>
                                    </template>
                                </el-autocomplete>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="six wide field flex-center">性能与技术参数</label>
                            <div class="eleven wide field">
                                <input type="hidden" id="materialParam" value="{{$material->param}}">
                                <input type="text" v-model="materialForm.param" placeholder="请输入性能与技术参数">
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="six wide field flex-center">品牌型号</label>
                            <div class="eleven wide field">
                                <input type="hidden" id="materialModel" value="{{$material->model}}">
                                <input type="text" v-model="materialForm.model" placeholder="请输入品牌型号">
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="six wide field flex-center">生产厂家</label>
                            <div class="eleven wide field">
                                <input type="hidden" id="materialFactor" value="{{$material->factory}}">
                                <input type="text" v-model="materialForm.factory" placeholder="请输入生产厂家">
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="inline fields">
                            <label class="six wide field flex-center">单位</label>
                            <div class="eleven wide field">
                                <input type="hidden" id="materialUnit" value="{{$material->unit}}">
                                <input type="text" v-model="materialForm.unit" placeholder="请输入单位">
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
    <script src="{{url('js/data_material_add.js')}}"></script>
@endsection