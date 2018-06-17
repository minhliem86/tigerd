@if(!$item_attribute->attribute_values()->where('product_id',$inst->id)->get()->isEmpty())
    @foreach($item_attribute->attribute_values()->where('product_id',$inst->id)->get() as $item_value)
    <div class="wrapper-attribute-set" style="margin-bottom:20px;">
        <div class="value-wrapper">
            <div class="row">
                <div class="col-md-8 each-value">
                    <input type="text" name="att_value[{!! $item_attribute->id ? $item_attribute->id : null  !!}][]" class="form-control" placeholder="Giá trị thuộc tính. VD: 500g" value="{!! $item_value->value ? $item_value->value : '' !!}">
                </div>
                @if($item_value->photos->isEmpty())
                    <div class="col-md-4">
                        <button type="button" class="btn btn-dark trigger_upload_img">Thêm Hình Cho Thuộc Tính</button>
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

