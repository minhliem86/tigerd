<!--HEADER-->
<header class="sticky-top">
    <div class="container">
        <div class="row">
            <div class="col-md-4 icon-collect">
                <div class="d-flex">
                        <span class="mr-2">
                            <a href="#"><img src="{!! asset('public/assets/client') !!}/images/fb-icon.png" class="img-fluid" title="FaceBook" alt="FaceBook TigerD"></a>
                        </span>
                    <span class="mr-2">
                            <a href="#"><img src="{!! asset('public/assets/client') !!}/images/instagram-icon.png" class="img-fluid" title="Instagram" alt="Instagram TigerD"></a>
                        </span>
                    <span class="mr-2">
                            <a href="#"><img src="{!! asset('public/assets/client') !!}/images/twiter-icon.png" class="img-fluid" title="Twitter" alt="Twitter TigerD"></a>
                        </span>
                    <span>
                            <a href="#"><img src="{!! asset('public/assets/client') !!}/images/youtube-icon.png" class="img-fluid" title="Youtube" alt="Youtube TigerD"></a>
                        </span>
                </div>
            </div>
            <div class="col-md-8 company-info">
                <div class="d-flex justify-content-end">
                    <div class="each-info ">
                        <img src="{!! asset('public/assets/client') !!}/images/email-icon.png" class="img-fluid d-inline" alt="Email">
                        <a href="mailto:meo@tigerd.vn" class="d-inline">meo@tigerd.vn</a>
                    </div>
                    <div class="each-info ">
                        <img src="{!! asset('public/assets/client') !!}/images/phone-icon.png" class="img-fluid d-inline" alt="Phone">
                        <span class="d-inline">
                                        <a href="call:0943722227" class="d-inline">0943 722 227</a> -
                                        <a href="call:01666277772" class="d-inline">01666 277 772</a>
                                    </span>
                    </div>
                    <div class="each-info">
                        <a href="#">
                            <img src="{!! asset('public/assets/client') !!}/images/cart-icon.png" class="img-fluid d-inline mr-2" alt="Cart">
                            <span class="number-item">{!! Cart::getTotalQuantity() !!}</span>
                        </a>
                    </div>
                    <div class="each-info">
                        <a href="#"><i class="fa fa-user"></i> <span class="user-text">Đăng Nhập</span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<!--END HEADER-->