@extends('Client::layouts.default')

@section('content')
    @include("Client::layouts.banner")


    <!--NEWS-->
    <section class="news-container page-section news-page">
        <div class="container">
            <div class="row">
                <div class="col">
                    <h2 class="title-section mx-auto">Tin {!! $newstype->title !!}</h2>
                    <div class="news-inner">
                        @if(!$newstype->news->isEmpty())
                        @foreach($newstype->news()->where('status',1)->orderBy('order','DESC')->get() as $item_news)
                        <div class="each-news" data-aos="flip-up">
                            <div class="media">
                                <a href="{!! route('client.news.detail',$item_news->slug) !!}"><img src="{!! asset('public/upload/'.$item_news->img_url) !!}" style="max-width:180px" class="mr-5" alt="{!! $item_news->name !!}"></a>
                                <div class="media-body">
                                    <h3 class="news-name"><a href="{!! route('client.news.detail',$item_news->slug) !!}">{!! $item_news->name !!}</a></h3>
                                    <p>{!! $item_news->description !!}</p>
                                    <a href="{!! route('client.news.detail',$item_news->slug) !!}" class="readmore float-right">Xem thêm ...</a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @else
                        <h3 class="text-center">Chưa có tin mới</h3>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--END NEWS-->


    @include("Client::layouts.fanpage")
@stop

@section("script")

@stop