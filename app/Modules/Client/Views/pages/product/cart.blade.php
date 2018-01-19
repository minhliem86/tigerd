@extends("Client::layouts.default")

@section("meta")

@stop

@section("content")
    @include("Client::layouts.banner")
    <!--CART-->
    <section class="page-section cart-page">
        <div class="container">
            <div class="row">
                <div class="col">
                    <h2 class="title-section mx-auto">Giỏ Hàng Của Bạn</h2>
                    <div class="cart-wrapper">
                        <table class="table-bordered table">
                            <thead>
                            <tr>
                                <th width="15%">Hình Ảnh</th>
                                <th width="40%">Tên Sản Phẩm</th>
                                <th width="20%">Đơn Giá</th>
                                <th width="15%">Số Lượng</th>
                                <th>#</th>
                            </tr>
                            </thead>
                            <tbody>
                                @if(!$cart->isEmpty())
                                    @foreach($cart as $item_cart)
                                    <tr>
                                        
                                        <td><img src="{!! $item_cart->attributes->has('img_url') ? '' : ''  !!}" class="img-fluid" alt="{!! $item_cart->name !!}"></td>
                                        <td>
                                            <p>{!! $item_cart->name !!}</p>
                                            @if(!$item_cart->attributes->isEmpty())
                                            <p class="att">
                                                @foreach($item_cart->attributes as $item_att)
                                                    <small>{!! $item_att !!}</small>
                                                @endforeach
                                            </p>
                                            @endif
                                        </td>
                                        <td><b>{!! number_format($item_cart->price) !!} vnd</b></td>
                                        <td><input type="number" class="form-control" name="quantity" value="{!! $item_cart->quantity !!}" data-id="{!! $item_cart->id !!}"></td>
                                        <td>
                                            <button class="btn btn-danger" data-id="{!! $item_cart->id !!}"><i class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5">Hiện chưa có sản phẩm.</td>
                                    </tr>
                                    <tr>
                                        <td colspan="5"><a href="{!! route('client.home') !!}" class="btn btn-info">Mua Hàng</a></td>
                                    </tr>
                                @endif

                            </tbody>
                        </table>
                    </div>
                    <div class="control-cart clearfix">
                        <div class="button-wrapper">
                            <a href="{!! route('client.home') !!}" class="btn btn-info">Tiếp tục mua hàng</a>
                            <a href="#" class="btn btn-primary">Thanh Toán</a>
                            <a href="{!! route('client.cart.clear') !!}" class="btn btn-danger">Xóa Giỏ Hàng</a>
                        </div>
                        <div class="amount-wrapper">
                            <p class="amount">Tổng Tiền: <span class="price">{!! number_format(Cart::getSubTotal()) !!} VND</span></p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--END CART-->
@stop

@section('script')

@stop