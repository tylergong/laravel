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
    <link href="{{asset('assets/jedate/skin/jedate.css')}}" rel="stylesheet">
    <style>

    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header" v-if="detail.id==0">文章添加</h1>
            <h1 class="page-header" v-else>文章修改</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    请按以下要求添加文章数据
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>文章标题 : </label>
                                <input class="form-control" placeholder="请输入文章标题" v-model="detail.title">
                            </div>
                            <div class="form-group">
                                <label>文章分类 : </label>
                                <label class="radio-inline" v-for="(item,key) in cnames">
                                    <input type="radio" name="cname" v-model="detail.cid" :value="key"/>@{{ item }}
                                </label>
                            </div>
                            <div class="form-group">
                                <label>是否外链 : </label>
                                <label class="radio-inline">
                                    <input type="radio" name="islink" value="1" v-model="detail.is_link">是
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="islink" value="0" v-model="detail.is_link">否
                                </label>
                            </div>
                            <div class="form-group" v-if="show_jump==1">
                                <input class="form-control" placeholder="请输入链接路径" v-model="detail.jumpurl">
                            </div>
                            <div class="form-group">
                                <label>是否置顶 : </label>
                                <label class="radio-inline">
                                    <input type="radio" name="istop" value="1" v-model="detail.up">是
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="istop" value="0" v-model="detail.up">否
                                </label>
                            </div>
                            <div class="form-group">
                                <label>是否显示 : </label>
                                <label class="radio-inline">
                                    <input type="radio" name="isshow" value="1" v-model="detail.is_show">是
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="isshow" value="0" v-model="detail.is_show">否
                                </label>
                            </div>
                            <div class="form-group">
                                <label>原文链接 : </label>
                                <input class="form-control" placeholder="请输入原文链接说明" v-model="detail.rel_link">
                            </div>
                            <div class="form-group">
                                <label>添加时间 : </label>
                                <input class="form-control" id="create_time" readonly placeholder="请选择时间"
                                       v-model="detail.create_time">
                            </div>
                            <div class="form-group">
                                <label>文章内容 : </label>
                                <div id="editor"></div>
                            </div>

                            <button type="botton" class="btn btn-success" v-on:click='saveAd'>保存</button>
                            <a href="/admin/article" class="btn btn-info">返回列表</a>
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
    <script src="{{asset('assets/jedate/jquery.jedate.min.js')}}"></script>
    <script src="{{asset('assets/wangEditor/wangEditor.min.js')}}"></script>
    <script>
        var vm = new Vue({
            el: '#page-wrapper',
            data: {
                cnames: {'1': '感知', '2': '觉醒', '3': '践行', '4': '生活随笔', '5': '关于'},
                detail: {},
                show_jump: 0,
            },
            // 初始化调用
            created: function () {
                var _id = parseInt({{$detail['id']}});
                if (_id > 0) {
                    this.getDetail(_id);
                } else {
                    this.$set(this.detail, 'id', 0);
                    this.$set(this.detail, 'cid', 1);
                    this.$set(this.detail, 'is_link', 0);
                    this.$set(this.detail, 'is_show', 1);
                    this.$set(this.detail, 'up', 0);
                }
            },
            methods: {
                // ajax获取详情页面
                getDetail: function (id) {
                    var _this = this;
                    $.ajax({
                        url: '/admin/article/getDetail',
                        type: 'GET',
                        cache: false,
                        data: 'id=' + id,
                        dataType: 'json',
                        beforeSend: function () {
                        },
                        success: function (data) {
                            if (data.code == 1) {
                                _this.detail = data.data;
                                // 给富文本显示区赋值
                                editor.txt.html(_this.detail.content);
                            }
                        }
                    });
                },
                saveAd: function () {
                    var _this = this;
                    _this.$set(_this.detail, 'content', editor.txt.html());
                    if (_this.detail.id == 0) {
                        // create
                        $.ajax({
                            url: '/admin/article',
                            type: 'POST',
                            cache: false,
                            data: _this.detail,
                            dataType: 'json',
                            beforeSend: function () {
                            },
                            success: function (data) {
                                if (data.code == 1) {
                                    //swal(data.msg);
                                    window.location.href = '/admin/article'
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
                            url: '/admin/article/' + _this.detail.id,
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
                },
            },
            watch: {
                'detail.is_link': function (val, oldVal) {
                    //console.log('new: %s, old: %s', val, oldVal)
                    if (val == 1) {
                        this.show_jump = 1
                    } else {
                        this.show_jump = 0
                    }
                },
            },
        });

        $.jeDate("#create_time", {
            skinCell: "jedateblue",//日期风格样式，默认蓝色
            format: "YYYY-MM-DD hh:mm:ss",//日期格式
            isTime: true,//是否开启时间选择 默认false
            isToday: true,//是否显示今天或本月 默认true
            isok: true,//是否显示确定按钮 默认true
            festival: false,////是否显示农历节日 默认false
            minDate: "1900-01-01 00:00:00",//最小日期
            maxDate: "2099-12-31 23:59:59",//最大日期
            choosefun: function (elem, val, date) {
                vm.detail.create_time = val
            },//选中日期后的回调, elem当前输入框ID, val当前选择的值, date当前完整的日期值
            clearfun: function (elem, val) {
                vm.detail.create_time = ''
            },//清除日期后的回调, elem当前输入框ID, val当前选择的值
            okfun: function (elem, val, date) {
                vm.detail.create_time = val
            },//点击确定后的回调, elem当前输入框ID, val当前选择的值, date当前完整的日期值
            success: function (elem) {
            },//层弹出后的成功回调方法, elem当前输入框ID
        });

        // 初始化富文本编辑器
        var E = window.wangEditor;
        var editor = new E('#editor');
        // 定义上传接口路径
        editor.customConfig.uploadImgServer = '/file/upload';
        // 限制一次最多上传5张(默认10000张)
        editor.customConfig.uploadImgMaxLength = 5;
        // 限制图片大小3M(默认5M)
        editor.customConfig.uploadImgMaxSize = 3 * 1024 * 1024;
        editor.customConfig.uploadImgHeaders = {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        };
        editor.create();
    </script>

@endsection