@extends('Client::layouts.default')

@section('content')
    @include('Client::layouts.banner')

    @if(!$product->isEmpty())
    <!--PRODUCT-->
    <section class="product-container page-section">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="product-inner" data-aos="fade-up">
                        <h2 class="title-section mx-auto">Tiger-d Products</h2>

                        <div class="product-body">
                            <div class="container-fluid">
                                @foreach($product->chunk(3) as $item_chunk)
                                <div class="row">
                                    @foreach($item_chunk as $item_product)
                                        <div class="col-md-4">
                                            <div class="each-product">
                                                <figure>
                                                    <a href="{!! route('client.product', $item_product->slug) !!}"><img src="{!! asset('public/upload/'.$item_product->img_url) !!}" class="img-fluid mx-auto mb-2" alt="{!! $item_product->name !!}"></a>
                                                    <figcaption>
                                                        <p class="product-name"><a href="{!! route('client.product', $item_product->slug) !!}">{!! $item_product->name !!}</a></p>
                                                        <p class="price {!! $item_product->discount ? 'discount' : null !!}">{!! number_format($item_product->price) !!} VND</p>
                                                        @if($item_product->discount)
                                                            <p class="price">{!! number_format($product_child->discount) !!} VND</p>
                                                        @endif
                                                        @if(!$item_product->stock <= 0)
                                                            <a href="{!! route('client.product', $item_product->slug) !!}" class="btn btn-outline-default btn-add-to-cart">Xem Sản Phẩm</a>
                                                        @else
                                                            <button type="button" class="btn btn-outline-default btn-add-to-cart" disabled="">Hết Hàng</button>
                                                        @endif
                                                    </figcaption>
                                                </figure>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--END PRODUCT-->
    @endif

    <!--VIDEO FANPAGE-->
    <section class="video-container page-section" data-aos="fade-up">
        <div class="container">
            <div class="row">
                <div class="col">
                    <h2 class="title-section mx-auto">Tiger-D Video</h2>
                    <div class="video-inner">
                        <div data-type="youtube" data-video-id="xm5XFF6dCD8"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if(!$news->isEmpty())
        <!--NEWS-->
        <section class="news-container page-section">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="news-inner" data-aos="fade-up">
                            <h2 class="title-section mx-auto">Tiger-d News</h2>
                            <div class="news-body">
                                <div class="swiper-container" id="swiper-news">
                                    <div class="swiper-wrapper">
                                        @foreach($news->chunk(2) as $item_news_chunk)
                                            <div class="swiper-slide">
                                                <div class="each-news">
                                                    @foreach($item_news_chunk as $item_news)
                                                        <div class="media">
                                                            <a href="{!! route('client.news.detail', $item_news->slug) !!}"><img src="{!! asset('public/upload/'.$item_news->img_url) !!}" class="mr-5" alt="{!! $item_news->name !!}" style="max-width:180px"></a>
                                                            <div class="media-body">
                                                                <h3 class="news-name"><a href="{!! route('client.news.detail', $item_news->slug) !!}">{!! $item_news->name !!}</a></h3>
                                                                <p>{!! $item_news->description !!}</p>
                                                                <a href="{!! route('client.news.detail', $item_news->slug) !!}" class="readmore float-right">Xem thêm ...</a>
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
    <link rel="stylesheet" href="{!! asset('public/assets/client/js/plugins/video/plyr.css') !!}">
    <script src="{!! asset('public/assets/client/js/plugins/video/plyr.js') !!}"></script>
    <script>
        $(document).ready(function(){
            plyr.setup();
        })
    </script>
@stop
