<div class="manage-thuoctinh" style="margin-bottom:15px; padding-bottom:10px; border-bottom:1px solid lightgrey">
    <div class="row">
        <div class="col-md-3">
            {!! Form::select('attribute[]', ['' => 'Chọn thuộc tính'] + $attribute_list, '', ['class' => 'form-control']) !!}
        </div>
        <div class="col-md-9">
            <div class="value-wrapper">
                <div class="each-value" style="margin-bottom:10px">
                    <input type="text" name="att_value[][]" class="form-control" placeholder="Giá trị thuộc tính. VD: 500g">
                </div>
            </div>
            <div class="control-value text-right">

                <button type="button"  class="btn btn-sm btn-warning trigger-value"><i class="fa fa-plus"></i> Thêm giá trị</button>

            </div>
        </div>
    </div>
</div>