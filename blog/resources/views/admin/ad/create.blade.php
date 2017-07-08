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
            <h1 class="page-header" v-if="detail.id==0">广告图添加</h1>
            <h1 class="page-header" v-else>广告图修改</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    请按以下要求添加广告图数据
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>广告图 : <img v-bind:src="detail.imgurl_show" height="40px"/></label>
                                <input type="file" name="picfile" v-on:change="uploadImage($event)">
                            </div>
                            <div class="form-group">
                                <label>图片说明 : </label>
                                <input class="form-control" placeholder="请输入图片说明" v-model="detail.title">
                            </div>
                            <div class="form-group">
                                <label>是否链接 : </label>
                                <label class="radio-inline">
                                    <input type="radio" name="optionsRadiosInline" value="1" v-model="detail.is_link">是
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="optionsRadiosInline" value="0" v-model="detail.is_link">否
                                </label>
                            </div>
                            <div class="form-group" v-if="detail.is_link==1">
                                <input class="form-control" placeholder="请输入链接路径" v-model="detail.jumpurl">
                            </div>
                            <button type="botton" class="btn btn-success" v-on:click='saveAd'>保存</button>
                            <a href="/admin/ad" class="btn btn-info">返回列表</a>
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
                    imgurl: "{{$detail['imgurl']}}",
                    imgurl_show: "{{$detail['imgurl_show']}}",
                    new_img: 0,
                    title: "{{$detail['title']}}",
                    is_link: "{{$detail['is_link']}}",
                    jumpurl: "{{$detail['jumpurl']}}",
                }
            },
            methods: {
                uploadImage: function (event) {
                    var _this = this
                    var image_file = event.target.files[0];
                    var file_type = image_file.type;
                    if (file_type.indexOf('image') == -1) {
                        sweetAlert('文件格式不正确');
                        return;
                    }
                    //图片预览
                    var reader = new FileReader();
                    reader.readAsDataURL(image_file);
                    reader.onload = function (e) {
                        _this.detail.imgurl_show = e.target.result;
                        _this.detail.new_img = 1;
                    }
                },
                saveAd: function () {
                    var _this = this
                    if (_this.detail.id == 0) {
                        // create
                        $.ajax({
                            url: '/admin/ad',
                            type: 'POST',
                            cache: false,
                            data: _this.detail,
                            dataType: 'json',
                            beforeSend: function () {
                            },
                            success: function (data) {
                                if (data.code == 1) {
                                    //swal(data.msg);
                                    window.location.href = '/admin/ad'
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
                            url: '/admin/ad/' + _this.detail.id,
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