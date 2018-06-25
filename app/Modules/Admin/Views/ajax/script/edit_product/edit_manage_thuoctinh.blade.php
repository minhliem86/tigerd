@if(!$inst->attributes->isEmpty())
    @foreach($inst->attributes as $item_attribute)
        <div class="manage-thuoctinh" style="margin-bottom:15px; padding-bottom:10px; border-bottom:1px solid lightgrey">
            <div class="row">
                <div class="col-xs-6">
                    {!! Form::select('attribute['.$item_attribute->id.']', ['' => 'Bỏ thuộc tính'] + [$item_attribute->id => $item_attribute->name], $item_attribute->id, ['class' => 'form-control thuoctinh_select already_select']) !!}
                </div>
                <div class="col-xs-2  control-value">
                    <button type="button"  class="btn btn-warning trigger-value "><i class="fa fa-plus"></i> Thêm giá trị</button>
                </div>
                <div class="col-md-12 attribute-section">
                    @include("Admin::ajax.script.edit_product.edit_add_more_att_value")
                </div>
            </div>

        </div>
    @endforeach
@endif