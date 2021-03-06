@extends('Admin::layouts.main-layout')

@section('link')
    {{Html::link(url()->previous(), 'Cancel', ['class'=>'btn btn-danger'])}}
    <button class="btn btn-primary" onclick="submitForm();">Save Changes</button>
@stop

@section('title','Khuyến Mãi')

@section('content')
    <div class="row">
      <div class="col-sm-12">
          @include('Admin::errors.error_layout')
        {{Form::model($inst, ['route'=>['admin.promotion.update',$inst->id], 'method'=>'put', 'class' => 'form-horizontal' ])}}
          <fieldset>
              <div class="form-group">
                  <label class="col-md-2 control-label">Tên Chương Trình Khuyến Mãi:</label>
                  <div class="col-md-10">
                      {!! Form::text('name',old('name'), ['class'=>'form-control', 'placeholder' => 'Chương Trình Khuyến Mãi']) !!}
                  </div>
              </div>
              <div class="form-group">
                  <label class="col-md-2 control-label">Mã Khuyến Mãi:
                      <p><small>(Các chữ cái viết hoa. EX: VALENTINE, MOMDAY ...)</small></p>
                  </label>
                  <div class="col-md-10">
                      {!! Form::text('sku_promotion',old('sku_promotion'), ['class'=>'form-control', 'placeholder' => 'Mã Khuyến Mãi']) !!}
                  </div>
              </div>
              <div class="form-group">
                  <label class="col-md-2 control-label">Mô tả:</label>
                  <div class="col-md-10">
                      {!! Form::textarea('description',old('description'), ['class'=> 'form-control', 'placeholder' => 'Mô tả ...']) !!}
                  </div>
              </div>
              <div class="form-group">
                  <label class="col-md-2 control-label">Áp Dụng:</label>
                  <div class="col-md-10">
                      {!! Form::select('target', ['subtotal' => 'Giá trị đơn hàng'], old('target') ,['class'=>'form-control']) !!}
                  </div>
              </div>
              <div class="form-group">
                  <label class="col-md-2 control-label">Giá Trị Khuyến Mãi:
                  </label>
                  <div class="col-md-10">
                      <div class="row">
                          <div class="col-md-6">
                              <label class="control-label">Giá trị <small>(VND: -50000 giảm 50.000 VND)</small> <small>(%: -10 giảm 10%)</small></label>
                              <div class="input-group input-group-editor">
                                  {!! Form::number('value', old('value'), ['class' => 'form-control',]) !!}
                                  <div class="input-group-btn">
                                      {!! Form::select('value_type',['vnd' => 'VND', '%' => '%'], old('value_type') ,['class' => 'form-control']) !!}
                                  </div>
                              </div>
                          </div>
                          <div class="col-md-6">
                              <label class="control-label">Số lượng</label>
                              {!! Form::number('quantity', old('quantity'), ['class'=>'form-control', 'placeholder' => 'Số Lượng']) !!}
                          </div>
                      </div>
                  </div>
              </div>
              <div class="form-group">
                  <label class="col-md-2 control-label">Thời Gian Chạy Khuyến Mãi:</label>
                  <div class="col-md-10">
                      <div class="container-fluid">
                          <div class="row">
                              <div class="col-md-6">
                                  <label class="control-label">Bắt đầu</label>
                                  {!! Form::text('from_time', \Carbon\Carbon::createFromFormat('Y-m-d', $inst->from_time)->format('d-m-Y'), ['class' => 'form-control datePicker']) !!}
                              </div>
                              <div class="col-md-6">
                                  <label class="control-label">Kết thúc</label>
                                  {!! Form::text('to_time', \Carbon\Carbon::createFromFormat('Y-m-d', $inst->to_time)->format('d-m-Y'), ['class' => 'form-control datePicker2']) !!}
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
              <div class="form-group">
                  <label class="col-md-2 control-label" for="description">Trạng thái</label>
                  <div class="col-md-10">
                      <label class="toggle">
                          <input type="checkbox" name="status" value="1" {{$inst->status == 1 ? 'checked' : '' }}  >
                          <span class="handle"></span>
                      </label>
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

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>
    <script>
    const url = "{{url('/')}}"
    init_tinymce(url);
    // BUTTON ALONE
    init_btnImage(url,'#lfm');
    // SUBMIT FORM
    function submitForm(){
     $('form').submit();
    }

    $(document).ready(function(){
        $('.datePicker2').datepicker({
            format: 'dd-mm-yyyy',
        });
        $('.datePicker').datepicker({
            endDate: '0d',
            format: 'dd-mm-yyyy',
        }).on('changeDate', function(e){
            $('.datePicker2').datepicker({
                format: 'dd-mm-yyyy',
                startDate: e.date
            })
        });
    })
    </script>
@stop
