@extends('Admin::layouts.main-layout')

@section('link')
    <button class="btn btn-primary" onclick="submitForm();">Save</button>
@stop

@section('title','Danh Mục Sản Phẩm')

@section('content')
    <div class="row">
      <div class="col-sm-12">
          @include('Admin::errors.error_layout')
        <form method="POST" action="{{route('admin.category.store')}}" id="form" role="form" class="form-horizontal">
          {{Form::token()}}
            <div class="form-group">
                <label for="agency_id" class="col-md-2 control-label">Chọn Nhà Cung Cấp</label>
                <div class="col-md-10">
                    {!! Form::select('agency_id', ['' => 'Chọn Nhà Cung Cấp'] + $agency, old('agency_id'), ['class'=>'form-control', 'required'] ) !!}
                </div>
            </div>
          <div class="form-group">
            <label class="col-md-2 control-label">Tên: </label>
            <div class="col-md-10">
                {!! Form::text('name', old('name'), ['class'=> 'form-control', 'placeholder' => 'Tên Danh Mục']) !!}
            </div>
          </div>
            <div class="form-group">
                <label class="col-md-2 control-label">Mã Danh Mục: <p><small>(EX: Quần Tây -> QT)</small></p></label>
                <div class="col-md-10">
                    {!! Form::text('sku_cate', old('sku_cate'), ['class'=> 'form-control', 'placeholder' => 'Mã Danh Mục']) !!}
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
                     <input id="thumbnail" class="form-control" type="hidden" name="img_url">
                    </div>
                    <img id="holder" style="margin-top:15px;max-height:100px;">
                </div>
            </div>
        </form>
      </div>
    </div>
@endsection

@section('script')
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
