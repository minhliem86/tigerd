@extends("Client::layouts.default")

@section("meta")

@stop

@section("content")
    <!--CATEGORY-->
    <section class="page-section category-page">
        <div class="container">
            <div class="row">
                <div class="col-md-9 order-sm-12">
                    <div class="category-inner">
                        <h3 class="title-cate">Các Sản Phẩm {!! $cate->name !!}</h3>
                        <div class="row">
                            @foreach($cate->products as $item_product)
                            <div class="col-md-3 col-sm-4">
                                <div class="each-cate">
                                    <figure class="figure" >
                                        <a href="#" ><img src="{!! asset($item_product->img_url) !!}" class="figure-img img-fluid rounded" alt="{!! $item_product->name !!}" ></a>
                                        <figcaption class="figure-caption">
                                            <h2 class="product-name"><a href="#">{!! $item_product->name !!}</a></h2>
                                            <p class="price {!! $item_product->discount ? 'discount' : null !!}">{!! number_format($item_product->price) !!} VND</p>
                                            @if($item_product->discount)
                                                <p class="price">{!! number_format($item_product->discount) !!} VND</p>
                                            @endif
                                            @if($item_product->values->isEmpty())
                                                <a href="" class="btn btn-outline-default btn-add-to-cart">Thêm Giỏ Hàng</a>
                                            @else
                                                <a href="{!! route('client.product', $item_product->slug) !!}" class="btn btn-outline-default btn-add-to-cart">Xem Sản Phẩm</a>
                                            @endif
                                        </figcaption>
                                    </figure>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-md-3 order-sm-1">
                    <div class="each-sidebar cate-sidebar">
                        <h3 class="title-sidebar">Danh Mục Sản Phẩm</h3>
                        @if(!$all_cate->isEmpty())
                        <div class="box">
                            <ul class="list-cate list-cate-sidebar">
                                @foreach($all_cate as $item_cate)
                                <li><a href="{!! route('client.category',$item_cate->slug) !!}">{!! $item_cate->name !!}</a></li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                    </div>
                    <div class="each-sidebar cate-sidebar">
                        <h3 class="title-sidebar">Các Sản Phẩm Nổi Bật</h3>
                        @if(!$hotProduct->isEmpty())
                        <div class="swiper-container" id="hotProductSwiper">
                            <div class="swiper-wrapper">
                                @foreach($hotProduct as $item_hot)
                                <div class="swiper-slide">
                                    <img src="{!! asset($item_hot->img_url) !!}" class="img-fluid" alt="{!! $item_hot->name !!}">
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--END CATEGORY-->
@stop

@section("script")

@stop