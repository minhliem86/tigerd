@if(count($array_option_att))
        <div class="each-attribute">
            <p class="att-title">Chọn Sản Phẩm</p>
            <select name="att_value[]" class="form-control value_product" required >
                <option value="">--Vui lòng chọn thuộc tính--</option>
                    @foreach($array_option_att as $item_att )
                        {!! $item_att !!}
                    @endforeach
            </select>
        </div>
@endif