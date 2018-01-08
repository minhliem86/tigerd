@extends('Admin::layouts.main-layout')

@section('link')
    {!!Html::link(url()->previous(), 'Cancel', ['class'=>'btn btn-danger'])!!}
    <button class="btn btn-primary" onclick="submitForm();">Save Changes</button>
@stop

@section('title','Quản lý Sản Phẩm')

@section('content')
    <div class="row">
        @include("Admin::errors.error_layout")
        {!! Form::model($inst, ['route'=>['admin.product.update',$inst->id], 'method'=>'put', 'files'=>true, 'class'=> 'form form-horizontal' ])!!}
        <div class="col-md-7 col-sm-6">
            <fieldset>
                <div class="form-group">
                    <label class="col-md-2 control-label">Danh Mục Sản phẩm</label>
                    <div class="col-md-10">
                        {!! Form::select('category_id', ['' => 'Chọn Danh Mục Sản Phẩm'] + $cate, old('category_id'), ['class'=> 'form-control']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Tên Sản phẩm</label>
                    <div class="col-md-10">
                        {!!Form::text('name',old('name'), ['class'=>'form-control', 'placeholder'=>'Tên Sản Phẩm'])!!}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">
                        Mã Sản phẩm
                        <p><small>(từ 2,10 ký tự hoa. EX: Quần Tây -> QT)</small></p>
                    </label>
                    <div class="col-md-10">
                        {!!Form::text('sku_product',old('sku_product'), ['class'=>'form-control', 'placeholder'=>'Mã Sản Phẩm'])!!}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Mô tả</label>
                    <div class="col-md-10">
                        {!!Form::textarea('description',old('description'), ['class'=>'form-control', 'placeholder' => 'Mô tả'])!!}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Bài viết Sản Phẩm</label>
                    <div class="col-md-10">
                        {!!Form::textarea('content',old('content'), ['class'=>'form-control my-editor', 'placeholder' => 'Bài viết Sản Phẩm'])!!}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Giá</label>
                    <div class="col-md-10">
                        {!!Form::number('price',old('price'), ['class'=>'form-control number', 'placeholder'=>'Giá'])!!}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Giảm Giá</label>
                    <div class="col-md-10">
                        {!!Form::number('discount',old('discount'), ['class'=>'form-control number', 'placeholder'=>'0'])!!}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Nhập Kho</label>
                    <div class="col-md-10">
                        {!!Form::number('stock_quality',old('stock_quality'), ['class'=>'form-control number', 'placeholder'=>'0'])!!}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Hình Ảnh</label>
                    <div class="col-md-10">
                        <div class="input-group">
                    <span class="input-group-btn">
                        <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                            <i class="fa fa-picture-o"></i> Chọn
                        </a>
                    </span>
                            {!!Form::hidden('img_url',old('img_url'), ['class'=>'form-control', 'id'=>'thumbnail' ])!!}
                        </div>
                        <img id="holder" style="margin-top:15px;max-height:100px;" src="{!!asset($inst->img_url)!!}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label" for="description">Sắp xếp</label>
                    <div class="col-md-10">
                        {{Form::text('order',old('order'), ['class'=>'form-control', 'placeholder'=>'order'])}}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label" for="description">Trạng thái</label>
                    <div class="col-md-10">
                        <label class="toggle">
                            <input type="checkbox" name="status" value="1" {{$inst->status == 1 ? 'checked' : '' }}  >
                            <span class="handle"></span>
                        </label>
                    </div>
                </div>
            </fieldset>
            <fieldset class="area-control img-detail">
                <legend>
                    <div class="checkbox">
                        <input type="checkbox" name="img_detail" id="img_detail" class="trigger_input" {!! $inst->photos()->count() ? 'checked' : null !!}> HÌNH ẢNH CHI TIẾT
                    </div>
                </legend>
                <div class="container-fluid">
                    <div class="wrap-img_detail wrap_general">
                        <div class="container-fluid">
                            @if($inst->photos->count())
                                @foreach($inst->photos->chunk(4) as $chunk )
                                    <div class="row">
                                        @foreach($chunk as $photo)
                                            <div class="col-md-3">
                                                <div class="file-preview-frame krajee-default  file-preview-initial file-sortable kv-preview-thumb" data-template="image">
                                                    <div class="kv-file-content">
                                                        <img src="{!!asset($photo->img_url)!!}" class="file-preview-image kv-preview-data img-responsive" title="" alt="" style="width:auto;height:120px;">
                                                    </div>
                                                    <div class="photo-order-input" style="margin-bottom:10px">
                                                        <input type="text" class="form-control text-center" name="photo_order" value="{!!$photo->order!!}">
                                                    </div>
                                                    <div class="file-footer-buttons">
                                                        <button type="button" class="kv-file-remove btn btn-xs btn-default" title="Cập nhật vị trí" onclick="updatePhoto(this,{!!$photo->id!!})"><i class="glyphicon glyphicon-refresh text-warning"></i></button>
                                                        <button type="button" class="kv-file-remove btn btn-xs btn-default" title="Remove file" onclick="removePhoto(this,{!!$photo->id!!})"><i class="glyphicon glyphicon-trash text-danger"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <input type="file" name="thumb-input[]" id="thumb-input" multiple >
                    </div>
                </div>
            </fieldset>
            <fieldset class="area-control attribute-section">
                <legend>
                    <div class="flex-container">
                        <div class="checkbox flex-item">
                            <input type="checkbox" name="attribute_section" id="attribute_section" class="trigger_input" data-trigger=".btn-att" {!! $inst->attributes()->count() ? 'checked' : null !!}> THUỘC TÍNH SẢN PHẨM
                        </div>
                        <div class="flex-item text-right">
                            <button onclick="openModal('modal-add-attribute')" type="button" disabled class="btn btn-primary btn-att btn-xs" ><i class="fa fa-plus"></i> Thêm Mới</button>
                            <button type="button" onclick="removeATT('{!! route('admin.product.removeAttribute') !!}')" disabled class="btn btn-danger btn-remove-att btn-att btn-xs"><i class="fa fa-trash"></i> Xóa Thuộc Tính</button>
                        </div>
                    </div>
                </legend>
                <div class="wrap-attribute_section wrap_general">
                    @include('Admin::ajax.attribute.attribute')
                </div>
            </fieldset>
        </div>

        <div class="col-md-5 col-sm-6">
            <fieldset>
                <legend>
                    <div class="checkbox">
                        <input type="checkbox" name="meta_config" id="meta_config" {!! $inst->meta_configs()->count() ? 'checked' : null !!}> CẤU HÌNH SEO
                    </div>
                </legend>
                <div class="wrap-seo">
                    <div class="form-group clearfix">
                        <label class="col-md-2 control-label">Meta Keywords:</label>
                        <div class="col-md-10">
                            {!! Form::text('meta_keywords', $inst->meta_configs()->count() ? $inst->meta_configs()->first()->meta_keywords : '' , ['class'=> 'form-control', 'placeholder'=>"Từ khóa bài viết (ngăn cách bởi dấu `,`. Ex: quầy tây, quần kaki)"]) !!}
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        <label class="col-md-2 control-label">Meta Description:</label>
                        <div class="col-md-10">
                            {!! Form::text('meta_description', $inst->meta_configs()->count() ? $inst->meta_configs()->first()->meta_description : '', ['class'=> 'form-control', 'placeholder'=>"Mô tả bài viết"]) !!}
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        <label class="col-md-2 control-label">Hình ảnh SEO:</label>
                        <div class="col-md-10">
                            <div class="input-group">
                            <span class="input-group-btn">
                            <a id="lfm_meta" data-input="thumbnail_meta" data-preview="holder_meta" class="btn btn-primary">
                            <i class="fa fa-picture-o"></i> Chọn
                            </a>
                            </span>
                                {!!Form::hidden('meta_img',$inst->meta_configs()->count() ? $inst->meta_configs()->first()->meta_img : '', ['class'=>'form-control', 'id'=>'thumbnail_meta' ])!!}
                            </div>
                            <img id="holder_meta" style="margin-top:15px;max-height:100px;" src="{!! $inst->meta_configs()->count() ? asset($inst->meta_configs()->first()->meta_img) : null !!}">
                        </div>
                    </div>
                    {!! Form::hidden('meta_config_id',$inst->meta_configs()->count() ? $inst->meta_configs()->first()->id : '') !!}
                </div>
            </fieldset>
        </div>
        {!! Form::close() !!}
    </div>

    {{--ATTRIBUTE MODAL--}}
    <div class="modal fade" tabindex="-1" role="dialog" id="modal-add-attribute">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Thêm Thuộc Tính</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="" class="control-label">Tên Thuộc Tính</label>
                        <input type="text" name="att_name" class="form-control att">
                    </div>
                    <div class="form-group">
                        <label for="" class="control-label">Mô tả</label>
                        <textarea name="att_description" rows="3" class="form-control att"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="addAttribute( '{!! route('admin.product.createAttribute') !!}','modal-add-attribute')">Thêm</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    {{--ATTRIBUTE VALUE MODAL--}}
    <div class="modal fade" tabindex="-1" role="dialog" id="modal-add-value">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Thêm Giá Trị</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="att_id" class="form-control" value="">
                    <input type="hidden" name="att_slug" class="form-control" value="">

                    <div class="form-group">
                        <label for="" class="control-label">Giá Trị</label>
                        <input type="text" name="att_value" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="addValueAtt( '{!! route('admin.product.createAttValue') !!}','modal-add-value')">Thêm</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@endsection

@section('script')
    {{--ALERT--}}
    <link rel="stylesheet" href="{!! asset('public/assets/admin/dist/js/plugins/alertify/alertify.css') !!}">
    <script src="{!! asset('public/assets/admin/dist/js/plugins/alertify/alertify.js') !!}"></script>
    <script src="{!! asset('public/assets/admin/dist/js/plugins/jquery.number.min.js') !!}"></script>

    <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
    <script src="{!!asset('public')!!}/vendor/laravel-filemanager/js/lfm.js"></script>
    <script src="{!!asset('public/assets/admin/dist/js/script.js')!!}"></script>
    <!--BT Upload-->
    <link rel="stylesheet" href="{!!asset('/public/assets/admin')!!}/dist/js/plugins/bootstrap-input/css/fileinput.min.css">
    <script src="{!!asset('/public/assets/admin')!!}/dist/js/plugins/bootstrap-input/js/plugins/sortable.min.js"></script>
    <script src="{!!asset('/public/assets/admin')!!}/dist/js/plugins/bootstrap-input/js/plugins/purify.min.js"></script>
    <script src="{!!asset('/public/assets/admin')!!}/dist/js/plugins/bootstrap-input/js/fileinput.min.js"></script>

    <!-- ALERTIFY -->
    <link rel="stylesheet" href="{!!asset('/public/assets/admin')!!}/dist/js/plugins/alertify/alertify.css">
    <link rel="stylesheet" href="{!!asset('/public/assets/admin')!!}/dist/js/plugins/alertify/bootstrap.min.css">
    <script type="text/javascript" src="{!!asset('/public/assets/admin')!!}/dist/js/plugins/alertify/alertify.js"></script>

    <script>
        const url = "{!!url('/')!!}"
        init_tinymce(url);
        // BUTTON ALONE
        init_btnImage(url,'#lfm');
        init_btnImage(url,'#lfm_meta');
        // SUBMIT FORM
        function submitForm(){
            $('form').submit();
        }

        /*FUNCTION OPEn ATTRIBUTE MODAL*/
        function openModal(id){
            $('#'+id).modal('show');
        }

        /*CREATE ATTRIBUTE */
        function addAttribute(url,idModal)
        {
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url : url,
                type: 'POST',
                data: {name_att: $('input[name=att_name]').val(), description: $('textarea[name=att_description]').val() },
                success: function (data)
                {
                    if(data.rs == 'ok'){
                        $('.wrap-attribute_section').html(data.data)
                        $('#'+idModal).modal('hide');
                        $('input[name=att_name]').val('');
                        $('textarea[name=att_description]').val('');
                        $('.wrap-att-value').hide();
                        $(document).trigger('icheck');
                        $(document).trigger('icheckValue');
                    }
                }
            })
        }

        /*CREATE VALUE ATTRIBUTE*/
        function addValueAtt(url, idModal)
        {
            var att_id = $('input[name="att_id"]').val();
            var att_slug = $('input[name="att_slug"]').val();
            var value = $('input[name="att_value"]').val();

            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: url,
                type: 'POST',
                data: {att_id: att_id, value: value},
                success: function(data){
                    $('.append-value-'+att_slug).html(data.data);
                    $('#'+idModal).modal('hide');
                    $('input[name="att_value"]').val('');
                    $('input[name="att_slug"]').val('');
                    $('input[name="att_id"]').val('');
                    $(document).trigger('icheckValue');
                }
            })
        }

        /*FUNCTION REMOVE ATT OR VALUE*/
        function removeATT(url)
        {
            var array_att = $('input[name="att[]"]').map(function(){
                return $(this).prop('checked') == true ? $(this).val() : null;
            }).get();
            alertify.confirm("Một số thuộc tính được gán vào các sản phẩm khác nhau. Nếu bạn xóa thuộc tính sản phẩm liên quan sẽ không còn thuộc tính. Bạn có muốn xóa?", function(){
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: url,
                    type: 'POST',
                    data: {arr_att:array_att },
                    success: function(data){
                        if(data.error){
                            alertify.error(data.mes);
                        }else{
                            alertify.success(data.mes);
                            $('.wrap-attribute_section').html(data.data);
                            $('.wrap-att-value').hide();
                            $(document).trigger('icheck');
                            $(document).trigger('icheckValue');
                        }
                    }
                })
            })


        }

        function removeAttValue(id, att_id, att_slug)
        {
            alertify.confirm('Có nhiều sản phẩm sử dụng giá trị này. Bạn có muốn xóa giá trị này chứ ?', function () {
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: '{!! route('admin.product.removeAttributeValue') !!}',
                    type: 'POST',
                    data: {id: id, att_id:att_id},
                    success: function(data){
                        $('.append-value-'+att_slug).html(data.data);
                        $(document).trigger('icheck');
                        $(document).trigger('icheckValue');
                    }
                })
            })
        }


    </script>
    <script>
        $(document).ready(function(){
            /*CONFIG SEO*/
            var flag_seo = '{!! $inst->meta_configs()->count() ? true : false !!}';
            if(flag_seo){
                $('.wrap-seo').show();
            }else{
                $('.wrap-seo').hide();
            }
            $('input#meta_config').on('ifChecked', function (event) {
                $('.wrap-seo').slideDown();
            }).on('ifUnchecked', function (event) {
                $('.wrap-seo').slideUp();
            });

            /*CONFIG ATTRIBUTE*/
            var flag_att = '{!! $inst->attributes()->count() ? true : false !!}';
            if(flag_att){
                $('.wrap-attribute_section').show();
                $('.btn-att').prop('disabled', false);

            }else{
                $('.wrap-attribute_section').hide();
                $('.btn-att').prop('disabled', true);
            }

            /*CONFIG ATTRIBUTE VALUE */
            var flag_att_value = '{!! $inst->values()->count() ? true : false !!}';
            if(flag_att_value){
                $('.wrap-att-value').show();
                $('.btn-create-value').prop('disabled', false);

            }else{
                $('.wrap-att-value').hide();
                $('.btn-create-value').prop('disabled', true);
            }

            /*CONFIG DETAIL IMAGE*/
            var flag_img = '{!! $inst->photos()->count() ? true : false !!}';
            if(flag_img){
                $('.wrap-img_detail').show();
            }else{
                $('.wrap-img_detail').hide();
            }

            /*CONFIG ICHECK ATTRIBUTE*/
            $('input.trigger_input').on('ifChecked', function (event) {
                var name = $(this).attr('name');
                $('.wrap-'+name).slideDown();
                $($(this).data('trigger')).prop('disabled',false);

            }).on('ifUnchecked', function (event) {
                var name = $(this).attr('name');
                $('.wrap-'+name).slideUp();
                $($(this).data('trigger')).prop('disabled',true);
                $('.checkbox-att input').iCheck('uncheck');
            })

            /*TRIGGER icheck*/
            $(document).on('icheck', function() {
                $('.checkbox-att input').iCheck({
                    checkboxClass:"icheckbox_flat",
                    increaseArea:"20%"
                }).on('ifChecked', function(event){
                    var id_trigger = $(this).data('trigger');
                    $('#btn-att-create-'+id_trigger).prop('disabled',false);
                    $('#att_value_'+id_trigger).slideDown();
                }).on('ifUnchecked', function(event){
                    var id_trigger = $(this).data('trigger');
                    $('#btn-att-create-'+id_trigger).prop('disabled',true);
                    $('#att_value_'+id_trigger).slideUp();
                    $('.checkbox-value').iCheck('uncheck');
                });
            }).trigger('icheck');

            /*ATTACH VALUE TO MODAL ATTRIBUTE*/
            $('#modal-add-value').on('show.bs.modal', function(event){
                var att_id = $(event.relatedTarget).data('att-id');
                var att_slug = $(event.relatedTarget).data('att-slug');
                $('input[name="att_id"]').val(att_id);
                $('input[name="att_slug"]').val(att_slug);
            });

            $(document).on('icheckValue', function(){
                $('.checkbox-value input').iCheck({
                    checkboxClass:"icheckbox_flat",
                    increaseArea:"20%"
                })
            }).trigger('icheckValue');


            /*HINH CHI TIET*/
            $("#thumb-input").fileinput({
                uploadUrl: "{!!route('admin.product.update',$inst->id)!!}", // server upload action
                uploadAsync: true,
                showUpload: false,
                showCaption: false,
                browseLabel: "Thêm hình",
                dropZoneEnabled : false,
                fileActionSettings:{
                    showUpload : false,
                }
            })
        })

        function removePhoto(e, id){
            $.ajax({
                url: '{!!route("admin.product.AjaxRemovePhoto")!!}',
                type: 'POST',
                data:{id_photo: id, _token:$('meta[name="csrf-token"]').attr('content')},
                success:function(data){
                    if(!data.error){
                        e.parentNode.parentNode.parentNode.remove();
                    }
                }
            })
        }
        function updatePhoto(e, id){
            var value = e.parentNode.previousElementSibling.childNodes[1].value;
            $.ajax({
                url: '{!!route("admin.product.AjaxUpdatePhoto")!!}',
                type: 'POST',
                data:{id_photo: id, value: value, _token:$('meta[name="csrf-token"]').attr('content')},
                success:function(data){
                    if(!data.error){
                        alertify.success('Cập nhật thay đổi.');
                    }
                }
            })
        }
    </script>
@stop
