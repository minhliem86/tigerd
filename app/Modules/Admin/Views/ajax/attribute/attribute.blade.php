@if(!$attribute_list->isEmpty())
    <div class="row">
    @foreach($attribute_list as $item_attr)
        <div class="col-md-4 col-sm-6">
            <div class="wrap-attribute flex-container">
                <div class="form-group flex-item">
                    <div class="checkbox checkbox-att">
                        <input type="checkbox" name="att[]" value="{!! $item_attr->id !!}" class="att_icheck" data-trigger="{!! $item_attr->slug !!}"> <b>{!! $item_attr->name !!}</b>
                    </div>
                </div>
                <div class="wrap-btn flex-item text-right">
                    <button class="btn btn-xs btn-warning" disabled id="btn-att-create-{!! $item_attr->slug !!}"><i class="fa fa-plus"></i> Thêm Giá Trị</button>
                </div>
            </div>
            <div class="wrap-att-value clearfix" id="att_value_{!! $item_attr->slug !!}">
                @if(!$item_attr->attribute_values->isEmpty())
                    @foreach($item_attr->attribute_values as $item_value)
                    <div class="col-md-4">
                        <div class="checkbox">
                            <input type="checkbox" name="att_value[]"> {!! $item_value->value !!}
                        </div>
                    </div>
                    @endforeach
                @else
                    <p>Chưa có giá trị. Vui lòng tạo mới.</p>
                @endif
            </div>
        </div>
    @endforeach
    </div>

    <div class="row">
        <div class="col-sm-12">
            <button onclick="addAttArea()" type="button" disabled class="btn btn-primary btn-att"><i class="fa fa-tag"></i> Gán Vào Sản Phẩm</button>
            <button type="button"  disabled class="btn btn-danger btn-att"><i class="fa fa-trash"></i> Xóa Thuộc Tính</button>
        </div>
    </div>

@else
    <p>Chưa có thuộc tính. Vui lòng tạo mới.</p>
@endif