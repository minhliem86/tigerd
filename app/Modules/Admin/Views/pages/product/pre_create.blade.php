@extends('Admin::layouts.main-layout')

@section('link')

@stop

@section('title','Sản Phẩm')

@section('content')
    <div class="row">
        <div class="col-md-12">
            @include("Admin::errors.error_layout")
            {!! Form::open(['route' => 'admin.pre_create.product.post', 'class' => 'form']) !!}
                <div class="form-group">
                    <label for="type">Chọn loại sản phẩm</label>
                    {!! Form::select('type', ['simple' => 'Sản Phẩm đơn giản', 'configurable' => 'Sản Phẩm phức hợp'], old('type'), ['class' => 'form-control']) !!}
                </div>
            <div class="form-group">
                <button class="btn btn-primary">Tiếp Theo</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection

@section('script')

@stop
