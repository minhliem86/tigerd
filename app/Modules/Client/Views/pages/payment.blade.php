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
    {{--<form action="{!! route('client.doPayment') !!}" method="POST" class="form">--}}
        {{--{!! Form::token() !!}--}}
        {{--<div class="row">--}}
            {{--<div class="col">--}}
                {{--<div class="information-wrapper">--}}
                    {{--<div class="form-group">--}}
                        {{--<label for="">Ho ten </label>--}}
                        {{--{!! Form::text('fullname', old('fullname'), ['class'=>'form-control']) !!}--}}
                    {{--</div>--}}
                    {{--<div class="form-group">--}}
                        {{--<label for="">So dien thoai</label>--}}
                        {{--{!! Form::text('phone', old('phone'), ['class'=>'form-control']) !!}--}}
                    {{--</div>--}}
                    {{--<div class="form-group">--}}
                        {{--<label for="">Email</label>--}}
                        {{--{!! Form::text('email', old('email'), ['class'=>'form-control']) !!}--}}
                    {{--</div>--}}
                    {{--<div class="form-group">--}}
                        {{--<label for="">Dia chi giao hang</label>--}}
                        {{--{!! Form::textarea('address', old('address'), ['class'=>'form-control']) !!}--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
            {{--<div class="col">--}}
                {{--<div class="cart-wrapper">--}}
                    {{--<h5>Đơn Hàng ({!! Cart::getTotalQuantity() !!} sản phẩm)</h5>--}}
                    {{--@if(!$cart->isEmpty())--}}
                        {{--<div class="list-sp">--}}
                            {{--<table class="table">--}}
                                {{--<thead>--}}
                                {{--<tr>--}}
                                    {{--<th >Sản Phẩm</th>--}}
                                    {{--<th>Số Lượng</th>--}}
                                    {{--<th class="text-right">Đơn Giá</th>--}}
                                {{--</tr>--}}
                                {{--</thead>--}}
                                {{--<tbody>--}}
                                {{--@foreach($cart as $item)--}}
                                    {{--<tr>--}}
                                        {{--<td>{!! $item->name !!}</td>--}}
                                        {{--<td>{!! $item->quantity !!}</td>--}}
                                        {{--<td class="text-right">{!! number_format($item->price) !!}</td>--}}
                                    {{--</tr>--}}
                                {{--@endforeach--}}
                                {{--</tbody>--}}
                            {{--</table>--}}
                        {{--</div>--}}
                    {{--@endif--}}
                    {{--@if(Cart::getConditions()->isEmpty())--}}
                    {{--<div class="promotion-wrapper">--}}
                            {{--<input class="form-control mr-sm-2" name="promition" type="text" placeholder="Promotion" aria-label="Promotion">--}}
                            {{--<button class="btn btn-outline-success" id="btn-payment" type="button" onclick="applyPromotion()">Áp Dụng</button>--}}
                    {{--</div>--}}
                    {{--@endif--}}

                    {{--<div class="subTotal-wrapper clearfix">--}}
                        {{--<p class="float-left">Tạm tính</p>--}}
                        {{--<p class="float-right" id="subtotal">{!! number_format(Cart::getSubTotal()) !!}</p>--}}
                    {{--</div>--}}
                    {{--<div class="display-promotion clearfix">--}}
                        {{--<p class="float-left">Khuyến mãi áp dụng</p>--}}
                        {{--<div class="float-right">--}}
                            {{--@if(!Cart::getConditions()->isEmpty())--}}
                                {{--@foreach(Cart::getConditions() as $cartCondition)--}}
                                    {{--<span class="badge badge-info">{!! $cartCondition->getName() !!}</span>--}}
                                {{--@endforeach--}}
                            {{--@endif--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="subTotal-wrapper clearfix">--}}
                        {{--<p class="float-left">Tổng tiền</p>--}}
                        {{--<p class="float-right" id="total"><b>{!! number_format(Cart::getTotal()) !!}</b></p>--}}
                    {{--</div>--}}
                    {{--<div class="btn-wrapper clearfix">--}}
                        {{--<a href="{!! route('client.product') !!}" class="btn btn-outline-info" id="btn-payment">Mua Hàng</a>--}}

                        {{--<button type="submit" class="btn btn-outline-primary float-right" >Thanh Toán</button>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</form>--}}

    <form action="{!! route('client.doPayment') !!}" method="post">
        {!! Form::token() !!}
        <input type="hidden" name="Title" value="VPC 3-Party"/>
        <table width="100%" align="center" border="0" cellpadding='0'
               cellspacing='0'>
            <tr class="shade">
                <td width="1%">&nbsp;</td>
                <td width="40%" align="right"><strong><em>URL cổng thanh toán - Virtual Payment Client
                            URL:&nbsp;</em></strong></td>
                <td width="59%"><input type="text" name="virtualPaymentClientURL"
                                       size="63" value="https://mtf.onepay.vn/vpcpay/vpcpay.op"
                                       maxlength="250"/></td>
            </tr>
        </table>
        <center>
            <table class="background-image" summary="Meeting Results">
                <thead>
                <tr>
                    <th scope="col" width="250px">Name</th>
                    <th scope="col" width="250px">Input</th>
                    <th scope="col" width="250px">Chú thích</th>
                    <th scope="col">Description</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td><strong><em>Merchant ID</em></strong></td>
                    <td><input type="text" name="vpc_Merchant" value="TESTONEPAY" size="20"
                               maxlength="16"/></td>
                    <td>Được cấp bởi OnePAY</td>
                    <td>Provided by OnePAY</td>
                </tr>
                <tr>
                    <td><strong><em>Merchant AccessCode</em></strong></td>
                    <td><input type="text" name="vpc_AccessCode" value="6BEB2546"
                               size="20" maxlength="8"/></td>
                    <td>Được cấp bởi OnePAY</td>
                    <td>Provided by OnePAY</td>
                </tr>
                <tr>
                    <td><strong><em>Merchant Transaction Reference</em></strong></td>
                    <td><input type="text" name="vpc_MerchTxnRef"
                               value="<?php
                               echo date('YmdHis') . rand();
                               ?>" size="20"
                               maxlength="40"/></td>
                    <td>ID giao dịch, giá trị phải khác nhau trong mỗi lần thanh(tối đa 40 ký tự)
                        toán
                    </td>
                    <td>ID Transaction - (unique per transaction) - (max 40 char)</td>
                </tr>
                <tr>
                    <td><strong><em>Transaction OrderInfo</em></strong></td>
                    <td><input type="text" name="vpc_OrderInfo" value="JSECURETEST01"
                               size="20" maxlength="34"/></td>
                    <td>Tên hóa đơn - (tối đa 34 ký tự)</td>
                    <td>Order Name will show on payment gateway (max 34 char)</td>
                </tr>
                <tr>
                    <td><strong><em>Purchase Amount</em></strong></td>
                    <td><input type="text" name="vpc_Amount" value="1000000" size="20"
                               maxlength="10"/></td>
                    <td>Số tiền cần thanh toán,Đã được nhân với 100. VD: 1000000=10000VND</td>
                    <td>Amount,Multiplied with 100, Ex: 1000000=10000VND</td>
                </tr>
                <tr>
                    <td><strong><em>Receipt ReturnURL</em></strong></td>
                    <td><input type="text" name="vpc_ReturnURL" size="45"
                               value="http://localhost/domestic_php_v2/source_code/dr.php"
                               maxlength="250"/></td>
                    <td>Url nhận kết quả trả về sau khi giao dịch hoàn thành.</td>
                    <td>URL for receiving payment result from gateway</td>
                </tr>
                <tr>
                    <td><strong><em>VPC Version</em></strong></td>
                    <td><input type="text" name="vpc_Version" value="2" size="20"
                               maxlength="8"/></td>
                    <td>Phiên bản modul (cố định)</td>
                    <td>Version (fixed)</td>
                </tr>
                <tr>
                    <td><strong><em>Command Type</em></strong></td>
                    <td><input type="text" name="vpc_Command" value="pay" size="20"
                               maxlength="16"/></td>
                    <td>Loại request (cố định)</td>
                    <td>Command Type(fixed)</td>
                </tr>
                <tr>
                    <td><strong><em>Payment Server Display Language Locale</em></strong></td>
                    <td><input type="text" name="vpc_Locale" value="en" size="20"
                               maxlength="5"/></td>
                    <td>Ngôn ngữ hiện thị trên cổng (vn/en)</td>
                    <td>Language use on gateway (vn/en)</td>
                </tr>
                <tr>
                    <td align="center" colspan="4"><input type="submit" value="Pay Now!"/></td>
                </tr>
                </tbody>
            </table>


        </center>
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
            url: '{!! route("process.promotion") !!}',
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