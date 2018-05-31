@extends('layouts.main')
@section('title','已立项清单')
@section('content')
    <!-- 主体内容 === 不可复用 -->
    <div class="index-content print-no-padding">

        <div class="ui breadcrumb">
            <a class="section">采购管理</a>
            <div class="divider"> / </div>
            <div class="active section">物料采购比价</div>
        </div>

        <!-- 操作 -->
        <h4 class="ui dividing header blue">录入基本信息</h4>
        <div class="content-operation invisible" id="buyParityForm">
            <form action="">
                <div class="ui form">
                    <div class="ui three column doubling stackable grid">
                        <div class="column">
                            <div class="inline fields">
                                <label class="six wide field flex-center">物料名称</label>
                                <div class="ten wide field">
                                    <el-autocomplete popper-class="my-autocomplete" name="name" v-model="currentMaterialName" :fetch-suggestions="querySearch"
                                                     placeholder="请输入物料名称" @select="handleSelect">
                                        <i class="el-icon-edit el-input__icon" slot="suffix">
                                        </i>
                                        <template slot-scope="props">
                                            <div class="name">@{{ props.item.name }}</div>
                                            <span class="addr">@{{ props.item.model }}</span>
                                        </template>
                                    </el-autocomplete>
                                    <input type="hidden" v-model="currentMaterialId" name="material_id">
                                </div>
                            </div>
                        </div>
                        <div class="column">
                            <div class="inline fields">
                                <label class="six wide field flex-center">性能及技术参数</label>
                                <div class="ten wide field">
                                    <div class="fake-input">@{{currentMaterial.model || '暂无数据'}}</div>
                                </div>
                            </div>
                        </div>
                        <div class="column">
                            <div class="inline fields">
                                <label class="six wide field flex-center">生产商家</label>
                                <div class="ten wide field">
                                    <div class="fake-input">@{{currentMaterial.factory || '暂无数据'}}</div>
                                </div>
                            </div>
                        </div>
                        <div class="column">
                            <div class="inline fields">
                                <label class="six wide field flex-center">单位</label>
                                <div class="ten wide field">
                                    <div class="fake-input">@{{currentMaterial.unit || '暂无数据'}}</div>
                                </div>
                            </div>
                        </div>
                        <div class="column">
                            <div class="inline fields">
                                <label class="six wide field flex-center">当前查询物料</label>
                                <div class="ten wide field">
                                    <div class="fake-input">{{\Illuminate\Support\Facades\Input::get('name')}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="margin-top-20 flex-row flex-between flex-wrap">
                    <div>
                        <a class="ui green button" href="{{url('export/purchase/parity/list')}}?material_id={{$id}}&s={{$s}}&e={{$e}}">
                            <i class="icon download"></i>
                            <span>Excel 导出</span>
                        </a>
                    </div>
                    <div>
                        <el-date-picker v-model="date" name="search-date" type="datetimerange" :picker-options="dateOption" range-separator="至" start-placeholder="开始日期"
                                        end-placeholder="结束日期" align="right" format="yyyy-MM-dd">
                        </el-date-picker>
                        <button class="ui icon button primary" type="submit">
                            <i class="icon search"></i>
                            <span>查询</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <!-- / 操作 -->


        <div class="content-wrap table-head-nowrap">

            <table class="ui center aligned table selectable unstackable">
                <thead>
                <tr>
                    <th>采购日期</th>
                    <th>采购编号</th>
                    <th>供货商</th>
                    <th>发票条件</th>
                    <th>付款条件</th>
                    <th>数量</th>
                    <th>单价</th>
                    <th>保修时间</th>
                </tr>
                </thead>
                <!-- 无数据的时候 -->
                @if(empty($lists))
                <tbody>
                <tr>
                    <td colspan="8">暂无数据</td>
                </tr>
                </tbody>
                @else
                <!-- /无数据的时候 -->

                <!-- 有数据的时候 -->
                <tbody>
                @foreach($lists as $list)
                <tr>
                    <td>{{$list->purchase->date}}</td>
                    <td>
                        <a href="javascript:_helper.fullWindow('{{url('check/detail')}}?id={{$list->purchase->project_id}}');">{{$list->purchase->number}}</a>
                    </td>
                    <td>{{$list->purchase->supplier}}</td>
                    <td>{{$list->purchase->content}}</td>
                    <td>{{$list->purchase->condition}}</td>
                    <td>{{$list->number}}</td>
                    <td>{{number_format($list->price)}} / {{\App\Models\Material::find($list->material_id)->unit}}</td>
                    <td>{{$list->warranty_time}}</td>
                </tr>
                    @endforeach
                </tbody>
                    @endif
            </table>
        </div>
    </div>
    <!-- /主体内容 === 不可复用 -->
@endsection
@section('pageJs')
    <script src="{{url('js/buy_parity.js')}}"></script>
@endsection