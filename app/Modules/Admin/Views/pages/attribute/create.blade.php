@extends('Admin::layouts.main-layout')

@section('link')
    <button class="btn btn-primary" onclick="submitForm();">Save</button>
@stop

@section('title','Thuộc Tính Sản Phẩm')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            @include('Admin::errors.error_layout')
            <form method="POST" action="{{route('admin.attribute.create.post')}}" id="form" role="form" class="form-horizontal">
                {{Form::token()}}
                {!! Form::hidden('url', $url ? $url : '') !!}
                <div class="form-group">
                    <label class="col-md-2 control-label">Tên Thuộc Tính: </label>
                    <div class="col-md-10">
                        {!! Form::text('name', old('name'), ['class'=> 'form-control', 'placeholder' => 'Tên Thuộc Tính']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Mô tả ngắn:</label>
                    <div class="col-md-10">
                        {!! Form::textarea('description',old('description'), ['class'=> 'form-control', 'placeholder' => 'Mô tả ...']) !!}
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
