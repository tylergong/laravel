@extends('admin.layouts.master')

@section('sitesTitle', @config('webConfig.SITES_TITLE'))

@section('adminTitle', @config('webConfig.ADMIN_TITLE'))

@section('navbar')
    @include('admin.layouts.navbar')
@endsection

@section('sidebar')
    @include('admin.layouts.sidebar')
@endsection


@section('style')
    <style>

    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header" v-if="detail.id==0">频道添加</h1>
            <h1 class="page-header" v-else>频道修改</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    请按以下要求添加频道数据
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>频道名称 : </label>
                                <input class="form-control" placeholder="请输入频道名称" v-model="detail.cname">
                            </div>
                            <div class="form-group">
                                <label>是否显示 : </label>
                                <label class="radio-inline">
                                    <input type="radio" name="optionsRadiosInline" value="1" v-model="detail.is_show">是
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="optionsRadiosInline" value="0" v-model="detail.is_show">否
                                </label>
                            </div>
                            <button type="botton" class="btn btn-success" v-on:click='saveChannel'>保存</button>
                            <a href="/admin/channel" class="btn btn-info">返回列表</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{asset('assets/vue/vue.min.js')}}"></script>
    <script src="{{asset('assets/vue/axios.min.js')}}"></script>
    <script>
        new Vue({
            el: '#page-wrapper',
            data: {
                detail: {
                    id: parseInt("{{$detail['id']}}"),
                    cname: "{{$detail['cname']}}",
                    is_show: "{{$detail['is_show']}}",
                }
            },
            methods: {
                saveChannel: function () {
                    var _this = this;
                    console.log(_this.detail);
                    if (_this.detail.id == 0) {
                        // create
                        $.ajax({
                            url: '/admin/channel',
                            type: 'POST',
                            cache: false,
                            data: _this.detail,
                            dataType: 'json',
                            beforeSend: function () {
                            },
                            success: function (data) {
                                if (data.code == 1) {
                                    //swal(data.msg);
                                    window.location.href = '/admin/channel'
                                } else {
                                    swal(data.msg);
                                }
                            },
                            error: function (data) {
                                swal(data.msg);
                            }
                        });
                    } else {
                        // edit
                        $.ajax({
                            url: '/admin/channel/' + _this.detail.id,
                            type: 'PUT',
                            cache: false,
                            data: _this.detail,
                            dataType: 'json',
                            beforeSend: function () {
                            },
                            success: function (data) {
                                if (data.code == 1) {
                                    swal(data.msg);
                                }
                            },
                            error: function (data) {
                            }
                        });
                    }
                }
            },
        });
    </script>
@endsection