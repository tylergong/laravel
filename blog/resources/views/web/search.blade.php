@extends('web.layouts.master')

@section('sitesTitle', @config('webConfig.SITES_TITLE'))

@section('navbar')
    @include('web.layouts.navbar')
@endsection

@section('content')
    <div class="met-banner-ny vertical-align text-center" v-cloak>
        <h1 class="vertical-align-middle">搜索结果</h1>
    </div>
    <section class="met-search animsition">
        <div class="container">
            <div class="row">
                <div class="met-search-body">
                    <form method='get' class="page-search-form" role="search" action='/search'>
                        <div class="input-search input-search-dark">
                            <button type="submit" class="input-search-btn">
                                <i class="icon wb-search" aria-hidden="true"></i></button>
                            <input
                                    type="text"
                                    class="form-control input-lg"
                                    name="words"
                                    value="{{ $words }}"
                                    placeholder="请输入搜索关键词！"
                                    data-fv-notempty="true"
                                    data-fv-message="不能为空"
                            >
                        </div>
                    </form>
                    <ul class="list-group list-group-full list-group-dividered met-page-ajax">
                        @foreach($lists as $key=>$item)
                            <li class="list-group-item">
                                <h4>
                                    <a href="/detail/{{ $item['id'] }}" target="_blank">
                                        {{ $item['title'] }}
                                    </a>
                                </h4>
                                <a class="search-result-link" href="/detail/{{ $item['id'] }}"
                                   target="_blank"> {{ config('app.url') }}/detail/{{ $item['id'] }}
                                </a>
                                <p>{{ $item['content_limit'] }}</p>
                            </li>
                        @endforeach
                    </ul>

                </div>
            </div>
        </div>
    </section>
@endsection

@section('footer')
    @include('web.layouts.footer')
@endsection