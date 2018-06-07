@extends('Client::layouts.default')

@section("content")
    <section class="page-section contact-page">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="wrap-info" data-aos="flip-right">
                        <div class="d-flex mb-4">
                            <div class="ic mr-4">
                                <img src="{!! asset('public/assets/client/images/location.svg') !!}" class="img-fluid" alt="Location">
                            </div>
                            <div class=" flex-item">
                                {!! $info->address !!}
                            </div>
                        </div>
                        <div class="d-flex mb-4">
                            <div class="ic mr-4">
                                <img src="{!! asset('public/assets/client/images/phone-call.svg') !!}" class="img-fluid" alt="Location">
                            </div>
                            <div class=" flex-item">
                                {!! $info->phone !!}
                            </div>
                        </div>
                        <div class="d-flex mb-4">
                            <div class="ic mr-4">
                                <img src="{!! asset('public/assets/client/images/mail.svg') !!}" class="img-fluid" alt="Location">
                            </div>
                            <div class=" flex-item">
                                {!! $info->email !!}
                            </div>
                        </div>
                    </div>

                    <div class="map-wrapper">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d566.0105761410928!2d106.70046404604987!3d10.794244151969043!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x317528b5fadc567d%3A0x3a7a8eb48420cd0a!2zNDMsIDUgxJBp4buHbiBCacOqbiBQaOG7pywgUGjGsOG7nW5nIDE1LCBCw6xuaCBUaOG6oW5oLCBI4buTIENow60gTWluaCwgVmnhu4d0IE5hbQ!5e0!3m2!1svi!2s!4v1528120468568" width="100%" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-wrapper" data-aos="flip-left">
                        @if($errors->any())
                        <ul class="list-errors">
                            @foreach($errors->all() as $error)
                            <li>{!! $error !!}</li>
                            @endforeach
                        </ul>
                        @endif
                        {!! Form::open(['route'=>'client.contact'], ['class'=>'form-contact']) !!}
                            <div class="form-group">
                                <label for="fullname">Họ Tên Khách Hàng (*)</label>
                                {!! Form::text('fullname',old('fullname'), ['class'=>"form-control"]) !!}
                            </div>
                            <div class="form-group">
                                <label for="phone">Điện Thoại Khách Hàng (*)</label>
                                {!! Form::text('phone',old('phone'), ['class'=>'form-control']) !!}
                            </div>
                            <div class="form-group">
                                <label for="email">Email Khách Hàng (*)</label>
                                {!! Form::text('email',old('email'), ['class'=>'form-control']) !!}
                            </div>
                            <div class="form-group">
                                <label for="message">Nội dung</label>
                                {!! Form::textarea('message', old('message'), ['class'=> 'form-control', 'rows'=>10]) !!}
                            </div>
                            <div class="form-group">
                                <input type="submit" value="Gửi" class="btn btn-outline-primary">
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop

@section("script")

@stop