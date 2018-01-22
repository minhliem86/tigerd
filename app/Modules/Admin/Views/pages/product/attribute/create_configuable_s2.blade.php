@extends('Admin::layouts.main-layout')

@section('link')
    <button class="btn btn-primary" onclick="submitForm();">Save</button>
@stop

@section('title','Thuộc tính sản phẩm')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="col-sm-12">
                @include('Admin::errors.error_layout')
                <form method="POST" action="{{route('admin.create.product.configuable')}}" id="form" role="form" class="form-horizontal">
                    {{Form::token()}}
                    {!! Form::hidden('parent_product_id', $parent_product_id) !!}
                    {!! Form::hidden('type', 'simple') !!}
                    {!! Form::hidden('visibility', '1') !!}
                    <div class="form-group">
                        <label class="col-md-2 control-label">Tên Sản Phẩm:</label>
                        <div class="col-md-10">
                            {!! Form::text('name', old('name'), ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Mã Sản Phẩm:<p><small>(từ 2,3 ký tự hoa. EX: Quần Tây -> QT)</small></p></label>
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
                            {!! Form::textarea('description',old('description'), ['class'=> 'form-control my-editor', 'placeholder' => 'Mô tả ...']) !!}
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
                            {!!Form::number('stock_quality',old('stock_quality'), ['class'=>'form-control', 'placeholder'=>'0'])!!}
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
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')

@stop
