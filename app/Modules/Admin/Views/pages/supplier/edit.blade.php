@extends('Admin::layouts.main-layout')

@section('link')
    {{Html::link(url()->previous(), 'Cancel', ['class'=>'btn btn-danger'])}}
    <button class="btn btn-primary" onclick="submitForm();">Save Changes</button>
@stop

@section('title','Nhà Cung Cấp Cổng Thanh Toán')

@section('content')
    <div class="row">
      <div class="col-sm-12">
        {{Form::model($inst, ['route'=>['admin.supplier.update',$inst->id], 'method'=>'put', 'class' => 'form-horizontal' ])}}
          <fieldset>
              <div class="form-group">
                  <label class="col-md-2 control-label">Tên Nhà Cung Cấp</label>
                  <div class="col-md-10">
                      {!! Form::text('name',old('name'), ['class' => 'form-control']) !!}
                  </div>
              </div>
              <div class="form-group">
                  <label class="col-md-2 control-label">Nội Dung:</label>
                  <div class="col-md-10">
                      {!! Form::textarea('description',old('description'), ['class'=> 'form-control my-editor', 'placeholder' => 'Nội dung ...']) !!}
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
                          {{Form::hidden('img_url',old('img_url'), ['class'=>'form-control', 'id'=>'thumbnail' ])}}
                      </div>
                      <img id="holder" style="margin-top:15px;max-height:100px;" src="{{asset($inst->img_url)}}">
                  </div>
              </div>
          </fieldset>
        {!! Form::close() !!}
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
