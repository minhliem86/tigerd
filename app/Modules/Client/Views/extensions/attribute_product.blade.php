@if(!$product->attributes->isEmpty())
    @foreach($product->attributes as $item_attribute)
        <div class="each-attribute">
            <p class="att-title" style="text-tra">{!! $item_attribute->name !!}</p>
            @if(!$item_attribute->attribute_values->isEmpty())
                @foreach($item_attribute->attribute_values()->where('product_id',$product->id)->get() as $k=>$item_att_value)
                <div class="custom-control custom-radio mb-3">
                    <input type="radio" id="{!! LP_lib::unicode($item_att_value->value) !!}" name="att_value[{!! $item_attribute->id !!}]" class="custom-control-input" value="{!! $item_att_value->id !!}" required/>
                    <label class="custom-control-label" for="{!! LP_lib::unicode($item_att_value->value) !!}">{!! $item_att_value->value !!}</label>
                </div>
                @endforeach
            @endif
        </div>
    @endforeach
@endif