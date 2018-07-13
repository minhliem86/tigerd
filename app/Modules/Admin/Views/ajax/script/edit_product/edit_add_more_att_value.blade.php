@if(!$item_attribute->attribute_values()->where('product_id',$inst->id)->get()->isEmpty())
    @foreach($item_attribute->attribute_values()->where('product_id',$inst->id)->get() as $item_value)
    <div class="wrapper-attribute-set" style="margin-bottom:20px;">
        <div class="value-wrapper">
            <div class="row">
                <div class="col-md-8 each-value">
                    <input type="text" name="att_value[{!! $item_attribute->id ? $item_attribute->id : null  !!}][{!! $item_value->id ? $item_value->id : null !!}]" class="form-control input_field_value" placeholder="Giá trị thuộc tính. VD: 500g" value="{!! $item_value->value ? $item_value->value : '' !!}" {!! $item_value->value_prices ? 'readonly' : null  !!}>
                    <input type="hidden" name="att_value_id[{!! $item_attribute->id ? $item_attribute->id : null  !!}][]" value="{!! $item_value->id ? $item_value->id : null !!}">
                    @if($item_value->value_prices)
                        <div class="wrap-price-ajax" style="margin:10px 0 3px">
                            <input type="text" name="value_price_{!! LP_lib::unicodenospace($item_value->value) !!}" value="{!! $item_value->value_prices ? $item_value->value_prices->price : null !!}" class="form-control price_value_input" placeholder="Giá thuộc tính">
                            <input type="hidden" name="value_price_id_{!! $item_value->value_prices->id !!}" value="{!! $item_value->value_prices->id !!}">
                        </div>
                    @else
                        <div class="wrap-price-ajax" style="margin:10px 0 3px; display: none; ">
                            <input type="text" name="value_price_" class="form-control price_value_input" placeholder="Giá thuộc tính">
                        </div>
                    @endif
                </div>
                @if($item_value->photos->isEmpty())
                    <div class="col-md-4">
                        <button type="button" class="btn btn-dark trigger_upload_img"><i class="fa fa-photo"></i> Thêm Hình</button>
                        <button type="button" class="btn btn-info add_price_value"><i class="fa fa-dollar"></i> Đặt Giá</button>
                    </div>
                @endif
            </div>
        </div>
        <div class="img-wrapper">
            @if(!$item_value->photos->isEmpty())
                @include("Admin::ajax.script.edit_product.edit_fileInputValue")
            @endif
        </div>
    </div>
    @endforeach
@else
    <div class="wrapper-attribute-set" style="margin-bottom:20px;">
        <div class="value-wrapper">
            <div class="row">
                <div class="col-md-8 each-value">
                    <input type="text" name="att_value[{!! $item_attribute->id!!}][]" class="form-control input_field_value" placeholder="Giá trị thuộc tính. VD: 500g">
                </div>
                <div class="col-md-4">
                    <button type="button" class="btn btn-dark trigger_upload_img">Thêm Hình Cho Thuộc Tính</button>
                </div>
            </div>
        </div>
        <div class="img-wrapper">

        </div>
    </div>
@endif

