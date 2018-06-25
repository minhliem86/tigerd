<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no">
        <meta name="csrf-token" content="{{csrf_token()}}">
        <META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
        <link rel="shortcut icon" href="{{asset('/public/assets/admin')}}/dist/img/favicon.ico"/>
        <!-- site css -->
        <link rel="stylesheet" href="{{asset('/public/assets/admin')}}/bootflat-admin/css/bootstrap.min.css">
        <link rel="stylesheet" href="{{asset('/public/assets/admin')}}/dist/css/invoice.css">
        <title>Đơn Hàng {!! $order_detail->order_name !!}</title>
    </head>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
    </style>

<body>
<div class="invoice-box">
    <table cellpadding="0" cellspacing="0" class="table">
        <tr class="top">
            <td colspan="3">
                <table class="table">
                    <tr>
                        <td class="title" align="center">
                            <img src="{!! asset('public/assets/client/images/logo-invoke.png') !!}" style=" max-width:300px;">
                        </td>

                        <td align="left" class="text-left">
                            <b>Mã Đơn Hàng #:</b> {!! $order_detail->order_name !!}<br>
                            <b>Ngày Tạo:</b> {!! \Carbon\Carbon::parse($order_detail->created_at)->format('d-m-Y') !!}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr class="information">
            <td colspan="3">
                <table>
                    <tr>
                        <td  align="left">
                            <b>Khách Hàng:</b> {!! $order_detail->shipAddress->fullname !!}<br>
                            <b>Điện Thoại:</b> {!! $order_detail->customers->phone !!}<br/>
                            <b>Địa chỉ giao hàng:</b> {!! $order_detail ->shipAddress->address !!}, {!!DB::table('wards')->where('code',$order_detail ->shipAddress->ward)->first() ? DB::table('wards')->where('code',$order_detail ->shipAddress->ward)->first()->name_with_type : null !!}, {!!DB::table('district')->where('code',$order_detail ->shipAddress->district)->first() ? DB::table('district')->where('code',$order_detail ->shipAddress->district)->first()->name_with_type : null !!}, {!!DB::table('cities')->where('code',$order_detail ->shipAddress->city)->first() ? DB::table('cities')->where('code',$order_detail ->shipAddress->city)->first()->name_with_type : null !!}<br/>
                            <b>Ghi chú:</b> {!! $order_detail ->shipAddress->note !!}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr class="heading">
            <td colspan="3">
                Phương Thức Thanh Toán
            </td>
        </tr>

        <tr class="details">
            <td colspan="3">
                <p>{!! $order_detail->paymentmethods->name !!}</p>
                <p><small><i>{!! $order_detail->paymentmethods->description !!}</i></small></p>
            </td>
        </tr>
        @if($order_detail->promotion_id)
            <tr class="heading">
                <td colspan="3">
                    Khuyến Mãi Áp Dụng
                </td>
            </tr>
            @php
                $promotion = App\Models\Promotion::find($order_detail->promotion_id);
            @endphp
            <tr class="details">
                <td colspan="2">
                    <p class="badge badge-info">{!! $promotion->sku_promotion !!}</p>
                </td>
                <td>
                    <p class="badge badge-success">{!! $promotion->value !!} {!! $promotion->value_type !!}</p>
                </td>
            </tr>
        @endif

        <tr class="heading">
            <td width="60%">
                Sản Phẩm
            </td>
            <td width="20%" align="center">
                Số Lượng
            </td>

            <td width="20%" align="right">
                Đơn Giá
            </td>
        </tr>

        @foreach($order_detail->products as $item_product)
            <tr class="item ">
                <td>
                    {!! $item_product->name !!}
                </td>

                <td align="center">
                    {!! $item_product->pivot->quantity !!}
                </td>

                <td align="right">
                    {!! $item_product->discount ? number_format($item_product->discount) : number_format($item_product->price)  !!}
                </td>
            </tr>
        @endforeach
        <tr>
            <td colspan="2">Phí vận chuyển</td>
            <td align="right">{!! number_format($order_detail->shipping_cost) !!}</td>
        </tr>
        <tr class="total">
            <td align="right" colspan="3">
                <b>Tổng Cộng: {!! number_format($order_detail->total) !!} VND</b>
            </td>
        </tr>
    </table>
</div>

</body>
</html>