@extends('Admin::layouts.main-layout')

@section('link')
    <button class="btn btn-primary" onclick="submitForm();">Save</button>
@stop

@section('title','Sản Phẩm')

@section('css')
    <style>
        /* Mimic table appearance */
        div.album{
            margin:10px 0;
        }
        div#actions{
            margin-bottom:10px;
        }
        div.table {
            display: table;
        }
        div.table .file-row {
            display: table-row;
        }
        div.table .file-row > div {
            display: table-cell;
            vertical-align: top;
            border-top: 1px solid #ddd;
            padding: 8px;
        }
        div.table .file-row:nth-child(odd) {
            background: #f9f9f9;
        }



        /* The total progress gets shown by event listeners */
        #total-progress {
            opacity: 0;
            transition: opacity 0.3s linear;
        }

        /* Hide the progress bar when finished */
        #previews .file-row.dz-success .progress {
            opacity: 0;
            transition: opacity 0.3s linear;
        }

        /* Hide the delete button initially */
        #previews .file-row .delete {
            display: none;
        }

        /* Hide the start and cancel buttons and show the delete button */

        #previews .file-row.dz-success .start,
        #previews .file-row.dz-success .cancel {
            display: none;
        }
        #previews .file-row.dz-success .delete {
            display: block;
        }
    </style>
@stop

