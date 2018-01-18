@extends("Client::layouts.default")

@section("meta")

@stop

@section("content")
    <section class="page-section login-page">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="login-wrapper">
                        <h3 class="title-login-page">Đăng Nhập</h3>
                        {!! Form::open(['route'=> 'client.auth.login.post', 'class' => 'login-form']) !!}
                            <div class="form-group">
                                {!! Form::text('usernameOrEmail',old('usernameOrEmail'), ['class'=>'form-control', 'placeholder' => 'Email Or Username' ]) !!}
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" name="password" placeholder="Mật khẩu">
                            </div>
                            <div class="form-row">
                                <div class="col">
                                    <input type="submit" class="btn btn-primary" value="Đăng Nhập">
                                </div>
                                <div class="col text-right">
                                    <a href="#" class="forget_password">Bạn không nhớ mật khẩu ?</a>
                                </div>
                            </div>
                        {!! Form::close() !!}
                        @if($errors->any())
                            <ul class="list-errors">
                                <li>{!! $errors->first('error_login') !!}</li>
                            </ul>
                        @endif
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="register-wrapper">
                        <h3 class="title-login-page">Đăng Ký</h3>
                        {!! Form::open(['route'=>'client.auth.register.post', 'class' => 'form-register']) !!}
                            <div class="form-group">
                                <label for="firstname">Họ Tên Khách Hàng</label>
                                {!! Form::text('firstname',old('firstname'), ['class'=>'form-control', 'placeholder' => 'Họ Tên Khách Hàng' ]) !!}
                            </div>
                            <div class="form-group">
                                <label for="phone">Số Điện Thoại Khách Hàng</label>
                                {!! Form::text('phone',old('phone'), ['class'=>'form-control', 'placeholder' => 'Số Điện Thoại Khách Hàng' ]) !!}
                            </div>
                            <div class="form-group">
                                <label for="email">Email Khách Hàng</label>
                                {!! Form::text('email',old('email'), ['class'=>'form-control', 'placeholder' => 'Email Khách Hàng' ]) !!}
                            </div>
                            <div class="form-group">
                                <label for="password">Mật khẩu</label>
                                <input type="password" name="password" class="form-control" placeholder="Password">
                            </div>
                            <div class="form-group">
                                <label for="password_confirmation">Xác Nhận Mật khẩu</label>
                                <input type="password" name="password_confirmation" class="form-control" placeholder="Xác NhậnPassword">
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-info" value="Đăng Ký">
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include("Client::layouts.fanpage")
@stop

@section("script")

@stop