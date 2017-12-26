@if(!$attribute_list->isEmpty())
    @foreach($attribute_list as $item_attr)
        <div class="col-sm-3">
            <div class="form-group ">
                <div class="checkbox">
                    <input type="checkbox" name="att_{!! $item_attr->slug !!}" value="{!! $item_attr->id !!}" class="att_icheck"> <b>{!! $item_attr->name !!}</b>
                </div>
            </div>
        </div>
    @endforeach
@else
    <p>Chưa có thuộc tính. Vui lòng tạo mới.</p>
@endif