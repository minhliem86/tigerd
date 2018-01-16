@extends('Client::layouts.default')

@section('meta')

@stop

@section("content")
    <section class="page-section contact-page">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="map-wrapper">

                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-wrapper">
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