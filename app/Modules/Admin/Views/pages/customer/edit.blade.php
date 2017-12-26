@extends('Admin::layouts.main-layout')

@section('link')
    {{Html::link(url()->previous(), 'Quay lại', ['class'=>'btn btn-danger'])}}
    {{--<button class="btn btn-danger" onclick="submitForm();">Delete</button>--}}
@stop

@section('title','Tài Khoản Khách Hàng')

@section('content')
    <div class="row">
        <div class="col-sm-6">
          <div class="panel panel-primary">
              <div class="panel-heading">
                  <h3 class="panel-title">Thông tin khách hàng</h3>
              </div>
              <div class="panel-body">
                  {{Form::model($inst, ['route'=>['admin.customer.destroy',$inst->id], 'method'=>'DELETE', 'class' => 'form-horizontal' ])}}
                  <div class="form-group">
                      <label class="col-md-2 control-label">Danh xưng: </label>
                      <div class="col-md-10">
                          {{Form::text('gender',$inst->gender ? 'Mr.' : 'Ms.', ['class'=>'form-control', 'disabled'])}}
                      </div>
                  </div>
                  <div class="form-group">
                      <label class="col-md-2 control-label">Họ Tên:</label>
                      <div class="col-md-5">
                          {{Form::text('lastname',old('lastname'), ['class'=>'form-control', 'disabled'])}}
                      </div>
                      <div class="col-md-5">
                          {{Form::text('firstname',old('firstname'), ['class'=>'form-control', 'disabled'])}}
                      </div>
                  </div>
                  <div class="form-group">
                      <label class="col-md-2 control-label">Username: </label>
                      <div class="col-md-10">
                          {{Form::text('username',old('username'), ['class'=>'form-control', 'disabled'])}}
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
                      <label class="col-md-2 control-label">Ngày Sinh:</label>
                      <div class="col-md-10">
                          {{Form::text('birthday',\Carbon\Carbon::createFromFormat('Y-m-d',$inst->birthday)->format('d-m-Y'), ['class'=>'form-control', 'disabled'])}}
                      </div>
                  </div>
                  {!! Form::close() !!}
              </div>
          </div>
        </div>
        <div class="col-sm-6">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">Lịch Sử Mua Hàng</h3>
                </div>
                <div class="panel-body">
                    @if($inst->orders()->count())
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Mã Đơn Hàng</th>
                                    <th>Ngày Giao Dịch</th>
                                    <th>Trạng Thái Đơn Hàng</th>
                                    <th>Chi Tiết</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($inst->orders() as $item_order)
                                    <tr>
                                        <td>{!! $item_order->id !!}</td>
                                        <td>{!! $item_order->id !!}</td>
                                        <td>{!! date_create($item_order->created_at)->format('d-m-Y') !!}</td>
                                        <td>Đã Thanh Toán</td>
                                        <td><a href="#" class="btn  btn-xs btn-success">Chi tiết</a></td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    @else
                    <p>Khách Hàng chưa thực hiện giao dịch</p>
                    @endif
                </div>
            </div>
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
