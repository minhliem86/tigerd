@extends('Admin::layouts.main-layout')

@section('link')
    <button class="btn btn-primary" onclick="submitForm();">Save</button>
@stop

@section('title','Thanh Điều Hướng')

@section('content')
    <div class="row">
      <div class="col-sm-12">
        <form method="POST" action="{{route('admin.agency.store')}}" id="form" role="form" class="form-horizontal">
          {{Form::token()}}
          <div class="form-group">
            <label class="col-md-2 control-label">Tên:</label>
            <div class="col-md-10">
              <input type="text" required="" placeholder="Tên Danh Mục Trên Thanh Điều Hướng" id="name" class="form-control" name="name">
            </div>
          </div>
            {{--<div class="form-group">--}}
                {{--<label class="col-md-2 control-label">Mô tả ngắn:</label>--}}
                {{--<div class="col-md-10">--}}
                    {{--{!! Form::textarea('description',old('description'), ['class'=> 'form-control', 'placeholder' => 'Mô tả ...']) !!}--}}
                {{--</div>--}}
            {{--</div>--}}
          {{--<div class="form-group">--}}
            {{--<label class="col-md-2 control-label">Hình ảnh:</label>--}}
            {{--<div class="col-md-10">--}}
                {{--<div class="input-group">--}}
                 {{--<span class="input-group-btn">--}}
                   {{--<a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">--}}
                     {{--<i class="fa fa-picture-o"></i> Chọn--}}
                   {{--</a>--}}
                 {{--</span>--}}
                 {{--<input id="thumbnail" class="form-control" type="hidden" name="img_url">--}}
                {{--</div>--}}
                {{--<img id="holder" style="margin-top:15px;max-height:100px;">--}}
            {{--</div>--}}
          {{--</div>--}}
        </form>
      </div>
    </div>
@endsection

@section('script')
    <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
    <script src="{!! asset('public') !!}/vendor/laravel-filemanager/js/lfm.js"></script>
    <script src="{!! asset('public/assets/admin/js/script.js') !!}"></script>
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
