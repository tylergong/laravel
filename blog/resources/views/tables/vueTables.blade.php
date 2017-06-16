@extends('layouts.master')

@section('sitesTitle', @config('webConfig.SITES_TITLE'))

@section('adminTitle', @config('webConfig.ADMIN_TITLE').'--列表')

@section('navbar')
    @include('layouts.navbar')
@endsection

@section('sidebar')
    @include('layouts.sidebar')
@endsection

@section('style')
    <!-- DataTables CSS -->
    <link href="{{asset('assets/datatables-plugins/dataTables.bootstrap.css')}}" rel="stylesheet">
    <!-- DataTables Responsive CSS -->
    <link href="{{asset('assets/datatables-responsive/dataTables.responsive.css')}}" rel="stylesheet">
    <style rel="stylesheet">
        [v-cloak] {
            display: none !important;
        }
    </style>

@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">活动列表</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row" id="article-list" v-cloak>
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="dataTables_length">
                        <label>
                            每页显示
                            <select class="form-control input-sm" v-model="length" v-on:change="chooseLength(length)">
                                <option v-for="option in options" v-bind:value="option.value">
                                    @{{ option.text }}
                                </option>
                            </select>
                            条
                        </label>
                    </div>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                        <tr>
                            <th></th>
                            <th>ID</th>
                            <th>活动名称</th>
                            <th>面向对象</th>
                            <th>参与类型</th>
                            <th>奖品类型</th>
                            <th>活动期限</th>
                            <th>创建日期</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="odd gradeX" v-for="list in lists">
                            <td><input type="checkbox" :value="list.id" v-model="list.proCheck"
                                       v-on:click="selecedPro(list)"></td>
                            <td>@{{ list.id }}</td>
                            <td>@{{ list.name }}</td>
                            <td>@{{ list.main | main_test }}</td>
                            <td>@{{ list.main }}</td>
                            <td>@{{ list.update_time }}</td>
                            <td>@{{ list.update_time }}</td>
                            <td>@{{ list.update_time }}</td>
                        </tr>
                        </tbody>
                    </table>
                    <div class="dataTables_paginate">
                        <ul class="pagination">
                            <li v-if="cur>1"><a href="javascript:;" v-on:click="cur--,pageClick()">上一页</a></li>
                            <li v-if="cur==1" class="disabled"><a href="javascript:;">上一页</a></li>

                            <li v-for="index in indexs" :class="{ 'active': cur == index}">
                                <a href="javascript:;" v-on:click="btnClick(index)">@{{ index }}</a>
                            </li>

                            <li v-if="cur!=all"><a href="javascript:;" v-on:click="cur++,pageClick()">下一页</a></li>
                            <li v-if="cur==all" class="disabled"><a href="javascript:;">下一页</a></li>

                            <li class="disabled"><a href="javascript:;">共<i>@{{all}}</i>页</a></li>
                        </ul>
                    </div>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
@endsection

@section('script')
    <script src="{{asset('assets/vue/vue.min.js')}}"></script>
    <script src="{{asset('assets/vue/axios.min.js')}}"></script>
    <script>
        new Vue({
            el: '#article-list',
            data: function () {
                return {
                    lists: '',
                    cklists: [],
                    all: 0,
                    cur: 1,
                    length: 10,
                    selectedAllState: false,
                    isshow: false,
                    options: [
                        {text: '10', value: 10},
                        {text: '25', value: 25},
                        {text: '50', value: 50},
                        {text: '100', value: 100}
                    ]
                }
            },
            // 初始化调用
            created: function () {
                this.getList(this.cur)
            },
            filters: {
                // 过滤面向对象
                main_test: function (main) {
                    var mainTest = ['', '个人', '团'];
                    return mainTest[main];
                }
            },
            methods: {
                // ajax获取数据
                getList: function (cur) {
                    var _this = this
                    $.ajax({
                        type: "GET",
                        url: "/vueTable",
                        dataType: "json",
                        data: {'page': cur, 'length': _this.length},
                        success: function (response) {
                            _this.lists = response.data
                            _this.all = response.last_page
                            _this.cur = response.current_page
                            _this.cklists = [];
                            _this.selectedAllState = false;
                        },
                    });
                },
                // 改变每页显示数量
                chooseLength: function (val) {
                    this.length = val;
                    this.getList(this.cur)
                },
                // 点击第几页
                btnClick: function (cur) {
                    this.getList(cur)
                },
                // 点击上一页、下一页
                pageClick: function () {
                    this.getList(this.cur)
                },
                // 勾选
                selecedPro: function (item) {
                    var _this = this
                    _this.cklists = [];
                    _this.lists.forEach(function (item, index) {
                        if (item.proCheck) {
                            _this.cklists.push(item.id)
                        }
                    });
                    if (_this.cklists.length == _this.lists.length) {
                        _this.selectedAllState = true;
                    } else {
                        _this.selectedAllState = false;
                    }
                },
                // 全选
                selectedAll: function () {
                    var _this = this
                    _this.cklists = [];
                    _this.selectedAllState = !_this.selectedAllState;
                    _this.lists.forEach(function (item, index) {
                        item.proCheck = _this.selectedAllState;
                        _this.cklists.push(item.id)
                    });
                    if (_this.selectedAllState == false) {
                        _this.cklists = []
                    }
                },
                // 删除数据并刷新数据
                del: function () {
                    var _this = this
                    if (_this.cklists.length > 0) {
                        axios.get('/articlelist-del', {params: {'ids': JSON.stringify(_this.cklists), 'p': _this.cur}})
                            .then(function (response) {
                                if (_this.selectedAllState == true && _this.cur == _this.all) {
                                    _this.cur = parseInt(_this.cur) - parseInt(1);
                                }
                                _this.cklists = []
                                _this.getList(_this.cur)
                            })
                            .catch(function (error) {
                            })
                    }
                },
                // 勾选删除 or 批量删除
                delMulti: function () {
                    // 弹层确认
                    this.isshow = true
                },
                // 单行删除
                delOnce: function (item) {
                    // 弹层确认
                    this.isshow = true
                    this.cklists = []
                    this.cklists.push(item.id)
                },
                // 关闭弹窗
                closePop: function (bool) {
                    if (!bool) {
                        this.isshow = false
                    } else {
                        this.del()
                        this.isshow = false
                    }
                }
            },
            computed: {
                // 是否全选文案变化
                selectedAllText: function () {
                    return this.selectedAllState ? "取消全选" : "全选"
                },
                // 翻页页码
                indexs: function () {
                    var left = 1;
                    var right = this.all;
                    var ar = [];
                    if (this.all >= 5) {
                        if (this.cur > 3 && this.cur < this.all - 2) {
                            left = parseInt(this.cur) - parseInt(2)
                            right = parseInt(this.cur) + parseInt(2)
                        } else {
                            if (this.cur <= 3) {
                                left = 1
                                right = 5
                            } else {
                                right = this.all
                                left = parseInt(this.all) - parseInt(4)
                            }
                        }
                    }
                    while (left <= right) {
                        ar.push(left)
                        left++
                    }
                    return ar
                }
            }
        })
    </script>
@endsection