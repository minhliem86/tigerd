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
                {!! Form::model($product,['route'=> ['admin.product.configuable.edit.post',$product->id], 'class' => 'form-horizontal']) !!}
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
    <script>
        const url = "{!!url('/')!!}"
        init_tinymce(url);
        // BUTTON ALONE
        init_btnImage(url,'#lfm');
        // SUBMIT FORM
        function submitForm(){
            $('form').submit();
        }
    </script>
@stop
