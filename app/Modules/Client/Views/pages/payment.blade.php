<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{!! csrf_token() !!} ">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css"
          integrity="sha384-Zug+QiDoJOrZ5t4lssLdxGhVrurbmBWopoEl+M6BdEfwnCJZtKxi1KgxUyJq13dy" crossorigin="anonymous">
    <link href="https://use.fontawesome.com/releases/v5.0.3/css/all.css" rel="stylesheet">


    <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
            integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
            crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/js/bootstrap.min.js"
            integrity="sha384-a5N7Y/aK3qNeh15eJKGWxsqtnX/wWdSZSKp+81YjTmS15nvnvxKHuzaWwXHDli+4"
            crossorigin="anonymous"></script>
    <title>Document</title>
</head>
<body>

<div class="container">
    <form action="{!! route('client.doPayment') !!}" method="POST" class="form">
        {!! Form::token() !!}
        <input type="hidden" name="Title" value="OnePay 3 Party">
        <div class="row">
            <div class="col">
                <div class="information-wrapper">
                    <div class="form-group">
                        <label for="">Ho ten </label>
                        {!! Form::text('fullname', old('fullname'), ['class'=>'form-control']) !!}
                    </div>
                    <div class="form-group">
                        <label for="">So dien thoai</label>
                        {!! Form::text('phone', old('phone'), ['class'=>'form-control']) !!}
                    </div>
                    <div class="form-group">
                        <label for="">Email</label>
                        {!! Form::text('email', old('email'), ['class'=>'form-control']) !!}
                    </div>
                    <div class="form-group">
                        <label for="">Dia chi giao hang</label>
                        {!! Form::textarea('address', old('address'), ['class'=>'form-control']) !!}
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="cart-wrapper">
                    <h5>Đơn Hàng ({!! Cart::getTotalQuantity() !!} sản phẩm)</h5>
                    @if(!$cart->isEmpty())
                        <div class="list-sp">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th >Sản Phẩm</th>
                                    <th>Số Lượng</th>
                                    <th class="text-right">Đơn Giá</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($cart as $item)
                                    <tr>
                                        <td>{!! $item->name !!}</td>
                                        <td>{!! $item->quantity !!}</td>
                                        <td class="text-right">{!! number_format($item->price) !!}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                    @if(Cart::getConditions()->isEmpty())
                    <div class="promotion-wrapper">
                            <input class="form-control mr-sm-2" name="promition" type="text" placeholder="Promotion" aria-label="Promotion">
                            <button class="btn btn-outline-success" id="btn-payment" type="button" onclick="applyPromotion()">Áp Dụng</button>
                    </div>
                    @endif

                    <div class="subTotal-wrapper clearfix">
                        <p class="float-left">Tạm tính</p>
                        <p class="float-right" id="subtotal">{!! number_format(Cart::getSubTotal()) !!}</p>
                    </div>
                    <div class="display-promotion clearfix">
                        <p class="float-left">Khuyến mãi áp dụng</p>
                        <div class="float-right">
                            @if(!Cart::getConditions()->isEmpty())
                                @foreach(Cart::getConditions() as $cartCondition)
                                    <span class="badge badge-info">{!! $cartCondition->getName() !!}</span>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="subTotal-wrapper clearfix">
                        <p class="float-left">Tổng tiền</p>
                        <p class="float-right" id="total"><b>{!! number_format(Cart::getTotal()) !!}</b></p>
                    </div>
                    <div class="btn-wrapper clearfix">
                        <a href="{!! route('client.product') !!}" class="btn btn-outline-info" id="btn-payment">Mua Hàng</a>

                        <button type="submit" class="btn btn-outline-primary float-right" >Thanh Toán</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<link rel="stylesheet" href="{!! asset('public/assets/admin/dist/js/plugins/alertify/alertify.css') !!}">
<script src="{!! asset('public/assets/admin/dist/js/plugins/alertify/alertify.js') !!}"></script>
<script>
    function applyPromotion()
    {
        var promotion = $('input[name="promition"]').val();
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: '{!! route("client.promotion") !!}',
            type: 'POST',
            data: {pr_code: promotion},
            success: function(data){
                if(data.error){
                    alertify.error(data.message);
                    $('input[name="promition"]').val('');
                }else{
                    var badge = '<span class="badge badge-info">'+promotion+'</span>';
                    $('input[name="promition"]').prop('disabled', true);
                    $('#btn-payment').prop('disabled',true);
                    $('.display-promotion').append(badge);
                    $('#total').text(data.data.total);
                    console.log(data.data)
                }
            }
        })
    }
    $(document).ready(function(){

    })
</script>
</body>
</html>