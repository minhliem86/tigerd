<div class="wrapper-attribute-set" style="margin-bottom:20px;">
    <div class="value-wrapper">
        <div class="row">
            <div class="col-md-8 each-value">
                <input type="text" name="att_value[{!! isset($value_att) ? $value_att : null !!}][]" class="form-control input_field_value" placeholder="Giá trị thuộc tính. VD: 500g">
                <input type="hidden" name="att_value_id[{!! $value_att !!}][]">
                <div class="wrap-price-ajax" style="margin:10px 0 3px; display: none">
                    <input type="text" name="value_price_" class="form-control price_value_input" placeholder="Giá thuộc tính">
                </div>
            </div>
            <div class="col-md-4">
                <button type="button" class="btn btn-dark trigger_upload_img"><i class="fa fa-photo"></i> Thêm Hình</button>
                <button type="button" class="btn btn-info add_price_value"><i class="fa fa-dollar"></i> Đặt Giá</button>
            </div>
        </div>
    </div>
    <div class="img-wrapper">

    </div>
</div>