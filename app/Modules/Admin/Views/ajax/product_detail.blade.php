<table class="table table-bordered" id="table-product">
    <thead>
    <tr>
        <th>#</th>
        <th>Sản Phẩm</th>
        <th>Số Lượng</th>
        <th>Đơn Giá</th>
    </tr>
    </thead>

    <tbody>
    @if(!$order->products->isEmpty())
        @foreach($order->products as $item_product)
        <tr class="table-body">
            <td>{!! $item_product->id !!}</td>
            <td>{!! $item_product->name !!}</td>
            <td>{!! $item_product->pivot->quantity !!}</td>
            <td>{!! $item_product->discount ? number_format($item_product->discount) : number_format($item_product->price) !!}</td>
        </tr>
        @endforeach
    @if($order->promotion_id)
        <tr class="heading">
            <td colspan="4">
                <b>Khuyến Mãi Áp Dụng</b>
            </td>
        </tr>
        @php
            $promotion = App\Models\Promotion::find($order->promotion_id);
        @endphp
        <tr>
            <td colspan="2">
                <p class="badge badge-info">{!! $promotion->sku_promotion !!}</p>
            </td>
            <td colspan="2" align="right">
                <p class="badge badge-success">{!! $promotion->value !!} {!! $promotion->value_type !!}</p>
            </td>
        </tr>
    @endif
    <tr class="table-footer">
        <td colspan="4" align="right">
            <b>Tổng Tiền: {!! number_format($order->total) !!} Vnd</b>
        </td>
    </tr>
    @else
        <tr>
            <td colspan="4">Đơn hàng không có sản phẩm</td>
        </tr>
    @endif
    </tbody>
</table>