@extends('Client::layouts.default')

@section('content')
    @include("Client::layouts.banner")

    @if(!$result->isEmpty())
        <!--NEWS-->
        <section class="news-container page-section news-page">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="news-inner">
                            @foreach($result as $item_result)
                                <div class="each-news">
                                    <div class="media">
                                        <a href="{!! route('client.product',$item_result->slug) !!}"><img src="{!! asset($item_result->img_url) !!}" class="mr-5" alt="{!! $item_result->name !!}"></a>
                                        <div class="media-body">
                                            <h3 class="news-name"><a href="{!! route('client.product',$item_result->slug) !!}">{!! $item_result->name !!}</a></h3>
                                            <p>{!! $item_result->description !!}</p>
                                            <a href="{!! route('client.product',$item_result->slug) !!}" class="readmore float-right">Xem sản phẩm</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="wrap-pagination">
                            <nav aria-label="Page navigation">
                                @include('paginations.custom', ['paginator'=>$result])
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