@extends('Admin::layouts.main-layout')

@section('link')
    <button class="btn btn-primary" onclick="submitForm();">Tiếp tục</button>
    <a class="btn btn-info">Tạo thuộc tính mới</a>
@stop

@section('title','Thêm Thuộc Tính Sản Phẩm')

@section('content')
    <div class="row">
        <div class="col-md-12">
            {!! Form::open(['route' => 'admin.create.product.postAttribute', 'class' => 'form']) !!}
            <div class="form-group">
                <label for="">Chọn Thuộc tính cho sản phẩm</label><Br/>
                <div class="container-fluid">
                    @foreach($attribute->chunk(3) as $item_chunk)
                        <div class="row">
                            @foreach($item_chunk as $item_att)
                                <div class="col-sm-4">
                                    <div class="checkbox">
                                        <input type="checkbox" name="att_choose[]" id="meta_config" value="{!! $item_att->id !!}"> {!! $item_att->name !!}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>

            </div>
            {!! Form::close() !!}
        </div>

    </div>
@stop

@section('script')
    <script>
        // SUBMIT FORM
        function submitForm(){
            $('form').submit();
        }
    </script>
@stop