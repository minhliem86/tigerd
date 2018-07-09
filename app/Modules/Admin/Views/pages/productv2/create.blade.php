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
        <form method="POST" action="{!!route('admin.product.store')!!}" id="form" role="form" class="form-horizontal form-create-product" enctype="multipart/form-data">
            {!!Form::token()!!}
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
                        <label class="col-md-2 control-label">
                            Hãng Sản Xuất
                        </label>
                        <div class="col-md-10">
                            {!!Form::text('agency',old('agency'), ['class'=>'form-control', 'placeholder'=>'Hãng Sản Xuất', 'required'])!!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Hình Ảnh Hãng Sản Xuất</label>
                        <div class="col-md-10">
                            <div class="input-group">
                         <span class="input-group-btn">
                           <a id="lfm-agency" data-input="thumbnail-agency" data-preview="holder-agency" class="btn btn-primary">
                             <i class="fa fa-picture-o"></i> Chọn
                           </a>
                         </span>
                                <input id="thumbnail-agency" class="form-control" type="hidden" name="agency_img_url">
                            </div>
                            <img id="holder-agency" style="margin-top:15px;max-height:100px;">
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
                        <label class="col-md-2 control-label">Hình Ảnh</label>
                        <div class="col-md-10">
                            <div class="input-group">
                         <span class="input-group-btn">
                           <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                             <i class="fa fa-picture-o"></i> Chọn
                           </a>
                         </span>
                                <input id="thumbnail" class="form-control" type="hidden" name="img_url">
                            </div>
                            <img id="holder" style="margin-top:15px;max-height:100px;">
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
                                <button type="button" class="btn btn-secondary" id="att-trigger">Sản Phẩm Nhiều Thuộc Tính</button>
                            </div>

                            <div class="thuoctinh-container hidden" style="padding:10px; border:1px solid #ccc; border-radius:5px;">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-md-12 attribute_process">
                                            <div class="control-thuoctinh" style="margin-bottom:10px;">
                                                <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modal_attribute"><i class="fa fa-plus"></i> Thêm Thuộc Tính Mới</button>
                                                <button type="button" class="btn btn-sm btn-primary" id="trigger_addmore_att"><i class="fa fa-plus" ></i> Thêm Dòng Thuộc Tính</button>
                                            </div>
                                            @include('Admin::ajax.script.manage_thuoctinh')
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>

                <fieldset>
                    <legend>
                        <div class="checkbox">
                            <input type="checkbox" name="meta_config" id="meta_config"> CẤU HÌNH SEO
                        </div>
                    </legend>
                    <div class="wrap-seo">
                        <div class="form-group clearfix">
                            <label class="col-md-2 control-label">Meta Keywords:</label>
                            <div class="col-md-10">
                                <input type="text" placeholder="Từ khóa bài viết (ngăn cách bởi dấu `,`. Ex: quầy tây, quần kaki)" id="meta_keywords" class="form-control" name="meta_keywords">
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-md-2 control-label">Meta Description:</label>
                            <div class="col-md-10">
                                <input type="text" placeholder="Mô tả bài viết" id="meta_description" class="form-control" name="meta_description">
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-md-2 control-label">Hình ảnh SEO:</label>
                            <div class="col-md-10">
                                <div class="input-group">
                            <span class="input-group-btn">
                            <a id="lfm-meta" data-input="thumbnail_meta" data-preview="holder_meta" class="btn btn-primary">
                            <i class="fa fa-picture-o"></i> Chọn
                            </a>
                            </span>
                                    <input id="thumbnail_meta" class="form-control" type="hidden" name="meta_img">
                                </div>
                                <img id="holder_meta" style="margin-top:15px;max-height:100px;">
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
        </form>
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
        init_btnImage(url,'#lfm-agency');
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
            $("#thumb-input").fileinput({
                uploadUrl: "{!!route('admin.product.store')!!}", // server upload action
                uploadAsync: true,
                showUpload: false,
                showBrowse: false,
                showCaption: false,
                showCancel: false,
                dropZoneEnabled : true,
                browseOnZoneClick: true,
                fileActionSettings:{
                    showUpload : false,
                    showZoom: false,
                    showDrag: false,
                    showDownload: false,
                    removeIcon: '<i class="fa fa-trash text-danger"></i>',
                },
                layoutTemplates: {
                    progress: '<div class="kv-upload-progress hidden"></div>'
                }
            })

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
            $('body').on('click','.trigger-value', function(){
                var thisButton = $(this);
                var value_att = thisButton.parent('.control-value').prev().find('select').val();
                $.ajax({
                    url: "{!! route('admin.attribute.addMoreAttValue') !!}",
                    data:{value_att: value_att },
                    type: "GET",
                    success: function(res){
                        thisButton.parent('.control-value').next('.attribute-section').append(res.data)
                    }
                })
            })

            $('body').on('click','#trigger_addmore_att', function(){
                $.ajax({
                    url: "{!! route('admin.attribute.addMoreAtt') !!}",
                    type: 'GET',
                    success: function(rs){
                        $('.attribute_process').append(rs.data);
                    }
                })

            });

            $("body").on('change', "select[name='attribute[]']", function(){
                var value = $(this).val();
                var input = $(this).parent().next().next('.attribute-section').find('.value-wrapper').find("input[type=text].input_field_value");
               input.each(function (index){
                   $(this).attr('name','att_value['+value+'][]');
               })
            });

            $("body").on('click','.trigger_upload_img', function () {
                var att_value = $(this).parent().prev('.each-value').children('input[type=text]').val();
                var thisButton = $(this);
                if(att_value){
                    $.ajax({
                        url: "{!! route('admin.attribute.value.img') !!}",
                        type: 'POST',
                        data:{id: att_value},
                        success:function(res){
                            if(res.data){
                                thisButton.parent().parent().parent('.value-wrapper').next('.img-wrapper').append(res.data);
                            }
                        }
                    })
                }else{
                    alert('Vui lòng nhập giá trị thuộc tính trước khi thêm hình ảnh.')
                }
            })

            $("body").on('click','.add_price_value', function () {
                var att_value = $(this).parent().prev('.each-value').children('input[type=text]').val();
                var thisButton = $(this);
                if(att_value){
                    $.ajax({
                        url: "{!! route('admin.attribute.value.price') !!}",
                        type: 'POST',
                        data:{id: att_value},
                        success:function(res){
                            if(res.data){
                                thisButton.parent().prev().find('.wrap-price-ajax').append(res.data);
                            }
                        }
                    })
                }else{
                    alert('Vui lòng nhập giá trị thuộc tính trước khi thêm giá.')
                }
            })

            $("body").on('change','.add_price_value', function () {
                var att_value = $(this).parent().prev('.each-value').children('input[type=text]').val();
                var thisButton = $(this);
                if(att_value){
                    $.ajax({
                        url: "{!! route('admin.attribute.value.price') !!}",
                        type: 'POST',
                        data:{id: att_value},
                        success:function(res){
                            if(res.data){
                                thisButton.parent().prev().find('.wrap-price-ajax').append(res.data);
                            }
                        }
                    })
                }else{
                    alert('Vui lòng nhập giá trị thuộc tính trước khi thêm giá.')
                }
            })


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
                    var att_name = $(form).find('input[name=att_name]').val();
                    var att_description = $(form).find('textarea[name=att_description]').val();
                    $.ajax({
                        url: "{!! route('admin.product.createAttribute') !!}",
                        data:{att_name: att_name, att_description: att_description},
                        type: 'POST',
                        success: function (res){
                            if(res.rs == 'ok'){
                                $("select.thuoctinh_select").append("<option value='"+res.data_id+"'>"+res.data_name+"</option>");
                                // $("select.already_select option:last").remove();
                            }
                            $('#modal_attribute').modal('hide');
                            $('body').on('hidden.bs.modal', '#modal_attribute', function () {
                                $(this).removeData('bs.modal');
                            });

                        }
                    })
                    return false;
                }
            })

        })
    </script>
@stop

