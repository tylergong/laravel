<div class="container">
    <div class="row">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle hamburger hamburger-close collapsed"
                    data-target="#example-navbar-default-collapse" data-toggle="collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="hamburger-bar"></span>
            </button>
            <a href="/" class="navbar-brand navbar-logo vertical-align" title="{{config('app.name')}}">
                <div class="vertical-align-middle">
                    <img src="{{asset("images/logo.png")}}" alt="{{config('app.name')}}"
                         title="{{config('app.name')}}"/>
                </div>
            </a>
        </div>
        <div class="collapse navbar-collapse navbar-collapse-toolbar" id="example-navbar-default-collapse">
            <ul class="nav navbar-nav navbar-right navlist">
                <li><a href="/" title="网站首页" class="link active padding-horizontal-15">网站首页</a></li>
                <li><a href="/channel/1" title="感知" class="link padding-left-25 padding-right-15">感知</a></li>
                <li><a href="/channel/2" title="觉醒" class="link padding-left-25 padding-right-15">觉醒</a></li>
                <li><a href="/channel/3" title="践行" class="link padding-left-25 padding-right-15">践行</a></li>
                <li><a href="/channel/4" title="生活随笔" class="link padding-left-25 padding-right-15">生活随笔</a></li>
                <li class="dropdown">
                    <a href="/channel/5" title="联系我们" class="dropdown-toggle link padding-left-25 padding-right-15"
                       data-toggle="dropdown" data-hover="dropdown" aria-expanded="false" role="button">
                        联系我们 <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-right animate" role="menu">
                        <li class="visible-xs-block">
                            <a href="/channel/5" title="全部">全部</a>
                        </li>
                        <li><a href="/channel/5" class="" title="学校资讯">联系我们</a></li>
                        <li><a href="/channel/5" class="" title="教育新闻">联系我们</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>
<script>

</script>