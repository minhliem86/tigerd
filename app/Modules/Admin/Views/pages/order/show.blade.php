@extends('Admin::layouts.main-layout')

@section('link')
    <a href="{!! url()->previous() !!}" class="btn btn-warning">Back</a>
@stop

@section('title','Quản Lý Đơn Hàng')

@section('content')
    @if(count($order))
    <div class="row">
        <div class="col-lg-5">

            <div class="table-left">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Thông tin</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <table class="table table-header">
                                    <tbody>
                                        <tr>
                                            <td><b>Mã Đơn Hàng</b></td>
                                        </tr>
                                        <tr>
                                            <td><b>Ngày Tạo</b></td>
                                        </tr>
                                        <tr>
                                            <td><b>Khách Hàng</b></td>
                                        </tr>
                                        <tr>
                                            <td><b>Khuyến Mãi Áp Dụng</b></td>
                                        </tr>
                                        <tr>
                                            <td><b>Phương Thức Thanh Toán</b></td>
                                        </tr>
                                        <tr>
                                            <td><b>Trạng Thái Giao Hàng</b></td>
                                        </tr>
                                        <tr>
                                            <td><b>Thanh Toán</b></td>
                                        </tr>
                                        <tr>
                                            <td><b>Tổng cộng: </b></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                            <td>
                                <table class="table table-body">
                                    <tr>
                                        <td>
                                            {!! $order->order_name !!}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            {!! \Carbon\Carbon::parse($order->created_at)->format('d-m-Y') !!}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            {!! $order->customers->firstname !!} {!! $order->customers->lastname !!}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            {!! $order->promotion_id ? \App\Models\Promoton::find($order->promotion_id)->sku_promotion : 'Không Áp Dụng'!!}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            {!! $order->paymentmethods->name !!}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            {!! $order->shipstatus->description !!}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            {!! $order->paymentstatus->description !!}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            {!! number_format($order->total) !!} VND
                                        </td>
                                    </tr>
                                </table>
                            </td>

                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-lg-7">
            <div class="table-right">
                <div class="table-right-header">
                    <h4 class="order-detail-header">CHI TIẾT</h4>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Sản Phẩm</th>
                            <th>Đơn Giá</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->products as $item_product)
                        <tr>
                            <td>{!! $item_product->name !!}</td>
                            <td >{!! $item_product->discount ? number_format($item_product->discount) : number_format($item_product->price)  !!}</td>
                        </tr>
                        @endforeach
                        <tr>
                            <td colspan="2" align="right">
                                <b>Tổng Cộng: </b>{!! number_format($order->total) !!} VND
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif
@stop

@section("script")

@stop