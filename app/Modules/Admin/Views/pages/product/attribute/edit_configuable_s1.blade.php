@extends('Admin::layouts.main-layout')

@section('link')
    <button class="btn btn-primary" onclick="submitForm();">Save</button>
@stop

@section('title','Thông tin chung')

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
        <div class="col-md-12">
            @include('Admin::errors.error_layout')
                {!! Form::model($product,['route' => ['admin.product.configuable.s1.edit.post', $product->id], 'class' => 'form-horizontal', 'id'=>'form', 'method' => 'POST', 'files' => true]) !!}
                <fielset>
                    <div class="form-group">
                        <label for="agency_id" class="col-md-2 control-label">Chọn Danh Mục Sản Phẩm</label>
                        <div class="col-md-10">
                            {!! Form::select('category_id', ['' => 'Chọn Danh Mục Sản Phẩm'] + $cate, old('category_id'), ['class'=>'form-control', 'required'] ) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Tên Hiển Thị:</label>
                        <div class="col-md-10">
                            {!! Form::text('name', old('name'), ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Mã:<p><small>(EX: Quần Tây -> QT)</small></p></label>
                        <div class="col-md-10">
                            {!! Form::text('sku_product', old('sku_product'), ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Mô tả ngắn:</label>
                        <div class="col-md-10">
                            {!! Form::textarea('description',old('description'), ['class'=> 'form-control', 'placeholder' => 'Mô tả ...']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Hình Ảnh:</label>
                        <div class="col-md-10">
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                                        <i class="fa fa-picture-o"></i> Chọn
                                    </a>
                                </span>
                                {!!Form::hidden('img_url',old('img_url'), ['class'=>'form-control', 'id'=>'thumbnail' ])!!}
                            </div>
                            <img id="holder" style="margin-top:15px;max-height:100px;" src="{{asset('public/upload/'.$product->img_url)}}">
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
                </fielset>

                <fieldset>
                    <legend>
                        <div class="checkbox">
                            <input type="checkbox" name="meta_config" id="meta_config" {!! $product  ->meta_configs()->count() ? 'checked' : null !!}> CẤU HÌNH SEO
                        </div>
                    </legend>
                    <div class="wrap-seo">
                        <div class="form-group clearfix">
                            <label class="col-md-2 control-label">Meta Keywords:</label>
                            <div class="col-md-10">
                                {!! Form::text('meta_keywords', $product->meta_configs()->count() ? $product->meta_configs()->first()->meta_keywords : '' , ['class'=> 'form-control', 'placeholder'=>"Từ khóa bài viết (ngăn cách bởi dấu `,`. Ex: quầy tây, quần kaki)"]) !!}
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-md-2 control-label">Meta Description:</label>
                            <div class="col-md-10">
                                {!! Form::text('meta_description', $product->meta_configs()->count() ? $product->meta_configs()->first()->meta_description : '', ['class'=> 'form-control', 'placeholder'=>"Mô tả bài viết"]) !!}
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
                                    {!!Form::hidden('meta_img',$product->meta_configs()->count() ? $product->meta_configs()->first()->meta_img : '', ['class'=>'form-control', 'id'=>'thumbnail_meta' ])!!}
                                </div>
                                <img id="holder_meta" style="margin-top:15px;max-height:100px;" src="{!! $product->meta_configs()->count() ? asset('public/upload/'.$product->meta_configs()->first()->meta_img) : null !!}">
                            </div>
                        </div>
                    {!! Form::hidden('meta_id',$product->meta_configs()->count() ? $product->meta_configs()->first()->id : '') !!}
                </div>
                </fieldset>
            {!! Form::close() !!}
        </div>

    </div>
@endsection

@section('script')
    <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
    <script src="{!!asset('public')!!}/vendor/laravel-filemanager/js/lfm.js"></script>
    <script src="{!!asset('public/assets/admin/dist/js/script.js')!!}"></script>

    <!-- ALERTIFY -->
    <link rel="stylesheet" href="{{asset('/public/assets/admin')}}/dist/js/plugins/alertify/alertify.css">
    <link rel="stylesheet" href="{{asset('/public/assets/admin')}}/dist/js/plugins/alertify/bootstrap.min.css">
    <script type="text/javascript" src="{{asset('/public/assets/admin')}}/dist/js/plugins/alertify/alertify.js"></script>

    <!--BT Upload-->
    <link rel="stylesheet" href="{!!asset('/public/assets/admin')!!}/dist/js/plugins/bootstrap-input/css/fileinput.min.css">
    <script src="{!!asset('/public/assets/admin')!!}/dist/js/plugins/bootstrap-input/js/plugins/sortable.min.js"></script>
    <script src="{!!asset('/public/assets/admin')!!}/dist/js/plugins/bootstrap-input/js/plugins/purify.min.js"></script>
    <script src="{!!asset('/public/assets/admin')!!}/dist/js/plugins/bootstrap-input/js/fileinput.min.js"></script>

    <script>
        const url = "{!!url('/')!!}"
        // BUTTON ALONE
        init_btnImage(url,'#lfm-meta');
        init_btnImage(url,'#lfm');
        // SUBMIT FORM
        function submitForm(){
            $('form').submit();
        }
        $(document).ready(function(){
            /*CONFIG SEO*/
            var flag_seo = '{!! $product->meta_configs()->count() ? true : false !!}';
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
                    @foreach($product->photos as $photo)
                        "{!!asset($photo->thumb_url)!!}",
                    @endforeach
                ],
                initialPreviewAsData: true,
                initialPreviewFileType: 'image',
                initialPreviewConfig: [
                        @foreach($product->photos as $item_photo)
                    {'url': '{!! route("admin.product.AjaxRemovePhoto") !!}', key: "{!! $item_photo->id !!}", caption: "{!! $item_photo->filename !!}"},
                    @endforeach
                ],
                layoutTemplates: {
                    progress: '<div class="kv-upload-progress hidden"></div>'
                },
            });
        })
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
