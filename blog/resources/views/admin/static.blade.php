@extends('admin.layouts.master')

@section('sitesTitle', @config('webConfig.SITES_TITLE'))

@section('adminTitle', @config('webConfig.ADMIN_TITLE').'--列表')

@section('navbar')
@include('admin.layouts.navbar')
@endsection

@section('sidebar')
@include('admin.layouts.sidebar')
@endsection


@section('style')
        <!-- DataTables CSS -->
<link href="{{asset('assets/datatables/css/dataTables.bootstrap.css')}}" rel="stylesheet">
<style>
    td.details-control {
        background: url({{asset('assets/datatables/images/details_open.png')}}) no-repeat center center;
        cursor: pointer;
    }

    tr.shown td.details-control {
        background: url({{asset('assets/datatables/images/details_close.png')}}) no-repeat center center;
    }

    a {
        cursor: pointer;
    }

    table.dataTable span.highlight {
        background-color: #FFFF88;
        border-radius: 0.28571429rem;
    }

    table.dataTable span.column_highlight {
        background-color: #ffcc99;
        border-radius: 0.28571429rem;
    }
</style>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">静态化管理</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">首页静态化</div>

                <div class="panel-body">
                    <button type="botton" class="btn btn-success" v-on:click='upHome'>点击更新首页</button>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">频道页静态化</div>

                <div class="panel-body">
                    <button type="botton" class="btn btn-success" v-on:click='upChannel'>点击更新所有频道页</button>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">文章页静态化</div>

                <div class="panel-body">
                    <button type="botton" class="btn btn-success" v-on:click='upArticle'>点击更新所有文章页</button>
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
            data: {},
            methods: {
                upHome: function () {
                    var _this = this
                    // create
                    $.ajax({
                        url: '/admin/static/upHome',
                        type: 'GET',
                        cache: false,
                        data: _this.detail,
                        dataType: 'json',
                        beforeSend: function () {
                        },
                        success: function (data) {
                            if (data.code == 0) {
                                swal(data.msg);
                            } else {
                                swal(data.msg);
                            }
                        },
                        error: function (data) {
                            swal(data.msg);
                        }
                    });
                },
                upChannel: function () {
                    var _this = this
                    // create
                    $.ajax({
                        url: '/admin/static/upChannle',
                        type: 'GET',
                        cache: false,
                        data: _this.detail,
                        dataType: 'json',
                        beforeSend: function () {
                        },
                        success: function (data) {
                            if (data.code == 0) {
                                swal(data.msg);
                            } else {
                                swal(data.msg);
                            }
                        },
                        error: function (data) {
                            swal(data.msg);
                        }
                    });
                },
                upArticle: function () {
                    var _this = this
                    // create
                    $.ajax({
                        url: '/admin/static/upArticle',
                        type: 'GET',
                        cache: false,
                        data: _this.detail,
                        dataType: 'json',
                        beforeSend: function () {
                        },
                        success: function (data) {
                            if (data.code == 0) {
                                swal(data.msg);
                            } else {
                                swal(data.msg);
                            }
                        },
                        error: function (data) {
                            swal(data.msg);
                        }
                    });
                }
            },
        });
    </script>
@endsection