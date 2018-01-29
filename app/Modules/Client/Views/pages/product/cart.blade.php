@extends("Client::layouts.default")

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
                                    <tr id="{!! $item_cart->id !!}">
                                        
                                        <td><img src="{!! $item_cart->attributes->has('img_url') ? $item_cart->attributes->img_url : ''  !!}" class="img-fluid" alt="{!! $item_cart->name !!}"></td>
                                        <td>
                                            <p>{!! $item_cart->name !!}</p>
                                            @if(!$item_cart->attributes->isEmpty())
                                                @foreach($item_cart->attributes as $k=>$item_att)
                                                    @if($k != 'img_url')
                                                    <p class="att">
                                                        <small>{!! $k !!}: {!!  $item_att !!}</small>
                                                    </p>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </td>
                                        <td><b>{!! number_format($item_cart->price) !!} vnd</b></td>
                                        <td><input type="text" class="form-control" name="quantity" value="{!! $item_cart->quantity !!}" data-id="{!! $item_cart->id !!}" onkeypress="restrictMinus(event)"></td>
                                        <td>
                                            <button type="button" onclick="removeItemInCart('{!! $item_cart->id !!}')" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5">Hiện chưa có sản phẩm.</td>
                                    </tr>
                                @endif

                            </tbody>
                        </table>
                    </div>
                    <div class="control-cart clearfix">
                        <div class="button-wrapper">
                            <a href="{!! route('client.home') !!}" class="btn btn-info">Tiếp tục mua hàng</a>
                            @if(!Cart::isEmpty())
                            <a href="{!! route('client.payment') !!}" class="btn btn-primary">Thanh Toán</a>
                            <a href="{!! route('client.cart.clear') !!}" class="btn btn-danger">Xóa Giỏ Hàng</a>
                            @endif
                        </div>
                        @if(!Cart::isEmpty())
                        <div class="amount-wrapper">
                            <p class="amount">Tổng Tiền: <span class="price">{!! number_format(Cart::getSubTotal()) !!} </span> VND</p>
                        </div>
                          @endif

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--END CART-->
@stop

@section('script')
    <script>
        function restrictMinus(e) {
            if (e.keyCode == 45) e.preventDefault();
        }

        function removeItemInCart(id)
        {
            alertify.confirm('Bạn có muốn xóa sản phẩm này', function (e) {
                $.ajax({
                    url: '{!! route("client.cart.removeItem") !!}' ,
                    type: 'POST',
                    data: {id: id},
                    success: function(data){
                        alertify.success('Xóa item thành  công.');
                        $('.price').text(data.data);
                        $('tr#'+id).remove();
                    }
                })
            })

        }
        $(document).ready(function(){
            $('input[name=quantity]').on('change', function(){
                var quantity = $(this).val();
                var id = $(this).data('id');
                $.ajax({
                    url: '{!! route("client.cart.updateQuantity") !!}',
                    type: 'POST',
                    data: {quantity: quantity, id: id},
                    success: function (data) {
                        if(data.error){
                            alertify.error(data.data);
                        }else{
                            alertify.success('Số lượng được cập nhật.');
                            $('.price').text(data.data);
                        }
                    }
                })
            })
        })
    </script>
@stop