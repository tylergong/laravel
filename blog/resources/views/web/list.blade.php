@extends('web.layouts.master')

@section('sitesTitle', @config('webConfig.SITES_TITLE'))

@section('navbar')
    @include('web.layouts.navbar')
@endsection

@section('style')
    <style rel="stylesheet">
        [v-cloak] {
            display: none !important;
        }

        b {
            color: red;
        }
    </style>
@endsection


@section('content')
    <div class="met-banner-ny vertical-align text-center" v-cloak>
        <h1 class="vertical-align-middle">@{{ cname }}</h1>
    </div>
    <div class="met-column-nav" v-cloak>
        <div class="container">
            <div class="row">
                <div class="col-md-12 sidebar_tile">
                    <ul class="met-column-nav-ul">
                        <li><a href="javascript:;" class="link" v-if="cid==1">通晓天下事_apperceive</a></li>
                        <li><a href="javascript:;" class="link" v-if="cid==2">大梦谁先觉_awareness</a></li>
                        <li><a href="javascript:;" class="link" v-if="cid==3">侧身践行 兢兢业业_practice</a></li>
                        <li><a href="javascript:;" class="link" v-if="cid==4">点击记录 助力一生_life essay</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <section class="met-news animsition" v-cloak>
        <div class="container">
            <div class="row">
                <div class="col-md-9 met-news-body">
                    <div class="row">
                        <div class="met-news-list">
                            <ul class="met-page-ajax">
                                <li class="" v-for="(item, index) in lists">
                                    <div class="media media-lg">
                                        <div class="media-left">
                                            <a v-bind:href="'/detail/'+item.id" v-bind:title="item.title"
                                               target='_blank'>
                                                <img class="media-object"
                                                     src="{{asset("images/1479711377137520-s.jpeg")}}"
                                                     height='100' v-bind:alt="item.title">
                                            </a>
                                        </div>
                                        <div class="media-body">
                                            <h4 class="media-heading">
                                                <a v-bind:href="'/detail/'+item.id" v-bind:title="item.title"
                                                   target='_blank'>
                                                    @{{ item.title }}
                                                </a>
                                            </h4>
                                            <p class="des">
                                                @{{ item.content_limit }}
                                            </p>
                                            <p class="info">
                                                <span>@{{ item.create_time }}</span>
                                                <span class="margin-left-10">
                                                    <i class="icon wb-eye margin-right-5" aria-hidden="true"></i>370
                                                </span>
                                            </p>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                            <!-- web -->
                            <div class="hidden-xs">
                                <div class="met_pager">
                                    <ul class="pagination">
                                        <li v-if="cur>1"><a href="javascript:;" v-on:click="cur--,pageClick()">上一页</a>
                                        </li>
                                        <li v-if="cur==1" class="disabled"><a href="javascript:;">上一页</a></li>

                                        <li v-for="index in indexs" :class="{ 'active': cur == index}">
                                            <a href="javascript:;" v-on:click="btnClick(index)">@{{ index }}</a>
                                        </li>

                                        <li v-if="cur!=all"><a href="javascript:;"
                                                               v-on:click="cur++,pageClick()">下一页</a></li>
                                        <li v-if="cur==all" class="disabled"><a href="javascript:;">下一页</a></li>

                                        <li class="disabled"><a href="javascript:;">共<i>@{{all}}</i>页</a></li>
                                    </ul>
                                </div>
                            </div>
                            <!-- wap -->
                            <div class="met-page-ajax-body visible-xs-block">
                                <button type="button" class="btn btn-default btn-block btn-squared ladda-button"
                                        v-on:click="cur++,pushLists()" v-if="last==0">
                                    <i class="icon wb-chevron-down margin-right-5" aria-hidden="true"></i>更多文章
                                </button>
                                <button type="button" class="btn btn-default btn-block btn-squared"
                                        v-else>
                                    <i class="icon margin-right-5" aria-hidden="true"></i>无数据
                                </button>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="row">
                        <div class="met-news-bar">

                            <form method='get' action="/search">
                                <div class="form-group">
                                    <div class="input-search">
                                        <button type="submit" class="input-search-btn">
                                            <i class="icon wb-search" aria-hidden="true"></i>
                                        </button>
                                        <input type="text" class="form-control" name="words" placeholder="Search">
                                    </div>
                                </div>
                            </form>

                            <div class="recommend news-list-md">
                                <h3>热门推荐</h3>
                                <ul class="list-group list-group-bordered">
                                    <li class="list-group-item" v-for="(item, index) in hot_lists">
                                        <a v-bind:href="'/detail/'+item.id" v-bind:title="item.title"
                                           target='_blank'>@{{ item.title }}</a>
                                    </li>
                                </ul>
                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="met-news-bar">
                            <img src="{{asset("images/qrcode.jpg")}}" width="150"/><br/>
                            扫码关注【<b>听我说</b>】微信公众账号或直接添加【<b>listenme1986</b>】<br/>
                            --------------------------<br/>
                            想查<b>天气</b>？回复【天气@城市名】既可。天气状况就能跃然眼前哦~~！<br/><br/>
                            想查<b>附近</b>？回复【附近@目标关键词】既可。帮你搜索附近5公里的目标哦~~！<br/><br/>
                            想查<b>快递</b>？回复【快递@快递单号】即可。方便又快捷~~！<br/><br/>
                            想查<b>地铁</b>？直接回复【地铁】~~总能查到方便又可靠的行程路线~~！<br/><br/>
                            【隐藏功能】上传你一张您的头像或者是您和他人的合照头像试试吧~~~~~<br/>
                            --------------------------<br/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script src="{{asset('assets/vue/vue.min.js')}}"></script>
    <script src="{{asset('assets/vue/axios.min.js')}}"></script>
    <script>
        new Vue({
            el: '#page-wrapper',
            data: {
                cid: "{{$c_detail['id']}}",
                cname: "{{$c_detail['cname']}}",
                lists: {},
                hot_lists: {},
                length: 10,
                cur: 1,
                all: 0,
                last: 0,
            },
            created: function () {
                this.getLists(this.cur)
            },
            methods: {
                // 点击第几页
                btnClick: function (cur) {
                    this.getLists(cur)
                },
                // 点击上一页、下一页
                pageClick: function () {
                    this.getLists(this.cur)
                },
                // 获取列表,替换当前
                getLists: function (cur) {
                    var _this = this
                    axios.get('/channel/getLists', {params: {'cid': _this.cid, 'cur': cur, 'length': _this.length}})
                            .then(function (response) {
                                _this.lists = response.data.lists.data;
                                _this.hot_lists = response.data.hot_lists;
                                _this.all = response.data.lists.last_page;
                                _this.cur = response.data.lists.current_page;
                            })
                            .catch(function (error) {
                                _this.lists = [];
                            })
                },
                // 获取列表,追加至队尾
                pushLists: function () {
                    var _this = this;
                    axios.get('/channel/getLists', {
                                params: {
                                    'cid': _this.cid,
                                    'cur': _this.cur,
                                    'length': _this.length
                                }
                            })
                            .then(function (response) {
                                if (response.data.lists) {
                                    response.data.lists.data.forEach(function (val) {
                                        _this.lists = _this.lists.concat(val);
                                    });
                                    _this.all = response.data.lists.last_page;
                                    _this.cur = response.data.lists.current_page;
                                    if (_this.all == _this.cur) {
                                        _this.last = 1;
                                    }
                                }
                            })
                            .catch(function (error) {
                                _this.lists = [];
                            })
                }
            },
            computed: {
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
        });
    </script>
@endsection

@section('footer')
    @include('web.layouts.footer')
@endsection