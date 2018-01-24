@if(!$product->values->isEmpty())

        <div class="each-attribute">
            <p class="att-title">Thuộc Tính Sản Phẩm</p>
            <select name="att_value[]" class="form-control value_product" >
                <option value="">--Vui lòng chọn thuộc tính--</option>
                    @foreach($product->values as $key=>$item_att )
                    <option value="{!! $item_att->id !!}">{!! $item_att->attributes->name !!}: {!! $item_value->name !!}</option>
                    @endforeach
            </select>
        </div>
@endif