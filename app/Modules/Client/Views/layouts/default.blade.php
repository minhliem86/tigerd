<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <meta name="csrf-token" content="{!! csrf_token() !!} ">

    @hasSection('meta')
        @yield('meta')
        <meta property="og:image:width" content="600">
        <meta property="og:image:height" content="315">
        <meta property="og:url" content="{!! url()->current() !!}">
    @else
        <meta name="keywords" content="">
        <meta name="description" content="" >
        <meta property="og:title" content="Tiger D">
        <meta property="og:description" content="TigerD">
        <meta property="og:image" content="{!! asset('public/assets/client/images/fb-share.png') !!}">
        <meta property="og:image:width" content="600">
        <meta property="og:image:height" content="315">
        <meta property="og:url" content="{!! url()->current() !!}">
    @endif

    <link rel="icon" href="{!! asset('public/favicon.ico') !!}">
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

    <link rel="stylesheet" href="{{asset('/public/assets/admin')}}/dist/js/plugins/alertify/alertify.css">
    <link rel="stylesheet" href="{{asset('/public/assets/admin')}}/dist/js/plugins/alertify/bootstrap.min.css">
    <script type="text/javascript" src="{{asset('/public/assets/admin')}}/dist/js/plugins/alertify/alertify.js"></script>

    <script>
        $(document).ready(function(){
            @if(session('success'))
                alertify.success("{!! session('success') !!}")
            @endif
            @if(session('success_subscribe'))
             alertify.success("{!! session('success_subscribe') !!}")
            @endif
            @if(session('error'))
                alertify.error("{!! session('error') !!}")
            @endif
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            const breakpoint = window.matchMedia('(min-width:560px)');

            let productSwiper;

//            const breakpointChecker = function(){
//                if(breakpoint.matches === true){
//                    return enableSwiper();
//                }else if (breakpoint.matches === false){
//                    if(productSwiper !== undefined) productSwiper.destroy(true, true);
//                    return;
//                }
//            }
//
//            const enableSwiper = function() {
//                productSwiper = new Swiper('#swiper-product', {
//                    'slidesPerView' : 3,
//                    spaceBetween:30,
//                    navigation: {
//                        nextEl: '.swiper-button-next',
//                        prevEl: '.swiper-button-prev',
//                    },
//                    breakpoints:{
//                        767: {
//                            'slidesPerView' : 2,
//                        }
//                    }
//                })
//            };

            // keep an eye on viewport size changes
            breakpoint.addListener(breakpointChecker);

            // kickstart
            breakpointChecker();


            var relateProduct = new Swiper('#hotProductSwiper', {
                'slidesPerView' : 1,
            })

            var newsSwiper = new Swiper('#swiper-news', {
                'slidesPerView' : 1,
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
            })
        })
        function addToCartAjax(url,id){
            $.ajax({
                url: url,
                type: 'POST',
                data: {id: id},
                success: function(data){
                    if(!data.error){
                        $('.number-item').text(data.data);
                        alertify.success('Sản phẩm đã được thêm vào giỏ hàng ')
                    }
                }
            })
        }
    </script>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-113129910-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-113129910-1');
    </script>


    <title>TigerD</title>
</head>
<body>
    <div class="page">
        @include('Client::layouts.header')
        <!--LOGO-->
        <div class="logo-container" >
            <div class="container">
                <div class="row">
                    <a href="{!! route('client.home') !!}" class="logo mx-auto">
                        <img src="{!! asset('public/assets/client') !!}/images/logo.png" class="img-fluid" alt="TigerD">
                    </a>
                </div>
            </div>
        </div>
        <!--END LOGO-->

        @include('Client::layouts.navigation')

        @yield('content')

        @include('Client::layouts.footer')

        @include("Client::layouts.hotline")
    </div>

    <!--AOS -->
    <link rel="stylesheet" href="{!! asset('public/assets/client') !!}/js/plugins/aos/aos.css">
    <script src="{!! asset('public/assets/client') !!}/js/plugins/aos/aos.js"></script>
    <script>
        AOS.init({
            disable: 'mobile',
            once: 'true',
            placement : 'top-center'
        });
        $(document).ready(function(){
            $('.carousel').carousel({
              pause:false
            })
        })
    </script>
    <!-- WhatsHelp.io widget -->
    <script type="text/javascript">
        (function () {
            var options = {
                facebook: "250175375160781", // Facebook page ID
                call_to_action: "Message us", // Call to action
                position: "right", // Position may be 'right' or 'left'
            };
            var proto = document.location.protocol, host = "whatshelp.io", url = proto + "//static." + host;
            var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = url + '/widget-send-button/js/init.js';
            s.onload = function () { WhWidgetSendButton.init(host, proto, options); };
            var x = document.getElementsByTagName('script')[0]; x.parentNode.insertBefore(s, x);
        })();
    </script>
    <!-- /WhatsHelp.io widget -->
@yield('script')
</body>
</html>