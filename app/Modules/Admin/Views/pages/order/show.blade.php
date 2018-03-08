@extends('Admin::layouts.main-layout')

@section('link')
    <a href="{!! route('admin.order.invoice', $order->id) !!}" class="btn btn-info btn-print">Print</a>
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
                                            {!! \Carbon\Carbon::parse($order->created_at)->format('d-m-Y H:m') !!}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            {!! $order->customers->firstname !!} {!! $order->customers->lastname !!}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            {!! $order->promotion_id ? \App\Models\Promotion::find($order->promotion_id)->sku_promotion : 'Không Áp Dụng'!!}
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
                            <th>Thuộc Tính</th>
                            <th>Đơn Giá</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->products as $item_product)
                            @if($item_product->pivot->attribute)
                                @php
                                    $arr_json = json_decode($item_product->pivot->attribute,true);
                                    $arr_json = array_except($arr_json, ['img_url']);
                                @endphp
                            @endif
                        <tr>
                            <td>{!! $item_product->name !!}</td>
                            <td>
                                @if(isset($arr_json))
                                @foreach($arr_json as $k=>$item_att)
                                    <p><b>{!! $k !!}:</b> {!! $item_att !!}</p>
                                @endforeach
                                @endif
                            </td>
                            <td >{!! $item_product->discount ? number_format($item_product->discount) : number_format($item_product->price)  !!} vnd</td>
                        </tr>
                        @endforeach
                        <tr>
                            <td colspan="3" align="right">
                                <b>Tổng Cộng: </b>{!! number_format($order->total) !!} VND
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="payment-address">
                <div class="table-right-header">
                    <h4 class="order-detail-header">THÔNG TIN GIAO HÀNG</h4>
                </div>
                <table class="table table-bordered">
                    <tbody>
                    <tr>
                        <td>
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td><b>Người nhận hàng</b></td>
                                    </tr>
                                    <tr>
                                        <td><b>Điện thoại</b></td>
                                    </tr>
                                    <tr>
                                        <td><b>Địa chỉ</b></td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                        <td>
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td>{!! $order->shipAddress->fullname !!}</td>
                                    </tr>
                                    <tr>
                                        <td>{!! $order->shipAddress->phone !!}</td>
                                    </tr>
                                    <tr>
                                        <td>{!! $order->shipAddress->address !!}, {!!DB::table('wards')->where('code',$order->shipAddress->ward)->first() ? DB::table('wards')->where('code',$order->shipAddress->ward)->first()->name_with_type : null !!}, {!!DB::table('district')->where('code',$order->shipAddress->district)->first() ? DB::table('district')->where('code',$order->shipAddress->district)->first()->name_with_type : null !!}, {!!DB::table('cities')->where('code',$order->shipAddress->city)->first() ? DB::table('cities')->where('code',$order->shipAddress->city)->first()->name_with_type : null !!}    </td>
                                    </tr>
                                </tbody>
                            </table>
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