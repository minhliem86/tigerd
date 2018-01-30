@extends("Client::layouts.default")

@section("content")
    @include("Client::layouts.banner")
    <section class="page-section profile-page">
        <div class="container">
            <div class="row">
                <div class="col">
                    <h2 class="title-section mx-auto">Thông Tin Khách Hàng</h2>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="profile-wrapper">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="home" aria-selected="true">Thông Tin Khách Hàng</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#changePassword" role="tab" aria-controls="profile" aria-selected="false">Thay Đổi Mật Khẩu</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="contact-tab" data-toggle="tab" href="#cartHistory" role="tab" aria-controls="contact" aria-selected="false">Lịch Sử Mua Hàng</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="home-tab">
                                <div class="profile-info">

                                        {!! Form::open(['route' => 'client.auth.profile.post', 'class'=>'form-profile form']) !!}
                                        <fieldset>
                                            <legend>Thông tin khách hàng</legend>
                                            <div class="form-group">
                                                <div class="form-row">
                                                    <div class="col">
                                                        <label for="lastname">Họ</label>
                                                        {!! Form::text('lastname', Auth::guard('customer')->user()->lastname, ['class' => $errors->error_profile->has('lastname') ? 'is-invalid  form-control' : 'form-control']) !!}
                                                        @if($errors->error_profile->has('lastname'))
                                                        <div class="invalid-feedback">
                                                            {!! $errors->error_profile->first('lastname') !!}
                                                        </div>
                                                        @endif
                                                    </div>
                                                    <div class="col">
                                                        <label for="firstname">Tên</label>
                                                        {!! Form::text('firstname', Auth::guard('customer')->user()->firstname, ['class' => $errors->error_profile->has('firstname') ? 'is-invalid  form-control' : 'form-control']) !!}
                                                        @if($errors->error_profile->has('firstname'))
                                                            <div class="invalid-feedback">
                                                                {!! $errors->error_profile->first('firstname') !!}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="form-row">
                                                    <div class="col-md-4">
                                                        <label for="address">Giới tính</label>
                                                        {!! Form::select('gender', [0 => 'Mrs.', 1=>'Mr.'],Auth::guard('customer')->user()->gender ,['class'=> 'form-control']) !!}
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="phone">Số điện thoại</label>
                                                        {!! Form::text('phone', Auth::guard('customer')->user()->phone, ['class' => $errors->error_profile->has('phone') ? 'is-invalid  form-control' : 'form-control']) !!}
                                                        @if($errors->error_profile->has('phone'))
                                                            <div class="invalid-feedback">
                                                                {!! $errors->error_profile->first('phone') !!}
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="birthday">Ngày Sinh</label>
                                                        {!! Form::text('birthday', Auth::guard('customer')->user()->birthday, ['class' => 'form-control']) !!}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="form-row">
                                                    <div class="col">
                                                        <label for="address">Địa chỉ (dùng để giao hàng )</label>
                                                        {!! Form::text('address', Auth::guard('customer')->user()->address, ['class'=>'form-control']) !!}
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>
                                        <div class="form-group text-center">
                                            <button type="submit" class="btn btn-info btn-profile">Lưu Thông Tin</button>
                                        </div>
                                    {!! Form::close() !!}
                                </div>
                            </div>
                            <div class="tab-pane fade" id="changePassword" role="tabpanel" aria-labelledby="profile-tab">
                                <div class="changePassword-wrapper">
                                    <form action="" method="POST" class="form form-changePassword">
                                        <div class="form-group">
                                            <input type="password" name="oldPassword" class="form-control" placeholder="Mật Khẩu Cũ">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="newPassword" class="form-control" placeholder="Mật Khẩu Mới">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="newPassword_confirmation" class="form-control" placeholder="Xác Nhận Mật Khẩu Mới">
                                        </div>
                                        <div class="form-group">
                                            <input type="submit" class="btn btn-info btn-changePassword" value="Lưu Thay Đổi">
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="cartHistory" role="tabpanel" aria-labelledby="contact-tab">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Mã Đơn Hàng</th>
                                        <th>Ngày Thanh Toán</th>
                                        <th>Hóa Đơn Điện Tử</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(!$order->isEmpty())
                                        @foreach($order as $item_order)
                                            <tr>
                                                <td>{!! $item_order->id !!}</td>
                                                <td>{!! $item_order->order_name !!}</td>
                                                <td>{!! Carbon\Carbon::parse($item_order->created_at)->format('d/m/Y H:i') !!}</td>
                                                <td><a href="{!! route('client.order_detail', $item_order->id) !!}" class="btn btn-outline-secondary btn-order-detail">Chi Tiết</a></td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="4">Hiện chưa cho đơn hàng</td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop

@section("script")
    <!--  DATE PICKER -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        $(document).ready(function(){
            $('input[name=birthday]').datepicker({
                dateFormat:'dd/mm/yy',
                changeMonth: true,
                changeYear: true,
                yearRange: '1950:2018',
            })
        })
    </script>
@stop