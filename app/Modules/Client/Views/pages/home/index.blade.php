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

                        <div class="product-body" >
                            <div class="swiper-container" id="swiper-product">
                                <div class="swiper-wrapper">
                                    @foreach($product as $item_product)
                                        @php
                                            $slug = $item_product->slug;
                                        @endphp
                                        @if($item_product->product_links->isEmpty())
                                            <div class="swiper-slide">
                                                <div class="each-product">
                                                    <figure>
                                                        <a href="{!! route('client.product', $item_product->slug) !!}"><img src="{!! asset($item_product->img_url) !!}" class="img-fluid mx-auto mb-2" alt="{!! $item_product->name !!}"></a>
                                                        <figcaption>
                                                            <p class="product-name"><a href="{!! route('client.product', $item_product->slug) !!}">{!! $item_product->name !!}</a></p>
                                                            <p class="price {!! $item_product->discount ? 'discount' : null !!}">{!! number_format($item_product->price) !!} VND</p>
                                                            @if($item_product->discount)
                                                            <p class="price">{!! number_format($item_product->discount) !!} VND</p>
                                                            @endif
                                                            @if(!$item_product->stock <= 0)
                                                                <button type="button" class="btn btn-outline-default btn-add-to-cart" onclick="addToCartAjax('{!! route("client.cart.addToCartAjax") !!}', {!! $item_product->id !!})">Thêm Giỏ Hàng</button>
                                                            @else
                                                                <button type="button" class="btn btn-outline-default btn-add-to-cart" disabled="">Hết Hàng</button>
                                                            @endif
                                                        </figcaption>
                                                    </figure>
                                                </div>
                                            </div>
                                        @else
                                            @foreach($item_product->product_links as $item_link)
                                                @php
                                                    $product_child = App\Models\Product::find($item_link->link_to_product_id);
                                                @endphp
                                                @if($product_child->default)
                                                    <div class="swiper-slide">
                                                        <div class="each-product">
                                                            <figure>
                                                                <a href="{!! route('client.product', $item_product->slug) !!}"><img src="{!! asset($product_child->img_url) !!}" class="img-fluid mx-auto mb-2" alt="{!! $product_child->name !!}"></a>
                                                                <figcaption>
                                                                    <p class="product-name"><a href="{!! route('client.product', $item_product->slug) !!}">{!! $item_product->name !!}</a></p>
                                                                    <p class="price {!! $product_child->discount ? 'discount' : null !!}">{!! number_format($product_child->price) !!} VND</p>
                                                                    @if($product_child->discount)
                                                                        <p class="price">{!! number_format($product_child->discount) !!} VND</p>
                                                                    @endif
                                                                    @if(!$product_child->stock <= 0)
                                                                    <a href="{!! route('client.product', $item_product->slug) !!}" class="btn btn-outline-default btn-add-to-cart">Xem Sản Phẩm</a>
                                                                    @else
                                                                        <button type="button" class="btn btn-outline-default btn-add-to-cart" disabled="">Hết Hàng</button>
                                                                    @endif
                                                                </figcaption>
                                                            </figure>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        @endif
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

    <!--VIDEO FANPAGE-->
    <section class="video-container page-section" data-aos="fade-up">
        <div class="container">
            <div class="row">
                <div class="col">
                    <h2 class="title-section mx-auto">Tiger-D Video</h2>
                    <div class="video-inner">
                        <div data-type="youtube" data-video-id="GaW0OYw7OMY"></div>
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
                                                            <a href="{!! route('client.news.detail', $item_news->slug) !!}"><img src="{!! asset($item_news->img_url) !!}" class="mr-5" alt="{!! $item_news->name !!}"></a>
                                                            <div class="media-body">
                                                                <h3 class="news-name"><a href="{!! route('client.news.detail', $item_news->slug) !!}">{!! $item_news->name !!}</a></h3>
                                                                <p>{!! $item_news->description !!}</p>
                                                                <a href="{!! route('client.news.detail', $item_news->slug) !!}" class="readmore float-right">Read more ...</a>
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

    @include('Client::layouts.testimonial')
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
