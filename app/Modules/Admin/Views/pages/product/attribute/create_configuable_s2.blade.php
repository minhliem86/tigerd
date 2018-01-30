@extends('Admin::layouts.main-layout')

@section('link')
    <a class="btn btn-warning" href="{!! url()->previous() !!}">Back</a>
    <button class="btn btn-primary" onclick="submitForm();">Save</button>
@stop

@section('title','Tạo Sản phẩm phức hợp')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="col-sm-12">
                @if(!$errors->errors_product_config->isEmpty())
                    <div class="alert alert-danger alert-dismissable">
                        @foreach($errors->errors_product_config->all() as $error)
                            <p>{!! $error !!}</p>
                        @endforeach
                    </div>
                @endif
                <form method="POST" action="{{route('admin.create.product.configuable.s2.post')}}" id="form" role="form" class="form-horizontal" enctype="multipart/form-data">
                    {{Form::token()}}
                    {!! Form::hidden('product_parent_id', Session::get('product_parent_id')) !!}
                    {!! Form::hidden('type', 'simple') !!}
                    {!! Form::hidden('visibility', '0') !!}
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
                        <label class="col-md-2 control-label">Bài viết sản phẩm:</label>
                        <div class="col-md-10">
                            {!! Form::textarea('content',old('content'), ['class'=> 'form-control my-editor', 'placeholder' => 'Mô tả ...']) !!}
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
                        <label class="col-md-2 control-label">Hình Ảnh:</label>
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
                    <fieldset>
                        <legend>Thuộc tính</legend>
                        @foreach($att as $item_att)
                            @php

                            @endphp
                            <div class="form-group">
                                <input type="hidden" name="att[]" value="{!! $item_att->id !!}">

                                <label class="col-md-2 control-label" for="">{!! $item_att->name !!}</label>
                                <div class="col-md-10">
                                    <input type="text" name="value[]" class="form-control" value="{!! old('value[]') !!}">
                                </div>
                            </div>
                        @endforeach
                    </fieldset>
                    <fieldset class="area-control img-detail">
                        <legend>
                            <div class="checkbox">
                                <input type="checkbox" name="img_detail" id="img_detail" class="trigger_input"> HÌNH ẢNH CHI TIẾT
                            </div>
                        </legend>
                        <div class="container-fluid">
                            <div class="wrap-img_detail wrap_general">
                                <input type="file" name="thumb-input[]" id="thumb-input" multiple >
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


                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <!--BT Upload-->
    <link rel="stylesheet" href="{!!asset('/public/assets/admin')!!}/dist/js/plugins/bootstrap-input/css/fileinput.min.css">
    <script src="{!!asset('/public/assets/admin')!!}/dist/js/plugins/bootstrap-input/js/plugins/sortable.min.js"></script>
    <script src="{!!asset('/public/assets/admin')!!}/dist/js/plugins/bootstrap-input/js/plugins/purify.min.js"></script>
    <script src="{!!asset('/public/assets/admin')!!}/dist/js/plugins/bootstrap-input/js/fileinput.min.js"></script>
    {{--ALERT--}}
    <link rel="stylesheet" href="{!! asset('public/assets/admin/dist/js/plugins/alertify/alertify.css') !!}">
    <script src="{!! asset('public/assets/admin/dist/js/plugins/alertify/alertify.js') !!}"></script>
    <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
    <script src="{!!asset('public')!!}/vendor/laravel-filemanager/js/lfm.js"></script>
    <script src="{!!asset('public/assets/admin/dist/js/script.js')!!}"></script>
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

        $(document).ready(function(){
            $('.wrap-seo').hide();
            $('.wrap-img_detail').hide();
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
                uploadAsync: true,
                showUpload: false,
                showCaption: false,
                dropZoneEnabled : false,
                fileActionSettings:{
                    showUpload : false,
                }
            })


        })
    </script>
@stop

