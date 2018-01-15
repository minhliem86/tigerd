<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    @yield('meta')

    <link rel="stylesheet" href="{!! asset('public/assets/client') !!}/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700&amp;subset=vietnamese" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:400,700&amp;subset=vietnamese" rel="stylesheet">
    <link rel="stylesheet" href="{!! asset('public/assets/client') !!}/js/plugins/swiper/css/swiper.min.css">
    <link rel="stylesheet" href="{!! asset('public/assets/client') !!}/css/style.min.css">

    <script src="{!! asset('public/assets/client') !!}/js/jquery-1.11.2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="{!! asset('public/assets/client') !!}/js/bootstrap.min.js"></script>
    <script src="{!! asset('public/assets/client') !!}/js/plugins/swiper/js/swiper.min.js"></script>
    <script src="{!! asset('public/assets/client') !!}/js/plugins/swiper/js/swiper.esm.js"></script>

    <script>
        $(document).ready(function(){
            var productSwiper = new Swiper('#swiper-product', {
                'slidesPerView' : 3,
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                breakpoints:{
                    575: {
                        'slidesPerView' : 1,
                    },
                    767: {
                        'slidesPerView' : 2,
                    }
                }
            })

            var newsSwiper = new Swiper('#swiper-news', {
                'slidesPerView' : 1,
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
            })
        })
    </script>

    <title>TigerD</title>
</head>
<body>
    <div class="page">
    @include('Client::layouts.header')
        <!--LOGO-->
        <div class="logo-container">
            <div class="container">
                <div class="row">
                    <a href="#" class="logo mx-auto">
                        <img src="{!! asset('public/assets/client') !!}/images/logo.png" class="img-fluid" alt="TigerD">
                    </a>
                </div>
            </div>
        </div>
        <!--END LOGO-->

        @include('Client::layouts.navigation')

        @yield('content')

        @include('Client::layouts.testimonial')

        @include('Client::layouts.footer')
    </div>

@yield('script')
</body>
</html>