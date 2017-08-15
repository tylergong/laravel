@extends('web.layouts.master')

@section('sitesTitle', @config('webConfig.SITES_TITLE'))

@section('navbar')
    @include('web.layouts.navbar')
@endsection

@section('style')
    <style rel="stylesheet">
        b {
            color: red;
        }
    </style>
@endsection

@section('content')
    <div class="met-banner-ny vertical-align text-center" style="background-color:;">
        <h1 class="vertical-align-middle">{{ $details['c_name'] }}</h1>
    </div>


    <section class="met-shownews animsition">
        <div class="container">
            <div class="row">
                <div class="col-md-9 met-shownews-body">
                    <div class="row">
                        <div class="met-shownews-header">
                            <h1>{{ $details['title'] }}</h1>
                            <div class="info">
							<span>
								{{ $details['create_time'] }}
							</span>
							<span>
								<i class="icon wb-eye margin-right-5" aria-hidden="true"></i>370
							</span>
                            </div>
                        </div>
                        <div class="met-editor lazyload clearfix">
                            <div>
                                <div id="article_body">
                                    {!! $details['content'] !!}
                                </div>
                                <p><br/></p>
                                <div id="metinfo_additional"></div>
                            </div>
                            <div class="center-block met_tools_code"></div>
                        </div>

                        <div class="met-shownews-footer">
                            <ul class="pager pager-round">
                                @if($previous)
                                    <li class="previous">
                                        <a href="/detail/{{ $previous['id'] }}" title="{{ $previous['title'] }}">
                                            Previous <span aria-hidden="true"
                                                           class='hidden-xs'>：{{ $previous['title'] }}</span>
                                        </a>
                                    </li>
                                @else
                                    <li class="previous disabled">
                                        <a href="javascript:;" title="没有了">
                                            Previous <span aria-hidden="true"
                                                           class='hidden-xs'>：没有了</span>
                                        </a>
                                    </li>
                                @endif
                                @if($next)
                                    <li class="next">
                                        <a href="/detail/{{ $next['id'] }}" title="{{ $next['title'] }}">
                                            Next <span aria-hidden="true" class='hidden-xs'>：{{ $next['title'] }}</span>
                                        </a>
                                    </li>
                                @else
                                    <li class="next disabled">
                                        <a href="javascript:;" title="没有了">
                                            Next <span aria-hidden="true" class='hidden-xs'>：没有了</span>
                                        </a>
                                    </li>
                                @endif
                            </ul>
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
                                    @foreach($hot_lists as $key=>$item)
                                        <li class="list-group-item">
                                            <a href="/detail/{{ $item['id'] }}" title="{{ $item['title'] }}"
                                               target='_self'>{{ $item['title'] }}</a>
                                        </li>
                                    @endforeach
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

@section('footer')
    @include('web.layouts.footer')
@endsection


