@extends('Client::layouts.default')

@section('content')
    @include("Client::layouts.banner")

    @if(!$news->isEmpty())
        <!--NEWS-->
        <section class="news-container page-section news-page">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="each-type-news">
                            <a href="#"><img src="" class="img-fluid" alt=""></a>
                            <h3 class="news-name"><a href="#">Tin Sức Khỏe</a></h3>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--END NEWS-->
    @endif

    @include("Client::layouts.fanpage")
@stop

@section("script")

@stop