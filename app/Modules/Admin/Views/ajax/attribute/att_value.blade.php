<div class="col-md-6" id="att-value-{!! $item_value->id !!}">
    <div class="flex-container">
        <div class="checkbox checkbox-value flex-item">
            <input type="checkbox" name="att_value[]" value="{!! $item_value->id !!}" {!! count($array_value) && in_array($item_value->id, $array_value) ? 'checked' : null   !!}> {!! $item_value->value !!} ({!! $item_value->value_price ? number_format($item_value->value_price).'đ' : null !!})
        </div>
        <div class="flex-item text-right">
            <button type="button" class="btn btn-xs btn-danger" onclick="removeAttValue( {!! $item_value->id !!}, {!! $item_attr->id !!}, '{!! $item_attr->slug !!}' )"><i class="fa fa-trash"></i></button>

        </div>
    </div>
</div>