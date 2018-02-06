@extends("Client::layouts.default")

@section("content")
    <!--CATEGORY-->
    <section class="page-section category-page">
        <div class="container">
            <div class="row">
                <div class="col-md-9 order-sm-12">
                    <div class="category-inner" data-aos="zoom-in-up">
                        <h3 class="title-cate">Các Sản Phẩm {!! $cate->name !!}</h3>
                        <div class="row">
                            @foreach($cate->products()->where('status',1)->where('visibility',1)->get() as $item_product)

                                @if($item_product->product_links->isEmpty())
                                    <div class="col-md-3 col-sm-4">
                                        <div class="each-cate">
                                            <figure class="figure" >
                                                <a href="{!! route('client.product', $item_product->slug) !!}" ><img src="{!! asset($item_product->img_url) !!}" class="figure-img img-fluid rounded" alt="{!! $item_product->name !!}" ></a>
                                                <figcaption class="figure-caption">
                                                    <h2 class="product-name"><a href="{!! route('client.product', $item_product->slug) !!}">{!! $item_product->name !!}</a></h2>
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
                                            <div class="col-md-3 col-sm-4">
                                                <div class="each-cate">
                                                    <figure class="figure" >
                                                        <a href="{!! route('client.product', $item_product->slug) !!}" ><img src="{!! asset($product_child->img_url) !!}" class="figure-img img-fluid rounded" alt="{!! $product_child->name !!}" ></a>
                                                        <figcaption class="figure-caption">
                                                            <h2 class="product-name"><a href="{!! route('client.product', $item_product->slug) !!}">{!! $product_child->name !!}</a></h2>
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
                                    <a href="{!! route('client.product', $item_hot->slug) !!}"><img src="{!! asset($item_hot->img_url) !!}" class="img-fluid" alt="{!! $item_hot->name !!}"></a>
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