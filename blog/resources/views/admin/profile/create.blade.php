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
            <h1 class="page-header">管理员资料修改</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    请按以下要求添加管理员数据
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-6">

                            <div class="form-group">
                                <label>用户名 : </label>
                                <input class="form-control" placeholder="请输入用户名" v-model="detail.name">
                            </div>
                            <div class="form-group">
                                <label>邮箱 : </label>
                                <input class="form-control" placeholder="请输入邮箱" v-model="detail.email">
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
                    name: "{{$detail['name']}}",
                    email: "{{$detail['email']}}",
                }
            },
            methods: {
                saveAd: function () {
                    var _this = this;
                    $.ajax({
                        url: '/admin/profile/' + _this.detail.id,
                        type: 'PUT',
                        cache: false,
                        data: _this.detail,
                        dataType: 'json',
                        success: function (data) {
                            swal(data.msg);
                        }
                    });
                }
            },
        })
        ;
    </script>
@endsection