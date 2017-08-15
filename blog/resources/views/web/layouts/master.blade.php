<!DOCTYPE HTML>
<html>
<head>
    <title>@yield('sitesTitle')</title>
    <meta name="renderer" content="webkit">
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="generator" data-variable="http://www.test.com"/>
    <meta name="keywords" content="{{config('webConfig.WEB_KEYWORDS')}}"/>
    <meta name="description" content="{{config('webConfig.WEB_DESCRIPTION')}}"/>
    <link href="{{asset("images/favicon.ico")}}" rel="shortcut icon" type="image/x-icon"/>
    <link rel='stylesheet' href='{{asset("css/web/metinfo.css")}}'>
    @yield('style')

    <!--[if lt IE 10]>
    <script src='{{asset("js/web/media.match.min.js")}}'></script>
    <script src='{{asset("js/web/respond.min.js")}}'></script>
    <script src='{{asset("js/web/classList.min.js")}}'></script>
    <![endif]-->

</head>
<body class='met-navfixed'>
<!--[if lte IE 8]>
<div class="text-center padding-top-50 padding-bottom-50 bg-blue-grey-100">
    <p class="browserupgrade font-size-18">
        你正在使用一个<strong>过时</strong>的浏览器。请<a href="http://browsehappy.com/" target="_blank">升级您的浏览器</a>，以提高您的体验。
    </p>
</div>
<![endif]-->

<nav class="navbar navbar-default met-nav navbar-fixed-top" role="navigation">
    @yield('navbar')
</nav>

<div id="page-wrapper">
    @yield('content')
</div>

<footer>
    @yield('footer')
</footer>

<button type="button" class="btn btn-icon btn-primary btn-squared met-scroll-top hide">
    <i class="icon wb-chevron-up" aria-hidden="true"></i>
</button>

<script src="{{asset("js/web/metinfo.js")}}"></script>
@yield('script')

</body>
</html>