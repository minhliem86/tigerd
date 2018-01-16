@extends('Client::layouts.default')

@section('meta')

@stop

@section('content')
    @include("Client::layouts.banner")
    <section class="page-section single-page">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="single-page-inner">
                        <h2 class="title-single-page">{!! $page->name !!}</h2>
                        <div class="content-single-page">
                            {!! $page->description !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include("Client::layouts.fanpage")
@stop

@section("script")

@stop