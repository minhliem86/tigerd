@extends('Client::layouts.default')

@section('meta')

@stop

@section('content')
    @include('Client::layouts.banner')

    @if(!$product->isEmpty())
    <!--PRODUCT-->
    <section class="product-container page-section">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="product-inner">
                        <h2 class="title-section mx-auto">Tiger-d Products</h2>

                        <div class="product-body">
                            <div class="swiper-container" id="swiper-product">
                                <div class="swiper-wrapper">
                                    @foreach($product as $item_product)
                                    <div class="swiper-slide">
                                        <div class="each-product">
                                            <figure>
                                                <a href="#"><img src="{!! asset($item_product->img_url) !!}" class="img-fluid mx-auto mb-2" alt="{!! $item_product->name !!}"></a>
                                                <figcaption>
                                                    <p class="product-name"><a href="#">{!! $item_product->name !!}</a></p>
                                                    <p class="price {!! $item_product->discount ? 'discount' : null !!}">{!! number_format($item_product->price) !!} VND</p>
                                                    @if($item_product->discount)
                                                    <p class="price">{!! number_format($item_product->discount) !!} VND</p>
                                                    @endif
                                                    @if($item_product->values->isEmpty())
                                                        <button type="button" class="btn btn-outline-default btn-add-to-cart">Thêm Giỏ Hàng</button>
                                                    @else
                                                        <a href="{!! route('client.product', $item_product->slug) !!}" class="btn btn-outline-default btn-add-to-cart">Xem Sản Phẩm</a>
                                                    @endif
                                                </figcaption>
                                            </figure>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                <!-- If we need navigation buttons -->
                                <div class="swiper-button-prev swiper-button"></div>
                                <div class="swiper-button-next swiper-button"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--END PRODUCT-->
    @endif

    @if(!$news->isEmpty())
    <!--NEWS-->
    <section class="news-container page-section">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="news-inner">
                        <h2 class="title-section mx-auto">Tiger-d News</h2>
                        <div class="news-body">
                            <div class="swiper-container" id="swiper-news">
                                <div class="swiper-wrapper">
                                    @foreach($news->chunk(2) as $item_news_chunk)
                                    <div class="swiper-slide">
                                        <div class="each-news">
                                            @foreach($item_news_chunk as $item_news)
                                            <div class="media">
                                                <a href="#"><img src="{!! asset($item_news->img_url) !!}" class="mr-5" alt="{!! $item_news->name !!}"></a>
                                                <div class="media-body">
                                                    <h3 class="news-name"><a href="#">{!! $item_news->name !!}</a></h3>
                                                    <p>{!! $item_news->description !!}</p>
                                                    <a href="#" class="readmore float-right">Read more ...</a>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    @endforeach
                                </div>

                                <!-- If we need navigation buttons -->
                                <div class="swiper-button-prev swiper-button">
                                    <span class="btn-news-next">
                                        <i class="fa fa-chevron-left"></i>
                                    </span>
                                </div>
                                <div class="swiper-button-next swiper-button">
                                    <span class="btn-news-next">
                                        <i class="fa fa-chevron-right"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--END NEWS-->
    @endif

    @include("Client::layouts.fanpage")
@stop

@section('script')

@stop
