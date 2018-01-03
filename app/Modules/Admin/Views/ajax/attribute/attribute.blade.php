<div class="container-fluid">
    @if(!$attribute_list->isEmpty())
        @foreach($attribute_list->chunk(2) as $item_chunk)
            <div class="row">
                @foreach($item_chunk as $item_attr)
                    <div class="col-md-6">
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
                            <div class="container-fluid append-value-{!! $item_attr->slug !!}">
                                @include('Admin::ajax.attribute.attribute_value')
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach
    @else
        <p>Chưa có thuộc tính. Vui lòng tạo mới.</p>
    @endif
</div>