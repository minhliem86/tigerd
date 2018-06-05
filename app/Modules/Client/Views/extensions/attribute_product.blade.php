@if(!$product->attributes->isEmpty())
    @foreach($product->attributes as $item_attribute)
        <div class="each-attribute">
            @if(!$item_attribute->attribute_values->isEmpty())
                @foreach($item_attribute->attribute_values()->where('product_id',$product->id)->get() as $item_att_value)
                <div class="custom-control custom-radio">
                    <input type="radio" id="" name="{!! LP_lib::unicode($item_att_value->value) !!}" class="custom-control-input" value="{!! $item_att_value->id !!}">
                    <label class="custom-control-label" for="{!! LP_lib::unicode($item_att_value->value) !!}">{!! $item_att_value->value !!}</label>
                </div>
                @endforeach
            @endif
        </div>
    @endforeach
@endif