@extends("Client::layouts.default")

@section("content")
    <section class="page-section login-page">
        <div class="container">
            <div class="row">
                <div class="col">
                    <h2 class="title-section mx-auto">Cấp Lại Mật Khẩu</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-6 offset-3">
                    <div class="reset-wrapper">
                        <form class="form-horizontal" role="form" method="POST" action="{!! url('/password/reset') !!}">
                            {!! csrf_field() !!}

                            <input type="hidden" name="token" value="{!! $token !!}">

                            <div class="form-group">
                                <label for="email" class="col-md-12 control-label">E-Mail Address</label>

                                <div class="col-md-12">
                                    <input id="email" type="email" class="form-control {!! $errors->has('email') ? 'is-invalid' : null !!}" name="email" value="{!! $email or old('email') !!}">

                                    @if ($errors->has('email'))
                                        <div class="invalid-feedback">
                                            <strong>{!! $errors->first('email') !!}</strong>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="password" class="col-md-4 control-label">Password</label>

                                <div class="col-md-12">
                                    <input id="password" type="password" class="form-control {!! $errors->has('password') ? 'is-invalid' : null !!}" name="password">

                                    @if ($errors->has('password'))
                                        <div class="invalid-feedback">
                                            <strong>{!! $errors->first('password') !!}</strong>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>
                                <div class="col-md-12">
                                    <input id="password-confirm" type="password" class="form-control {!! $errors->has('password_confirmation') ? 'is-invalid' : null !!}" name="password_confirmation">

                                    @if ($errors->has('password_confirmation'))
                                        <div class="invalid-feedback">
                                            <strong>{!! $errors->first('password_confirmation') !!}</strong>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-12 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-btn fa-refresh"></i> Reset Password
                                    </button>
                                </div>
                            </div>
                        </form>
                        
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include("Client::layouts.fanpage")
@stop

@section("script")
@stop