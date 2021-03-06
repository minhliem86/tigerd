@extends("Client::layouts.default")

@section("content")
    <section class="page-section login-page">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="login-wrapper">
                        <h3 class="title-login-page">Quên Mật Khẩu</h3>
                        {!! Form::open(['route'=> 'client.password.email.post', 'class' => 'login-form']) !!}
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="glyphicon glyphicon-envelope"></i>
                                </div>
                                <input type="email" class="form-control" name="email" id="email" placeholder="Nhập Email để nhận lại mật khẩu" autocomplete="off" />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <input type="submit" class="btn btn-primary" value="Gửi Lại Mật Khẩu">
                            </div>
                            <div class="col text-right">
                                <a href="{!! route('client.auth.login') !!}" class="forget_password">Login page</a>
                            </div>
                        </div>

                        {!! Form::close() !!}
                        @if($errors->error_forget)
                            <ul class="list-errors">
                                @foreach($errors->error_forget->all() as $error )
                                <li>{!! $error !!}</li>
                                @endforeach
                            </ul>
                        @endif
                        @if(session('status'))
                            <ul class="list-success">
                                <li>{!! session('status') !!}</li>
                            </ul>
                        @endif
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="register-wrapper">
                        <h3 class="title-login-page">Đăng Ký</h3>
                        {!! Form::open(['route'=>'client.auth.register.post', 'class' => 'form-register']) !!}
                        <div class="form-group">
                            <label for="lastname">Họ Khách Hàng</label>
                            {!! Form::text('lastname',old('lastname'), ['class'=>$errors->register_error->first("lastname") ? 'is-invalid form-control' : 'form-control'  , 'placeholder' => 'Họ Khách Hàng' ]) !!}
                            @if($errors->register_error->first('lastname'))
                                <div class="invalid-feedback">
                                    {!! $errors->register_error->first('lastname') !!}
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="firstname">Tên Khách Hàng</label>
                            {!! Form::text('firstname',old('firstname'), ['class'=> $errors->register_error->first("firstname") ? 'is-invalid form-control' : 'form-control' , 'placeholder' => 'Tên Khách Hàng' ]) !!}
                            @if($errors->register_error->first('firstname'))
                                <div class="invalid-feedback">
                                    {!! $errors->register_error->first('firstname') !!}
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="phone">Số Điện Thoại Khách Hàng</label>
                            {!! Form::text('phone',old('phone'), ['class'=> $errors->register_error->first("phone") ? 'is-invalid form-control' : 'form-control', 'placeholder' => 'Số Điện Thoại Khách Hàng' ]) !!}
                            @if($errors->register_error->first('phone'))
                                <div class="invalid-feedback">
                                    {!! $errors->register_error->first('phone') !!}
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="email">Email Khách Hàng</label>
                            {!! Form::text('email',old('email'), ['class'=>$errors->register_error->first("email") ? 'is-invalid form-control' : 'form-control', 'placeholder' => 'Email Khách Hàng' ]) !!}
                            @if($errors->register_error->first('email'))
                                <div class="invalid-feedback">
                                    {!! $errors->register_error->first('email') !!}
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="password">Mật khẩu</label>
                            {!! Form::password('password', ['class'=>$errors->register_error->first("password") ? 'is-invalid form-control' : 'form-control', 'placeholder' => 'Mật khẩu' ]) !!}
                            @if($errors->register_error->first('password'))
                                <div class="invalid-feedback">
                                    {!! $errors->register_error->first('password') !!}
                                </div>
                            @endif
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