@section('content')
    <div class="row">
        @include("Admin::errors.error_layout")
            {!! Form::model($inst,['route' => ['admin.product.update', $inst->id], 'method' => 'PUT', 'files' => true, 'class' => 'form-horizontal form-edit-product']) !!}
            <div class="col-md-12">
                <fieldset>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Danh Mục Sản phẩm</label>
                        <div class="col-md-10">
                            {!! Form::select('category_id', ['' => 'Chọn Danh Mục Sản Phẩm'] + $cate, old('category_id'), ['class'=> 'form-control','required']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Tên Sản phẩm</label>
                        <div class="col-md-10">
                            {!!Form::text('name',old('name'), ['class'=>'form-control', 'placeholder'=>'Tên Sản Phẩm', 'required'])!!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">
                            Mã Sản phẩm
                            <p><small>(EX: Quần Tây -> QT)</small></p>
                        </label>
                        <div class="col-md-10">
                            {!!Form::text('sku_product',old('sku_product'), ['class'=>'form-control', 'placeholder'=>'Mã Sản Phẩm', 'required'])!!}
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
                            {!!Form::number('price',old('price'), ['class'=>'form-control', 'placeholder'=>'Giá', 'required'])!!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Giá sau khi giảm</label>
                        <div class="col-md-10">
                            {!!Form::number('discount',old('discount'), ['class'=>'form-control', 'placeholder'=>'0'])!!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Nhập Kho</label>
                        <div class="col-md-10">
                            {!!Form::number('stock',old('stock'), ['class'=>'form-control', 'placeholder'=>'0'])!!}
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
                            <img id="holder" style="margin-top:15px;max-height:100px;" src="{!!asset('public/upload/'.$inst->img_url)!!}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Hình Chi Tiết (opt)</label>
                        <div class="col-md-10">
                            <div class="photo-container">
                                <input type="file" name="thumb-input[]" id="thumb-input" multiple >
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-10 col-md-offset-2">
                            <div class="thuoctinh-wrapper" style="margin-bottom:10px">
                                <button type="button" class="btn btn-secondary" id="att-trigger">{!! $inst->attributes->isEmpty() ? 'Sản Phẩm Nhiều Thuộc Tính' : 'Hủy' !!}</button>
                            </div>

                            <div class="thuoctinh-container {!! $inst->attributes->isEmpty() ? 'hidden' : 'show' !!}" style="padding:10px; border:1px solid #ccc; border-radius:5px;">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-md-12 attribute_process">
                                            <div class="control-thuoctinh" style="margin-bottom:10px;">
                                                <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modal_attribute"><i class="fa fa-plus"></i> Thêm Thuộc Tính Mới</button>
                                                <button type="button" class="btn btn-sm btn-primary" id="trigger_addmore_att"><i class="fa fa-plus" ></i> Thêm Dòng Thuộc Tính</button>
                                            </div>
                                            @if(!$inst->attributes->isEmpty())
                                                @foreach($inst->attributes as $item_attribute)
                                            <div class="manage-thuoctinh" style="margin-bottom:15px; padding-bottom:10px; border-bottom:1px solid lightgrey">
                                                <div class="row">
                                                        <div class="col-md-3">
                                                            {!! Form::select('attribute[]', ['' => 'Chọn thuộc tính'] + $attribute_list, $item_attribute->id, ['class' => 'form-control']) !!}
                                                        </div>
                                                        <div class="col-md-9">
                                                            <div class="value-wrapper">
                                                                @if(!$item_attribute->attribute_values->isEmpty())
                                                                    @if(!$item_attribute->attribute_values()->where('product_id',$inst->id)->get()->isEmpty())
                                                                        @foreach($item_attribute->attribute_values()->where('product_id',$inst->id)->get() as $item_value)
                                                                        <div class="each-value" style="margin-bottom:10px">
                                                                            <input type="text" name="att_value[{!! $item_attribute->id ? $item_attribute->id : null  !!}][]" class="form-control" placeholder="Giá trị thuộc tính. VD: 500g" value="{!! $item_value->value ? $item_value->value : '' !!}">
                                                                        </div>
                                                                        @endforeach
                                                                    @else
                                                                        <div class="each-value" style="margin-bottom:10px">
                                                                            <input type="text" name="att_value[{!! $item_attribute->id!!}][]" class="form-control" placeholder="Giá trị thuộc tính. VD: 500g">
                                                                        </div>
                                                                    @endif
                                                                @else
                                                                        <div class="each-value" style="margin-bottom:10px">
                                                                            <input type="text" name="att_value[{!! $item_attribute->id!!}][]" class="form-control" placeholder="Giá trị thuộc tính. VD: 500g">
                                                                        </div>
                                                                @endif
                                                            </div>
                                                            <div class="control-value text-right">

                                                                <button type="button" class="btn btn-sm btn-warning trigger-value"><i class="fa fa-plus"></i> Thêm giá trị</button>

                                                            </div>
                                                        </div>
                                                    </div>
                                            </div>
                                                @endforeach
                                                @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>

                <fieldset>
                    <legend>
                        <div class="checkbox my-checkbox">
                            <input type="checkbox" name="meta_config" id="meta_config" {!! $inst->meta_configs()->count() ? 'checked' : null !!}> CẤU HÌNH SEO
                        </div>
                    </legend>
                    <div class="wrap-seo">
                        <div class="form-group">
                            <label class="col-md-2 control-label">Meta Keywords:</label>
                            <div class="col-md-10">
                                {!! Form::text('meta_keywords', $inst->meta_configs()->count() ? $inst->meta_configs()->first()->meta_keywords : '' , ['class'=> 'form-control', 'placeholder'=>"Từ khóa bài viết (ngăn cách bởi dấu `,`. Ex: quầy tây, quần kaki)"]) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">Meta Description:</label>
                            <div class="col-md-10">
                                {!! Form::text('meta_description', $inst->meta_configs()->count() ? $inst->meta_configs()->first()->meta_description : '', ['class'=> 'form-control', 'placeholder'=>"Mô tả bài viết"]) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">Hình ảnh SEO:</label>
                            <div class="col-md-10">
                                <div class="input-group">
                            <span class="input-group-btn">
                            <a id="lfm_meta" data-input="thumbnail_meta" data-preview="holder_meta" class="btn btn-primary">
                            <i class="fa fa-picture-o"></i> Chọn
                            </a>
                            </span>
                                    {{Form::hidden('meta_img',$inst->meta_configs()->count() ? $inst->meta_configs()->first()->meta_img : '', ['class'=>'form-control', 'id'=>'thumbnail_meta' ])}}
                                </div>
                                <img id="holder_meta" style="margin-top:15px;max-height:100px;" src="{!! $inst->meta_configs()->count() ? asset('public/upload/'.$inst->meta_configs()->first()->meta_img) : null !!}">
                            </div>
                        </div>
                        {!! Form::hidden('meta_config_id',$inst->meta_configs()->count() ? $inst->meta_configs()->first()->id : '') !!}
                    </div>
                </fieldset>
            </div>
        {!! Form::close() !!}
    </div>
    {{--ATTRIBUTE MODAL--}}
    <div class="modal fade" tabindex="-1" role="dialog" id="modal_attribute">
        {!! Form::open(['class' =>'form_create_att']) !!}
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
                    <button type="submit" class="btn btn-primary" id="btn-addAttribute">Thêm</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
        {!! Form::close() !!}
    </div><!-- /.modal -->
    <div class="manage-thuoctinh copy hidden" style="margin-bottom:15px; padding-bottom:10px; border-bottom:1px solid lightgrey">
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
@endsection

@section('script')
    <script src="{!! asset('public/assets/admin/dist/js/plugins/jquery.masknumber.js') !!}"></script>
    {{--ALERT--}}
    <link rel="stylesheet" href="{!! asset('public/assets/admin/dist/js/plugins/alertify/alertify.css') !!}">
    <script src="{!! asset('public/assets/admin/dist/js/plugins/alertify/alertify.js') !!}"></script>
    <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
    <script src="{!!asset('public')!!}/vendor/laravel-filemanager/js/lfm.js"></script>
    <script src="{!!asset('public/assets/admin/dist/js/script.js')!!}"></script>


    <!--BT Upload-->
    <link rel="stylesheet" href="{!!asset('/public/assets/admin')!!}/dist/js/plugins/bootstrap-input/css/fileinput.min.css">
    <script src="{!!asset('/public/assets/admin')!!}/dist/js/plugins/bootstrap-input/js/plugins/sortable.min.js"></script>
    <script src="{!!asset('/public/assets/admin')!!}/dist/js/plugins/bootstrap-input/js/plugins/purify.min.js"></script>
    <script src="{!!asset('/public/assets/admin')!!}/dist/js/plugins/bootstrap-input/js/fileinput.min.js"></script>

    <script type="text/javascript" src="{!! asset('public/assets/admin') !!}/dist/js/jquery.validate.min.js"></script>

    <script>
        const url = "{!!url('/')!!}"
        init_tinymce(url);
        // BUTTON ALONE
        init_btnImage(url,'#lfm');
        init_btnImage(url,'#lfm-meta');
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
                        $('.append-attribute').append(data.data)
                        $('#'+idModal).modal('hide');
                        $('input[name=att_name]').val('');
                        $('textarea[name=att_description]').val('');
                        $(document).trigger('icheck');
                        $(document).trigger('icheckValue');
                    }
                }
            })
        }

        $(document).ready(function(){
            /*CONFIG SEO*/
            $('.wrap-seo').hide();
            $('input#meta_config').on('ifChecked', function (event) {
                $('.wrap-seo').slideDown();
            }).on('ifUnchecked', function (event) {
                $('.wrap-seo').slideUp();
            });
            
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
        })


        $(document).ready(function(){
            /*HINH CHI TIET*/
            $("#thumb-input").fileinput({
                uploadUrl: "{!!route('admin.product.store')!!}", // server upload action
                uploadAsync: false,
                showUpload: false,
                showCancel: false,
                showCaption: false,
                dropZoneEnabled : true,
                showBrowse: false,
                overwriteInitial: false,
                browseOnZoneClick: true,
                fileActionSettings:{
                    showUpload : false,
                    showZoom: false,
                    showDrag: false,
                    showDownload: false,
                    removeIcon: '<i class="fa fa-trash text-danger"></i>',
                },
                initialPreview: [
                    @foreach($inst->photos as $photo)
                        "{!!asset($photo->thumb_url)!!}",
                    @endforeach
                ],
                initialPreviewAsData: true,
                initialPreviewFileType: 'image',
                initialPreviewConfig: [
                        @foreach($inst->photos as $item_photo)
                    {'url': '{!! route("admin.product.AjaxRemovePhoto") !!}', key: "{!! $item_photo->id !!}", caption: "{!! $item_photo->filename !!}"},
                    @endforeach
                ],
                layoutTemplates: {
                    progress: '<div class="kv-upload-progress hidden"></div>'
                },
            });

            @if($inst->attributes->isEmpty())
            /*ATT TRIGGER*/
            $('.thuoctinh-container').hide();
            var att_con = $('.thuoctinh-container');
            $('#att-trigger').on('click', function(){
                if($('.thuoctinh-container').is(':hidden')){
                    att_con.removeClass('hidden').addClass('show');
                    $(this).text('Hủy');
                }else{
                    att_con.removeClass('show').addClass('hidden');
                    $(this).text('Sản Phẩm Nhiều Thuộc Tính');
                    $("select[name='attribute[]']").val('');
                    $('.each-value').each(function(index){
                        $(this).find('input[type=text]').val('');
                    })
                }
            })
            @else
                $('.thuoctinh-container').hide();
                var att_con = $('.thuoctinh-container');
                $('#att-trigger').on('click', function(){
                    if($('.thuoctinh-container').is(':hidden')){
                        att_con.removeClass('hidden').addClass('show');
                        $(this).text('Hủy');
                    }else{
                        alertify.confirm('Nếu Hủy, tất cả thuộc tính trong sản phẩm sẽ được gỡ bỏ. Bạn có đồng ý ?', function(e){
                            if(e){
                                att_con.removeClass('show').addClass('hidden');
                                $(this).text('Sản Phẩm Nhiều Thuộc Tính');
                                $("select[name='attribute[]']").val('');
                                $('.each-value').each(function(index){
                                    $(this).find('input[type=text]').val('');
                                })
                                $.ajax({
                                    url: "{!! route('admin.product.removeAttribute') !!}",
                                    type: "POST",
                                    data: {product_id : {!! $inst->id !!}},
                                    success: function(data){
                                        if(!data.error){
                                            alertify.success('Thuộc tính sản phẩm đã được gỡ bỏ.');
                                        }

                                    }
                                })
                            }
                        })

                    }
                })
                    @endif
            $('body').on('click','.trigger-value', function(){
                var str = $(this).parent('.control-value').prev().children('.each-value').first().clone();
                str.find('input[type=text]').val('');
                $(this).parent('.control-value').prev().append(str);
            })

            $('body').on('click','#trigger_addmore_att', function(){
                var manage =$('.manage-thuoctinh.copy').clone().removeClass('copy').removeClass('hidden').addClass('show');
                $('.attribute_process').append(manage);
            });

            $("body").on('change', "select[name='attribute[]']", function(){
                var value = $(this).val();
                var input = $(this).parent().next().find('.value-wrapper').find("input[type=text]");
                input.each(function (index){
                    $(this).attr('name','att_value['+value+'][]');
                })
            });

            /*ADD NEW ATTRIBUTE*/
            $('.form_create_att').validate({
                rules:{
                    att_name:{
                        required: true,
                        async:false,
                        remote: "{!! route('admin.product.checkRuleAttribute') !!}",
                    }
                },
                messages: {
                    att_name:{
                        required: 'Vui lòng điền thông tin',
                        remote: 'Thuộc tính đã tồn tại'
                    }
                },
                submitHandler: function(form){
                    return false;
                    var att_name = $(form).find('input[name=att_name]').val();
                    var att_description = $(form).find('textarea[name=att_description]').val();
                    $.ajax({
                        url: "{!! route('admin.product.createAttribute') !!}",
                        data:{att_name: att_name, att_description: att_description},
                        type: 'POST',
                        success: function (res){
                            if(res.rs == 'ok'){
                                $("select[name='attribute[]']").append("<option value='"+res.data_id+"'>"+res.data_name+"</option>");
                            }
                            $('#modal_attribute').modal('hide');
                            $('body').on('hidden.bs.modal', '#modal_attribute', function () {
                                $(this).removeData('bs.modal');
                            });

                        }
                    })

                }


            })

        })
    </script>
@stop

