@extends('web.layouts.master')

@section('sitesTitle', @config('webConfig.SITES_TITLE'))

@section('navbar')
    @include('web.layouts.navbar')
@endsection

@section('content')
    <div class="met-banner">
        <div class="carousel slide" id="met-banner-slide" data-ride="carousel">

            <ol class="carousel-indicators carousel-indicators-fall">
                <li class="active" data-slide-to="" data-target="#met-banner-slide">
                </li>
                <li class="" data-slide-to="1" data-target="#met-banner-slide">
                </li>
            </ol>

            <div class="carousel-inner " role="listbox">

                <div class="item active">
                    <a href="#" title="" target='_self'>
                        <picture>
                            <source srcset="{{asset("images/1480040551.jpg")}}" media="(min-width: 768px)"/>
                            <img class="cover-image overlay-scale" srcset="{{asset("images/1480040551-s.jpg")}}"
                                 alt=""/>
                        </picture>
                        <div class="carousel-caption p-1">
                            <p class="animation-slide-top animation-delay-300" style="color:#ebd305"></p>
                            <span class="animation-slide-bottom animation-delay-600" style="color:"></span>
                        </div>
                    </a>
                </div>

                <div class="item ">
                    <a href="#" title="" target='_self'>
                        <picture>
                            <source srcset="{{asset("images/1479979962.jpg")}}" media="(min-width: 768px)"/>
                            <img class="cover-image overlay-scale" srcset="{{asset("images/1479979962-s.jpg")}}"
                                 alt=""/>
                        </picture>
                        <div class="carousel-caption p-5">
                            <p class="animation-slide-top animation-delay-300" style="color:#ebd305"></p>
                            <span class="animation-slide-bottom animation-delay-600" style="color:"></span>
                        </div>
                    </a>
                </div>
            </div>

            <a class="left carousel-control" href="#met-banner-slide" role="button" data-slide="prev">
                <span class="icon wb-chevron-left" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>

            <a class="right carousel-control" href="#met-banner-slide" role="button"
               data-slide="next">
                <span class="icon wb-chevron-right" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>

        </div>
    </div>

    <div class="met-index-service met-index-body">
        <div class="container-fluid">
            <div class="row">
                <div class="container">
                    <h3 class="title invisible" data-plugin="appear" data-animate="slide-bottom" data-repeat="false">
                        听我说，一切从我开始</h3>
                    <p class="desc invisible animation-delay-200" data-plugin="appear" data-animate="slide-bottom"
                       data-repeat="false">
                        你在这里将享受到一场文字的盛宴
                    </p>
                </div>

                <ul class="blocks blocks-100 blocks-xlg-4 blocks-md-4 blocks-sm-2 no-space" data-plugin="matchHeight"
                    data-by-row="true">

                    <li class="invisible animation-delay-200" data-plugin="appear" data-animate="slide-top"
                        data-repeat="false">
                        <a href="/channel/1" title="感知">
                            <i class="icon pe-drawer" aria-hidden="true"></i>
                            <h4>感知</h4>
                            <p>这是一种上天赋予的权利! 无需触摸，就能诠释他的存在，呆在家里，走在路上，在你能挤出的任何闲暇时间里，随时随地、轻轻松松了解周围实事要政！</p>
                        </a>
                    </li>

                    <li class="invisible animation-delay-400" data-plugin="appear" data-animate="slide-bottom"
                        data-repeat="false">
                        <a href="/channel/2" title="觉醒">
                            <i class="icon pe-users" aria-hidden="true"></i>
                            <h4>觉醒</h4>
                            <p>静心蓄力，在大争的世界中怅然梦醒，东方的雄狮在睁眼的那一刹拉，就决定了您后续的一生，借助这伟大力量去重写人生的辉煌吧!</p>
                        </a>
                    </li>

                    <li class="invisible animation-delay-600" data-plugin="appear" data-animate="slide-top"
                        data-repeat="false">
                        <a href="/channel/3" title="践行">
                            <i class="icon pe-tools" aria-hidden="true"></i>
                            <h4>践行</h4>
                            <p>世界上没有两片完全相同的叶子；人人都是限量版！自己的世界需要自己去闯荡，自己的生活需要自己去体验，来吧，兢兢业业成就未来!</p>
                        </a>
                    </li>

                    <li class="invisible animation-delay-800" data-plugin="appear" data-animate="slide-bottom"
                        data-repeat="false">
                        <a href="/channel/4" title="生活随笔">
                            <i class="icon pe-user" aria-hidden="true"></i>
                            <h4>生活随笔</h4>
                            <p>人生的精彩不在于外表的靓丽，而是内在的涵养，随时记录下你的失败与成长，不在乎一城一池的得失，终有一天你会发现你已经屹立于山峰之巅，指点江山!</p>
                        </a>
                    </li>

                </ul>

            </div>
        </div>
    </div>

    <div class="met-index-product met-index-body">
        <div class="container">
            <h3 class="title invisible" data-plugin="appear" data-animate="slide-bottom" data-repeat="false">
                听我说，一切从我开始</h3>
            <p class="desc invisible animation-delay-200" data-plugin="appear" data-animate="slide-bottom"
               data-repeat="false">
                这里将带你走向巅峰
            </p>
        </div>
    </div>

    <div class="met-index-news met-index-body">
        <div class="container">
            <h3 class="title invisible" data-plugin="appear" data-animate="slide-top" data-repeat="false">精华文章</h3>
            <ul class="blocks blocks-100 blocks-xlg-3 blocks-md-3 blocks-sm-2" data-plugin="matchHeight"
                data-by-row="true">
                @foreach($data as $key=>$val)
                    <li>
                        <div>
                            <figure class="overlay overlay-hover">
                                <a href="/detail/{{ $val['id'] }}" title="{{ $val['title'] }}" target='_self'>
                                    <img class="overlay-figure"
                                         data-original="{{asset("images/1479711841486775-s.jpeg")}}"
                                         src="{{asset("images/1479711841486775-s.jpeg")}}"
                                         alt="{{ $val['title'] }}">
                                    <figcaption
                                            class="overlay-bottom overlay-panel overlay-background overlay-slide-top">
                                        <h4>{{ $val['title'] }}</h4>
                                    </figcaption>
                                </a>
                            </figure>
                            <p class="des">{{ $val['title'] }}</p>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection

@section('footer')
    @include('web.layouts.footer')
@endsection