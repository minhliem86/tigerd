<div class="col-md-6" id="att-{!! $item_attr->id !!}">
    <div class="wrap-attribute flex-container">
        <div class="form-group flex-item">
            <div class="checkbox checkbox-att">
                <input type="checkbox" name="att[]" value="{!! $item_attr->id !!}"
                       class="att_icheck"
                       data-trigger="{!! $item_attr->slug !!}"
                        {!! count($array_att) && in_array($item_attr->id, $array_att) ? 'checked' : null   !!} >
                <b>{!! $item_attr->name !!}</b>
            </div>
        </div>
        <div class="wrap-btn flex-item text-right">
            <button type="button" class="btn btn-xs btn-warning btn-create-value" data-toggle="modal"
                    data-target="#modal-add-value" data-att-id="{!! $item_attr->id !!}"
                    data-att-slug="{!! $item_attr->slug !!}" disabled
                    id="btn-att-create-{!! $item_attr->slug !!}" data-toggle="tooltip"
                    title="Thêm Giá Trị"><i class="fa fa-plus"></i> Thêm Giá Trị
            </button>

        </div>
    </div>
    <div class="wrap-att-value clearfix" id="att_value_{!! $item_attr->slug !!}">
        <div class="container-fluid">
            <div class="row append-value-{!! $item_attr->slug !!}">
                @if(!$item_attr->attribute_values->isEmpty())
                    @foreach($item_attr->attribute_values as $item_value)
                        @if(count($item_value->attributes()))
                            @include("Admin::ajax.attribute.att_value")
                        @endif
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</div>
