@if(!$inst->attributes->isEmpty())
    @foreach($inst->attributes as $item_attribute)
        <div class="manage-thuoctinh" style="margin-bottom:15px; padding-bottom:10px; border-bottom:1px solid lightgrey">
            <div class="row">
                <div class="col-xs-6">
                    {!! Form::select('attribute[]', ['' => 'Chọn thuộc tính'] + $attribute_list, $item_attribute->id, ['class' => 'form-control']) !!}
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