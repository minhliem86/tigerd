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
                            <p><small>(EX: Quần Tây -> QT)</small></p>
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
                            {!!Form::number('price',old('price'), ['class'=>'form-control', 'placeholder'=>'Giá'])!!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Giảm Giá</label>
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
                </fieldset>
            </div>

            <div class="col-md-5 col-sm-6">
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

                    <div class="form-group">
                        <label for="" class="control-label">Giá Thuộc Tính (tùy chọn)</label>
                        <input type="number" min="0" name="att_price" class="form-control">
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

        /*CREATE VALUE ATTRIBUTE*/
        function addValueAtt(url, idModal)
        {
            var att_id = $('input[name="att_id"]').val();
            var att_slug = $('input[name="att_slug"]').val();
            var value = $('input[name="att_value"]').val();
            var price = $('input[name="att_price"]').val();

            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: url,
                type: 'POST',
                data: {att_id: att_id, value: value, price: price},
                success: function(data){
//                    $('.append-value-'+att_slug).html(data.data);
                    $('.append-value-'+att_slug).append(data.data)
                    $('#'+idModal).modal('hide');
                    $('input[name="att_value"]').val('');
                    $('input[name="att_slug"]').val('');
                    $('input[name="att_id"]').val('');
                    $('input[name="att_price"]').val('');
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
            console.log(array_att);
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
                            array_att.forEach(function (ele) {
                                $('#att-'+ele).remove();
                            });
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
                        if(!data.error){
                            $('#att-value-'+id).remove();
                        }
                        $(document).trigger('icheck');
                        $(document).trigger('icheckValue');
                    }
                })
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

            /*CONFIG ATTRIBUTE*/
            $('.wrap_general, .wrap-att-value').hide();

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
                    $('#att_value_'+id_trigger).find('input').iCheck('uncheck')
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
        })
    </script>
@stop

