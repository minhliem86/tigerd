@extends('Client::layouts.default')

@if(count($meta))
@section('meta')
    <meta name="keywords" content="{!! $meta->meta_keywords !!}">
    <meta name="description" content="{!! $meta->meta_description !!}" >
    <meta property="og:image" content="{!! asset($meta->meta_img) !!}">
@stop
@endif

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