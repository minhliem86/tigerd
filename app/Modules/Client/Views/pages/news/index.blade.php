@extends('Client::layouts.default')

@section('content')
    @include("Client::layouts.banner")

    @if(!$news->isEmpty())
    <!--NEWS-->
    <section class="news-container page-section news-page">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="news-inner">
                        @foreach($news as $item_news)
                        <div class="each-news" data-aos="flip-up">
                            <div class="media">
                                <a href="{!! route('client.news.detail',$item_news->slug) !!}"><img src="{!! asset($item_news->img_url) !!}" class="mr-5" alt="{!! $item_news->name !!}"></a>
                                <div class="media-body">
                                    <h3 class="news-name"><a href="{!! route('client.news.detail',$item_news->slug) !!}">{!! $item_news->name !!}</a></h3>
                                    <p>{!! $item_news->description !!}</p>
                                    <a href="{!! route('client.news.detail',$item_news->slug) !!}" class="readmore float-right">Read more ...</a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="wrap-pagination">
                        <nav aria-label="Page navigation">
                            @include('paginations.custom', ['paginator'=>$news])
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--END NEWS-->
    @endif

    @include("Client::layouts.fanpage")
@stop

@section("script")

@stop