@extends('Admin::layouts.main-layout')

@section('link')
    <button class="btn btn-primary" onclick="submitForm();">Save</button>
@stop

@section('title','Thông tin chung')

@section('content')
    <div class="row">
        <div class="col-md-12">
            @include('Admin::errors.error_layout')
                {!! Form::model($product,['route' => ['admin.product.configuable.s1.edit.post', $product->id], 'class' => 'form-horizontal', 'id'=>'form', 'method' => 'POST', 'files' => true]) !!}
                <div class="form-group">
                    <label for="agency_id" class="col-md-2 control-label">Chọn Danh Mục Sản Phẩm</label>
                    <div class="col-md-10">
                        {!! Form::select('category_id', ['' => 'Chọn Danh Mục Sản Phẩm'] + $cate, old('category_id'), ['class'=>'form-control', 'required'] ) !!}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Tên Sản Phẩm:</label>
                    <div class="col-md-10">
                        {!! Form::text('name', old('name'), ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Mã Sản Phẩm:<p><small>(EX: Quần Tây -> QT)</small></p></label>
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
                        <img id="holder" style="margin-top:15px;max-height:100px;" src="{{asset($product->img_url)}}">
                    </div>
                </div>
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

            <fieldset class="area-control img-detail">
                <legend>
                    <div class="checkbox">
                        <input type="checkbox" name="img_detail" id="img_detail" class="trigger_input" {!! $product->photos()->count() ? 'checked' : null !!}> HÌNH ẢNH CHI TIẾT
                    </div>
                </legend>
                <div class="container-fluid">
                    <div class="wrap-img_detail wrap_general">
                        <div class="container-fluid">
                            @if($product->photos->count())
                                @foreach($product->photos->chunk(4) as $chunk )
                                    <div class="row">
                                        @foreach($chunk as $photo)
                                            <div class="col-lg-2 col-md-3 col-sm-4">
                                                <div class="file-preview-frame krajee-default  file-preview-initial file-sortable kv-preview-thumb" data-template="image">
                                                    <div class="kv-file-content">
                                                        <img src="{!!asset($photo->img_url)!!}" class="file-preview-image kv-preview-data img-responsive" title="" alt="" style="width:auto;height:120px; margin:0 auto">
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
            $('.wrap-seo').hide();
            /*CONFIG DETAIL IMAGE*/
            var flag_img = '{!! $product->photos()->count() ? true : false !!}';
            if(flag_img){
                $('.wrap-img_detail').show();
            }else{
                $('.wrap-img_detail').hide();
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
                uploadUrl: "{!!route('admin.product.update',$product->id)!!}", // server upload action
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
