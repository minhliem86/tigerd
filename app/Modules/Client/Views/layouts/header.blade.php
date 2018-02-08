<!--HEADER-->
<header class="sticky-top">
    <div class="container">
        <div class="row">
            <div class="col-md-4 icon-collect">
                <div class="d-flex">
                        <span class="mr-2">
                            <a href="https://www.facebook.com/TigerD.vn/" target="_blank"><img src="{!! asset('public/assets/client') !!}/images/fb-icon.png" class="img-fluid" title="FaceBook" alt="FaceBook"></a>
                        </span>
                    <span class="mr-2">
                            <a href="https://www.instagram.com/tigerd.vn/" target="_blank"><img src="{!! asset('public/assets/client') !!}/images/instagram-icon.png" class="img-fluid" title="Instagram" alt="Instagram"></a>
                        </span>
                    <span class="mr-2">
                            <a href="https://www.youtube.com/channel/UCzzHqhAv0qI1HfYm1IqqMeg" target="_blank"><img src="{!! asset('public/assets/client') !!}/images/youtube-icon.png" class="img-fluid" title="Youtube" alt="Youtube"></a>
                        </span>
                    <span>
                        {!! Form::open(['route'=>'client.subcribe-header.post', 'class' => 'form-subcribe-header']) !!}
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <input type="email" name="email_subcribe_header" class="{!! $errors->error_subcribe_header->any() ? 'invalid-form form-control' : 'form-control' !!}" placeholder="NEWSLETTER SIGN UP">
                                <button type="submit" class="btn btn-subcribe"><i class="fa fa-chevron-right"></i></button>

                            </div>
                        </div>
                        {!! Form::close() !!}
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
                                        <a href="tel:0943722227" class="d-inline">0943 722 227</a>
                                    </span>
                    </div>
                    <div class="each-info">
                        <a href="{!! route('client.cart') !!}">
                            <img src="{!! asset('public/assets/client') !!}/images/cart-icon.png" class="img-fluid d-inline mr-2" alt="Cart">
                            <span class="number-item">{!! Cart::getTotalQuantity() !!}</span>
                        </a>
                    </div>
                    <div class="each-info">
                        @if(!Auth::guard('customer')->check())
                            <a href="{!! route('client.auth.login') !!}"><i class="fa fa-user"></i> <span class="user-text">Đăng Nhập</span></a>
                        @else
                            <a href="#" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user"></i> <span class="user-text">{!! Auth::guard('customer')->user()->firstname !!}</span></a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="{!! route('client.auth.profile') !!}">Thông tin tài khoản</a>
                                <a class="dropdown-item" href="{!! route('client.auth.logout') !!}">Thoát</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<!--END HEADER-->