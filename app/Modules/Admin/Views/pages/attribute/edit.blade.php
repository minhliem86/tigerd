@extends('Admin::layouts.main-layout')

@section('link')
    <button class="btn btn-primary" onclick="submitForm();">Save</button>
@stop

@section('title','Thuộc Tính Sản Phẩm')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            @include('Admin::errors.error_layout')
            {!! Form::model($attribute,['route' => ['admin.attribute.update',$attribute->id], 'class'=>'form-horizontal']) !!}
                {!! Form::hidden('url', Session::has('url') ? Session::get('url') : '') !!}
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

@section("script")
    <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
    <script src="{{asset('public')}}/vendor/laravel-filemanager/js/lfm.js"></script>
    <script src="{{asset('public/assets/admin/dist/js/script.js')}}"></script>
    <script>
        const url = "{{url('/')}}"
        init_tinymce(url);
        // BUTTON ALONE
        init_btnImage(url,'#lfm');
        // SUBMIT FORM
        function submitForm(){
            $('form').submit();
        }
    </script>
@stop
