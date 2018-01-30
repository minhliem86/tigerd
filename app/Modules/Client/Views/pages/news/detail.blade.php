@extends('Client::layouts.default')

@if(count($meta))
    @section('meta')
        <meta name="keywords" content="{!! $meta->meta_keywords !!}">
        <meta name="description" content="{!! $meta->meta_description !!}" >
        <meta property="og:image" content="{!! asset($meta->meta_img) !!}">
    @stop
@endif

@section('content')
    @include("Client::layouts.banner")
    <!--NEWS DETAILs-->
    <section class="news-container page-section news-detail-page">
        <div class="container">
            <div class="row">
                <div class="col-sm-8">
                    <div class="news-detail-inner">
                        <h2 class="news-name">{!! $news->name !!}</h2>
                        <p class="create-date"><b>Ngày đăng bài:</b> {!! \Carbon\Carbon::parse($news->created_at)->format('d/m/Y') !!}</p>
                        <div class="body-news">
                            <div class="description">
                                {!! $news->description !!}
                            </div>
                            <div class="content">
                                {!! $news->content !!}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="relate-news">
                        <h3 class="title-relate">Các Tin Khác</h3>
                        @if(!$relate_news->isEmpty())
                            @foreach($relate_news as $item_relate)
                            <div class="box">
                                <figure>
                                    <a href="{!! route('client.news.detail', $item_relate->slug) !!}"><img src="{!! asset($item_relate->img_url) !!}" class="img-fluid" alt="{!! $item_relate->name !!}"></a>
                                    <figcaption>
                                        <h4 class="news-name-relate">{!! $item_relate->name !!}</h4>
                                        <div class="content-relate">{!! $item_relate->description !!}</div>
                                        <div class="wrap-readmore">
                                            <a href="{!! route('client.news.detail', $item_relate->slug) !!}" class="readmore">Read more...</a>
                                        </div>
                                    </figcaption>
                                </figure>
                            </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--END NEWS DETAILs-->

    @include("Client::layouts.fanpage")
@stop

@section("script")

@stop