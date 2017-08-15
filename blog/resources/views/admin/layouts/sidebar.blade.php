<div class="sidebar-nav navbar-collapse">
    <ul class="nav" id="side-menu">
        {{--<li class="sidebar-search">--}}
            {{--<div class="input-group custom-search-form">--}}
                {{--<input type="text" class="form-control" placeholder="Search...">--}}
                {{--<span class="input-group-btn">--}}
                                {{--<button class="btn btn-default" type="button">--}}
                                    {{--<i class="fa fa-search"></i>--}}
                                {{--</button>--}}
                            {{--</span>--}}
            {{--</div>--}}
            {{--<!-- /input-group -->--}}
        {{--</li>--}}
        <li>
            <a href="{{ url('/admin') }}"><i class="fa fa-dashboard fa-fw"></i> 主页</a>
        </li>
        <li>
            <a href="{{ url('/admin/channel') }}"><i class="fa fa-navicon fa-fw"></i> 频道管理</a>
        </li>
        <li>
            <a href="{{ url('/admin/article') }}"><i class="fa fa-files-o fa-fw"></i> 文章管理</a>
        </li>
        <li>
            <a href="{{ url('/admin/articleRecycle') }}"><i class="fa fa-trash-o fa-fw"></i> 文章回收站管理</a>
        </li>
        <li>
            <a href="{{ url('/admin/ad') }}"><i class="fa fa-image fa-fw"></i> 广告图管理</a>
        </li>
        <li>
            <a href="{{ url('/admin/fl') }}"><i class="fa fa-link fa-fw"></i> 友情链接管理</a>
        </li>
        <li>
            <a href="{{ url('/admin/static') }}"><i class="fa fa-hdd-o fa-fw"></i> 静态化管理</a>
        </li>
        {{--<li>--}}
            {{--<a href="#"><i class="fa fa-sitemap fa-fw"></i> Multi-Level Dropdown<span--}}
                        {{--class="fa arrow"></span></a>--}}
            {{--<ul class="nav nav-second-level">--}}
                {{--<li>--}}
                    {{--<a href="#">Second Level Item</a>--}}
                {{--</li>--}}
                {{--<li>--}}
                    {{--<a href="#">Third Level <span class="fa arrow"></span></a>--}}
                    {{--<ul class="nav nav-third-level">--}}
                        {{--<li>--}}
                            {{--<a href="#">Third Level Item</a>--}}
                        {{--</li>--}}
                    {{--</ul>--}}
                    {{--<!-- /.nav-third-level -->--}}
                {{--</li>--}}
            {{--</ul>--}}
            {{--<!-- /.nav-second-level -->--}}
        {{--</li>--}}
    </ul>
</div>
<!-- /.sidebar-collapse -->