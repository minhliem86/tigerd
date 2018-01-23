  @extends("Client::layouts.default")

@section("meta")

@stop

@section("content")
    <!--PRODUCT-->
    <section class="page-section product-page">
        <div class="container">
            <div class="row product-infomation-row">
                <div class="col-md-4 col-sm-5">
                    <div class="wrap-gallery">
                        @if(!$product->photos->isEmpty())
                        <ul id="image-gallery" class="gallery">
                            @foreach($product->photos as $item_photo)
                            <li data-thumb="{!! asset($item_photo->thumb_url) !!}">
                                <img src="{!! asset($item_photo->img_url) !!}" class="img-fluid" />
                            </li>
                            @endforeach
                        </ul>
                        @else
                            <img src="{!! asset($product->img_url) !!}" class="img-fluid" alt="{!! $product->name !!}">
                        @endif
                    </div>
                </div>
                <div class="col-md-8 col-sm-7">
                    {!! Form::open(['route' => 'client.product.addToCart','class' => 'form']) !!}
                    <div class="product-info">
                        <h2 class="product-name">{!! $product->name !!}</h2>
                        <div class="brand-info d-flex justify-content-between">
                            <p class="product_code float">Mã Sản Phẩm: <b><i>{!! $product->categories->sku_cate !!}_{!! $product->sku_product !!}</i></b></p>
                            <p class="brand-name">Hãng Sản Xuất: <b>{!! $product->categories->name !!}</b></p>
                        </div>
                        <p class="price"><span class="price-value">{!! $product->discount ? number_format($product->discount)  : number_format($product->price) !!}</span> <small>vnd</small></p>
                        <p class="description">{!! $product->description !!}</p>
                    </div>
                    @if(count($errors))
                    <ul class="list-errors">
                        @foreach($errors->all() as $error)
                            <li>{!! $error !!}</li>
                        @endforeach
                    </ul>
                    @endif
                    <div class="product-attribute">
                        <input type="hidden" name="product_id" value="{!! $product->id !!}">
                        <input type="hidden" name="price" value="{!! $product->discount ? $product->discount  : $product->price !!}">
                        @if(!$product->attributes->isEmpty() && !$product->values->isEmpty())
                            @foreach($product->attributes as $item_att)

                            <div class="each-attribute">
                                <p class="att-title">{!! $item_att->name !!}</p>
                                <select name="att_value[{!! $item_att->slug !!}]" class="form-control att_value" >
                                    <option value="">--Vui lòng chọn thuộc tính--</option>
                                    @php(
                                        $arr_value = \App\Models\AttributeValue::where('attribute_id', $item_att->id)->whereIn('id',$arr_value_product)->get()
                                    )
                                    @foreach($arr_value as $item_value)
                                        <option value="{!! $item_value->id !!}">{!! $item_value->value !!}</option>
                                    @endforeach
                                </select>
                            </div>
                            @endforeach
                        @endif

                        <div class="each-attribute quantity">
                            <p class="att-title">Số Lượng</p>
                            <input type="number" name="quantity" class="form-control" min="1" max="10"  value="1" id="quantity" onkeypress="restrictMinus(event)">
                        </div>
                        <div class="each-attribute quantity">
                            <button class="btn btn-primary" type="submit">Mua Ngay</button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <div class="nav-wrapper">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#noidung" role="tab" aria-controls="home" aria-selected="true">Chi Tiết Sản Phẩm</a>
                            </li>

                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="noidung" role="tabpanel" aria-labelledby="home-tab">
                                <div class="wrap-chitietsanpham">
                                    {!! $product->content !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--END PRODUCT-->

    <!--RELATE PRODUCT-->
    <section class="page-section relate-product">
        <div class="container">
            <div class="row">
                <div class="col">
                    <h2 class="title-section mx-auto">Sản Phẩm Khác</h2>
                    @if(!$relate_product->isEmpty())
                    <div class="swiper-container" id="swiper-product">

                        <div class="swiper-wrapper">
                            @foreach($relate_product as $item_product_relate)
                            <div class="swiper-slide">
                                <div class="each-product">
                                    <figure>
                                        <a href="{!! route('client.product', $item_product_relate->slug) !!}"><img src="{!! asset($item_product_relate->img_url) !!}" class="img-fluid mx-auto mb-2" alt="{!! $item_product_relate->name !!}"></a>
                                        <figcaption>
                                            <p class="product-name"><a href="{!! route('client.product', $item_product_relate->slug) !!}">{!! $item_product_relate->name !!}</a></p>
                                            <p class="price {!! $item_product_relate->discount ? 'discount' : null !!}">{!! number_format($item_product_relate->price) !!} VND</p>
                                            @if($item_product_relate->discount)
                                                <p class="price">{!! number_format($item_product_relate->discount) !!} VND</p>
                                            @endif
                                            @if($item_product_relate->values->isEmpty())
                                                <button type="button" class="btn btn-outline-default btn-add-to-cart">Thêm Giỏ Hàng</button>
                                            @else
                                                <a href="{!! route('client.product', $item_product_relate->slug) !!}" class="btn btn-outline-default btn-add-to-cart">Xem Sản Phẩm</a>
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
                    @endif
                </div>
            </div>
        </div>
    </section>
    <!--END RELATE PRODUCT-->

    @if(Session::has('success'))
        <div class="modal modal-addToCart-success" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Thêm vào giỏ hàng thành công</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td width="150"><img src="{!! asset(Session::get('data')->img_url) !!}" style="max-width:120px" alt="{!! Session::get('data')->name !!}"></td>
                                    <td>
                                        <p class="product-name">{!! Session::get('data')->name !!}</p>
                                        <p class="price">{!! number_format(Session::get('price')) !!} vnd</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="btn btn-outline-success btn-modal-cart">Tiếp Tục Mua Hàng</button>
                        <a href="{!! route('client.cart') !!}" class="btn btn-info btn-modal-cart">Kiểm tra giỏ hàng</a>
                    </div>
                </div>
            </div>
        </div>
    @endif

@stop

@section("script")
    <link rel="stylesheet" href="{!! asset('public/assets/client') !!}/js/plugins/lightslider/css/lightslider.min.css">
    <script src="{!! asset('public/assets/client') !!}/js/plugins/lightslider/js/lightslider.min.js"></script>

    <script>
        function restrictMinus(e) {
            if (e.keyCode == 45) e.preventDefault();
        }
        $(document).ready(function(){
            $('#image-gallery').lightSlider({
                gallery:true,
                item:1,
                loop:true,
                thumbItem:4,
                slideMargin:0,
                enableDrag: false,
                currentPagerPosition:'left',
            })
            @if(Session::has('success'))
                $('.modal-addToCart-success').modal('show');
            @endif

            $('.att_value').on('change', function (e) {
                var product_id = $('input[name=product_id]').val();
                var att_value_id = $(this).val();

                $.ajax({
                    url: '{!! route("client.product.ajaxChangeAttributeValue") !!}',
                    type: 'POST',
                    data: {product_id: product_id, value_id: att_value_id},
                    success: function (data){
                        if(data.price){
                            $('span.price-value').text(data.price_format);
                            $('input[name=price]').val(data.price);
                        }
                    }
                })
            })

        })
    </script>
@stop
