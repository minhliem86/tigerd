@extends('Admin::layouts.main-layout')

@section('link')
    <button class="btn btn-primary" onclick="submitForm();">Save</button>
@stop

@section('title','Ý kiến khách hàng')

@section('content')
    <div class="row">
      <div class="col-sm-12">
          @include('Admin::errors.error_layout')
        <form method="POST" action="{{route('admin.customer-idea.store')}}" id="form" role="form" class="form-horizontal">
          {{Form::token()}}
            <div class="form-group">
                <label class="col-md-2 control-label">Ý kiến cho sản phẩm: </label>
                <div class="col-md-10">
                    {!! Form::select('product_id',['' => 'Chọn sản phẩm'] + $list_product, old('product_id'), ['class'=> 'form-control']) !!}
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label">Tên Khách Hàng: </label>
                <div class="col-md-10">
                    {!! Form::text('customer_name', old('customer_name'), ['class'=> 'form-control', 'placeholder' => 'Tên Khách Hàng']) !!}
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-2 control-label">Bài viết:</label>
                <div class="col-md-10">
                    {!! Form::textarea('content',old('content'), ['class'=> 'form-control my-editor', 'placeholder' => 'Bài viết ...']) !!}
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
