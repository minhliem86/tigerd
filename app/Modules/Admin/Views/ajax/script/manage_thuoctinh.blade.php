<div class="manage-thuoctinh" style="margin-bottom:15px; padding-bottom:10px; border-bottom:1px solid lightgrey">
    <div class="row">
        <div class="col-xs-6">
            {!! Form::select('attribute[]', ['' => 'Chọn thuộc tính'] + $attribute_list, '', ['class' => 'form-control']) !!}
        </div>
        <div class="col-xs-2  control-value">
            <button type="button"  class="btn btn-warning trigger-value "><i class="fa fa-plus"></i> Thêm giá trị</button>
        </div>
        <div class="col-md-12 attribute-section">
            <div class="wrapper-attribute-set" style="margin-bottom:20px;">
                <div class="value-wrapper">
                    <div class="each-value" style="margin-bottom:10px">
                        <input type="text" name="att_value[][]" class="form-control att_value_input" placeholder="Giá trị thuộc tính. VD: 500g">
                    </div>
                </div>
                <div class="img-wrapper">
                    <input type="file" name="thumb-input" class="thumb-sp" multiple>
                </div>
            </div>
        </div>
    </div>
</div>