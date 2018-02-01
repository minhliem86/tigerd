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
                                Toà Central 2, Vinhomes Central Park, 208 Nguyễn Hữu Cảnh, Phường 22, Bình Thạnh , TP Hồ Chí Minh, Việt Nam
                            </div>
                        </div>
                        <div class="d-flex mb-4">
                            <div class="ic mr-4">
                                <img src="{!! asset('public/assets/client/images/phone-call.svg') !!}" class="img-fluid" alt="Location">
                            </div>
                            <div class=" flex-item">
                                0943.722 227
                            </div>
                        </div>
                        <div class="d-flex mb-4">
                            <div class="ic mr-4">
                                <img src="{!! asset('public/assets/client/images/mail.svg') !!}" class="img-fluid" alt="Location">
                            </div>
                            <div class=" flex-item">
                                tramyletran22@gmail.com
                            </div>
                        </div>
                    </div>

                    <div class="map-wrapper">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m16!1m12!1m3!1d1959.62655103342!2d106.72194435930443!3d10.791916833384317!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!2m1!1zVG_DoCBDZW50cmFsIDIsIFZpbmhvbWVzIENlbnRyYWwgUGFyaywgMjA4IE5ndXnhu4VuIEjhu691IEPhuqNuaCwgUGjGsOG7nW5nIDIyLCBCw6xuaCBUaOG6oW5oICwgVFAgSOG7kyBDaMOtIE1pbmgsIFZp4buHdCBOYW0!5e0!3m2!1svi!2s!4v1517035403764" width="100%" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
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