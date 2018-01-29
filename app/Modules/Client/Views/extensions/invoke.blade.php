@extends('Client::layouts.default')

@section('meta')

@stop

@section("content")
    <section class="page-section contact-page">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="invoice-box">
                        <table cellpadding="0" cellspacing="0">
                            <tr class="top">
                                <td colspan="2">
                                    <table>
                                        <tr>
                                            <td class="title">
                                                <img src="{!! asset('public/assets/client/images/logo-invoke.png') !!}" style="width:100%; max-width:300px;">
                                            </td>

                                            <td>
                                                <b>Mã Đơn Hàng #:</b> {!! $order_detail->order_name !!}<br>
                                                <b>Ngày Tạo:</b> {!! \Carbon\Carbon::parse($order_detail->created_at)->format('d-m-Y') !!}
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>

                            <tr class="information">
                                <td colspan="2">
                                    <table>
                                        <tr>
                                            <td>
                                                <b>Khách Hàng:</b> {!! $order_detail->customers->lastname !!} {!! $order_detail->customers->firstname !!}<br>
                                                <b>Email:</b> {!! $order_detail->customers->email !!}<br>
                                                <b>Điện Thoại:</b> {!! $order_detail->customers->phone !!}
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>

                            <tr class="heading">
                                <td colspan="2">
                                    Phương Thức Thanh Toán
                                </td>
                            </tr>

                            <tr class="details">
                                <td colspan="2">
                                    <p>{!! $order_detail->paymentmethods->name !!}</p>
                                    <p><small><i>{!! $order_detail->paymentmethods->description !!}</i></small></p>
                                </td>
                            </tr>

                            <tr class="heading">
                                <td>
                                    Sản Phẩm
                                </td>

                                <td>
                                    Đơn Giá
                                </td>
                            </tr>
                            @php
                                $total = 0;
                            @endphp
                            @foreach($order_detail->products as $item_product)
                                @php
                                    $total += $item_product->discount ? $item_product->discount : $item_product->price;
                                @endphp
                            <tr class="item ">
                                <td>
                                    {!! $item_product->name !!}
                                </td>

                                <td>
                                    {!! $item_product->discount ? number_format($item_product->discount) : number_format($item_product->price)  !!}
                                </td>
                            </tr>
                            @endforeach

                            <tr class="total">
                                <td align="right" colspan="2">
                                    <b>Tổng Cộng: {!! number_format($total) !!} VND</b>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="text-center button-wrapper">
                        <a href="{!! url()->previous() !!}" class="btn btn-info">Quay lại</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop

@section("script")

@stop