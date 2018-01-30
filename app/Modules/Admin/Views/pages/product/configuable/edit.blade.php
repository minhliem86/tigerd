@extends('Admin::layouts.main-layout')

@section('link')
    <a class="btn btn-warning" href="{!! url()->previous() !!}">Back</a>
    <button class="btn btn-primary" onclick="submitForm();">Save</button>
@stop

@section('title','Thuộc tính sản phẩm')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="col-sm-12">
                @include('Admin::errors.error_layout')
                {!! Form::model($product,['route'=> ['admin.product.configuable.edit.post',$product->id], 'class' => 'form-horizontal', 'files'=>true]) !!}
                    {!! Form::hidden('product_parent_id', $parent_product->id) !!}
                    {!!Form::hidden('type', 'simple')!!}
                    {!!Form::hidden('visibility', '0')!!}
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
                                {!!Form::hidden('img_url',old('img_url'), ['class'=>'form-control', 'id'=>'thumbnail' ])!!}
                            </div>
                            <img id="holder" style="margin-top:15px;max-height:100px;" src="{{asset($product->img_url)}}">
                        </div>
                    </div>
                    <fieldset>
                        <legend>Thuộc tính</legend>
                        @foreach($product->values as $item_att)
                            <div class="form-group">
                                {!! Form::hidden('att[]', $item_att->attributes->id) !!}
                                <label class="col-md-2 control-label" for="">{!! $item_att->attributes->name !!}</label>
                                <div class="col-md-10">
                                    {!! Form::hidden('value_id[]', $item_att->id) !!}
                                    {!! Form::text('value[]',$item_att->value ? $item_att->value : '',['class'=>'form-control']) !!}
                                </div>
                            </div>
                        @endforeach
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
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection

@section('script')
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
        // SUBMIT FORM
        function submitForm(){
            $('form').submit();
        }

        $(document).ready(function(){
            /*CONFIG DETAIL IMAGE*/
            var flag_img = '{!! $product->photos()->count() ? true : false !!}';
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
            /*HINH CHI TIET*/
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
