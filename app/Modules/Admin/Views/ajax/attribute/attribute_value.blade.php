@if(!$item_attr->attribute_values->isEmpty())
    @foreach($item_attr->attribute_values->chunk(2) as $item_value_chunk)
        <div class="row">
            @foreach($item_value_chunk as $item_value)
                <div class="col-md-6">
                    <div class="flex-container">
                        <div class="checkbox checkbox-value flex-item">
                            <input type="checkbox" name="att_value[]" value="{!! $item_value->id !!}"> {!! $item_value->value !!}
                        </div>
                        <div class="flex-item text-right">
                            <button type="button" class="btn btn-xs btn-danger" onclick="removeAttValue({!! $item_value->id !!},{!! $item_attr->id !!},'{!! $item_attr->slug !!}')"><i class="fa fa-trash"></i></button>
                        </div>
                    </div>

                </div>
            @endforeach
        </div>
    @endforeach
@else
    <p>Chưa có giá trị. Vui lòng tạo mới.</p>
@endif