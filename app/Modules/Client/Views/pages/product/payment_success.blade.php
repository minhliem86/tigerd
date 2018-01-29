@extends("Client::layouts.default")

@section("content")
    @include("Client::layouts.banner")
    <!--CART-->
    <section class="page-section cart-page">
        <div class="container">
            <div class="row">
                <div class="col">
                    <h2 class="title-section mx-auto">Mua Hàng Thành Công</h2>
                    <div class="cart-wrapper thank-wrapper">
                        <p>Giỏ hàng của bạn đang được xử lý.</p>
                        <p>Chúng tôi sẽ liên hệ với bạn trong thời gian sớm nhất.</p>
                        <p>Cảm ơn bạn đã mua hàng tại website TigerD.</p>
                        <div class="wrap-btn">
                            <a href="{!! route('client.home') !!}" class="btn btn-primary">Trang Chủ</a>
                        </div>
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