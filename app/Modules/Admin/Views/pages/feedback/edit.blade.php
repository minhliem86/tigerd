@extends('Admin::layouts.main-layout')

@section('link')
    {{Html::link(url()->previous(), 'Quay lại', ['class'=>'btn btn-warning'])}}
    <button class="btn btn-danger" onclick="submitForm();">Delete</button>
@stop

@section('title','Ý Kiến Khách Hàng')

@section('content')
    <div class="row">
      <div class="col-sm-12">
        {{Form::model($inst, ['route'=>['admin.feedback.destroy',$inst->id], 'method'=>'DELETE' ])}}
          <div class="form-group">
            <label class="col-md-2 control-label">Tên Khách Hàng:</label>
            <div class="col-md-10">
              {{Form::text('fullname',old('fullname'), ['class'=>'form-control', 'disabled'])}}
            </div>
          </div>
          <div class="form-group">
              <label class="col-md-2 control-label">Số Điện Thoại:</label>
              <div class="col-md-10">
                  {{Form::text('phone',old('phone'), ['class'=>'form-control', 'disabled'])}}
              </div>
          </div>
          <div class="form-group">
              <label class="col-md-2 control-label">Email:</label>
              <div class="col-md-10">
                  {{Form::text('email',old('email'), ['class'=>'form-control', 'disabled'])}}
              </div>
          </div>
          <div class="form-group">
              <label class="col-md-2 control-label">Ý Kiến:</label>
              <div class="col-md-10">
                  {!! Form::textarea('messages',old('messages'), ['class'=> 'form-control', 'disabled']) !!}
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
    // SUBMIT FORM
    function submitForm(){
     $('form').submit();
    }

    </script>
@stop
