@extends("Client::layouts.default")

@section("content")
    @include("Client::layouts.banner")
    <!--PAYMENT-->
    <section class="page-section payment-page">
        <div class="container">
            <div class="row">
                <h2 class="title-section mx-auto">Thanh Toán Đơn Hàng</h2>
            </div>
            {!! Form::open(["route"=>'client.doPayment', 'class' => 'form-payment']) !!}
                <div class="row">
                    <div class="col-md-8 col-sm-6" data-aos="zoom-out-left">
                        <div class="shipper-info">
                            <h3 class="title-payment">Thông tin khách hàng</h3>
                            @if($errors->error_payment->any())
                                <ul class="list-errors">
                                    @foreach($errors->error_payment->all() as $error)
                                    <li>{!! $error !!}</li>
                                    @endforeach
                                </ul>
                            @endif
                            <div class="form-khachhang">
                                {!! Form::hidden('Title', 'Online Payment Via OnePay') !!}
                                <div class="form-group">
                                    <label for="">Họ tên khách hàng</label>
                                    {!! Form::text('customer_name', Auth::guard('customer')->check() ? Auth::guard('customer')->user()->lastname.' '.Auth::guard('customer')->user()->firstname : '', ['class' => 'form-control']  ) !!}
                                </div>
                                <div class="form-group">
                                    <label for="">Số điện thoại khách hàng</label>
                                    {!! Form::text('vpc_Customer_Phone', Auth::guard('customer')->check() ? Auth::guard('customer')->user()->phone : '', ['class'=>'form-control']) !!}
                                    <small class="form-text text-muted">
                                        Tigerd.vn hoặc tổng đài tự động của chúng tôi sẽ liên hệ quý khách theo số điện thoại này để xác nhận hoặc thông báo giao hàng
                                    </small>
                                </div>
                                <div class="form-group">
                                    <label for="">Email khách hàng</label>
                                    {!! Form::text('vpc_Customer_Email',  Auth::guard('customer')->check() ? Auth::guard('customer')->user()->email : '', ['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    <label for="">Tỉnh/Thành phố</label>
                                    {!! Form::select('vpc_SHIP_City',['' => 'Chọn Tỉnh/Thành Phố']+$city, old('vpc_SHIP_City'), ['class'=>'form-control']) !!}
                                </div>

                                <div class="form-row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="">Quận/Huyện</label>
                                            <div class="ajax-province">
                                                {!! Form::select('vpc_SHIP_Provice',['' => 'Chọn Quận/Huyện'], old('vpc_SHIP_Provice'), ['class'=>'form-control', 'disabled']) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="">Phường/Xã</label>
                                            <div class="ajax-ward">
                                                {!! Form::select('ward',['' => 'Chọn Phường/Xã'], old('ward'), ['class'=>'form-control', 'disabled']) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="">Địa chỉ giao hàng</label>
                                    {!! Form::text('AVS_Street01', Auth::guard('customer')->check() ? Auth::guard('customer')->user()->address : '', ['class'=>'form-control', 'placeholder' => 'Địa chỉ bao gồm số nhà/số tầng nếu là văn phòng cụ thể.']) !!}
                                </div>
                                <div class="form-group">
                                    <label for="">Ghi chú</label>
                                    <textarea name="customer_note" rows="10" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="payment_method">
                            <h3 class="title-payment">Hình thức thanh toán</h3>
                            @if(!$pm->isEmpty())
                            <div class="paymentMethod-wrapper">
                                @foreach($pm as $item_pm)
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="{!! $item_pm->name !!}" name="payment_method" value="{!! $item_pm->id !!}" class="custom-control-input">
                                    <label class="custom-control-label" for="{!! $item_pm->name !!}">{!! $item_pm->name !!} <small>({!! $item_pm->description !!})</small></label>
                                </div>
                                @endforeach
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6" data-aos="zoom-out-right">
                        <div class="cart-wrapper">
                            <h4 class="title-summary">Đơn Hàng của bạn</h4>
                            <div class="each-area">
                                <table class="table table-summary" >
                                    <thead>
                                    <tr>
                                        <th >Sản Phẩm</th>
                                        <th>Số Lượng</th>
                                        <th class="text-right">Đơn Giá</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(!Cart::isEmpty())
                                        @foreach($cart as $item_cart)
                                            <tr>
                                                <td>{!! $item_cart->name !!}</td>
                                                <td>{!! $item_cart->quantity !!}</td>
                                                <td class="text-right price-td">{!! number_format($item_cart->price) !!} vnd</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                            <div class="each-area wrap-total d-flex">
                                <p class="text">Tạm Tính</p>
                                <p class="content"><span class="sub">{!! number_format(Cart::getSubTotal()) !!}</span> vnd</p>
                            </div>
                            <div class="each-area wrap-total">
                                <div class="input-group">
                                    <input type="text" name="promotion" class="form-control" placeholder="Mã Khuyến Mãi" {!! Cart::getConditions()->isEmpty() ? null : 'disabled' !!}>
                                    <div class="input-group-append">
                                        <button class="btn btn-info btn-promotion" type="button" onclick="applyPromotion()" id="btn-payment" {!! Cart::getConditions()->isEmpty() ? null : 'disabled' !!}>Áp Dụng</button>
                                    </div>
                                </div>
                            </div>
                            <div class="display-promotion each-area clearfix {!! Cart::getConditions()->isEmpty() ? 'd-none' : null !!}">
                                @include("Client::extensions.promotion_payment")
                            </div>


                            <div class="each-area wrap-total d-flex">
                                <p class="text">Tổng tiền</p>
                                <p class="content"><span class="total">{!! number_format(Cart::getTotal()) !!}</span> vnd</p>
                            </div>
                            <div class="btn-wrapper clearfix">
                                {{--<a href="{!! route('client.home') !!}" class="btn btn-info btn-buy" >Mua Hàng</a>--}}

                                <button type="submit" class="btn btn-primary float-right btn-payment" >Thanh Toán</button>
                            </div>
                        </div>
                    </div>

                </div>
            {!! Form::close() !!}
        </div>
    </section>
    <!--END CPAYMENT  -->
@stop

@section('script')
    <script>
        $(document).ready(function(){
            $('select[name=vpc_SHIP_City]').on('change', function(){
                var city_id = $(this).val();
                $.ajax({
                    url: "{!! route('client.post.getDistrict') !!}",
                    type: 'POST',
                    data: {city_id: city_id},
                    success: function(data){
                        $('.ajax-province').html(data.data);
                    }
                })
            })

            $(document).on('change', 'select[name=vpc_SHIP_Provice]', function () {
                var district_id = $(this).val();
                $.ajax({
                    url: "{!! route('client.post.getWard') !!}",
                    type: 'POST',
                    data: {district_id: district_id},
                    success: function(data){
                        $('.ajax-ward').html(data.data);
                    }
                })
            })

        });
        function applyPromotion()
        {
            var promotion = $('input[name="promotion"]').val();
            $.ajax({
                url: '{!! route("client.promotion") !!}',
                type: 'POST',
                data: {pr_code: promotion},
                success: function(data){
                    if(data.error){
                        alertify.error(data.message);
                        $('input[name="promotion"]').val('');
                    }
                    if(!data.error){
                        $('input[name="promotion"]').prop('disabled', true);
                        $('#btn-payment').prop('disabled',true);
                        $('.display-promotion').removeClass('d-none');
                        $('.display-promotion').append(data.view);
                        $('.total').text(data.total);
                        alertify.success(data.message);
                    }
                }
            })
        }
    </script>
@stop