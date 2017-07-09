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
            <h1 class="page-header">管理员密码重设</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    请按以下要求输入两次新的秘密
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-6">

                            <div class="form-group">
                                <label>新密码 : </label>
                                <input class="form-control" type="password" placeholder="请输入密码"
                                       v-model="detail.password">
                            </div>
                            <div class="form-group">
                                <label>确认密码 : </label>
                                <input class="form-control" type="password" placeholder="请再次输入密码"
                                       v-model="detail.password_confirmation">
                            </div>
                            <button type="botton" class="btn btn-success" v-on:click='saveAd'>保存</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{asset('assets/vue/vue.min.js')}}"></script>
    <script>
        new Vue({
            el: '#page-wrapper',
            data: {
                detail: {
                    id: parseInt("{{$detail['id']}}"),
                    password: '',
                    password_confirmation: '',
                }
            },
            methods: {
                saveAd: function () {
                    var _this = this;
                    $.ajax({
                        url: '/admin/profile/reset/' + _this.detail.id,
                        type: 'POST',
                        cache: false,
                        data: _this.detail,
                        dataType: 'json',
                        beforeSend: function () {
                        },
                        success: function (data) {
                            if (data.code == 0) {
                                _this.detail.password = '';
                                _this.detail.password_confirmation = '';
                                swal({
                                            title: "密码修改成功",
                                            text: "请点击下面确认按钮,退回至登录页面重新登录!",
                                            type: "success",
                                            showCancelButton: false,
                                            confirmButtonColor: "#DD6B55",
                                            confirmButtonText: "重新登录",
                                            closeOnConfirm: false,
                                            closeOnCancel: false
                                        },
                                        function (isConfirm) {
                                            if (isConfirm) {
                                                window.location.href = '/admin';
                                            }
                                        });
                            } else {
                                swal(data.msg);
                            }
                        }
                    });
                }
            },
        });
    </script>
@endsection