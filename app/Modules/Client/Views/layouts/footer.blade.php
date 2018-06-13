<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-sm-4">
                <div class="block-footer">
                    <div id="wrap-chinhsach">
                        <p>HKD Tiger D - MST 0305625567 do UBND quận Bình Thạnh cấp ngày 16/04/2018  – HKD/Sở hữu website Lê Trần Trà My </p>
                        <p>Địa Chỉ:  43/5B Điện Biên Phủ, P. 15, Q, Bình Thạnh, Tp. HCM</p>
                        <a href="http://online.gov.vn/HomePage/CustomWebsiteDisplay.aspx?DocId=44724 " target="_blank"><img src="{!! asset('public/assets/client') !!}/images/logo-bct.png" class="img-fluid mt-4" alt="Bộ Công Thương"></a>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-4">
                <div class="block-footer">
                    <h3 class="title-footer">TigerD.vn</h3>
                    <ul class="list-footer">
                        <li><a href="{!! route('client.product.showAll') !!}">Sản Phẩm</a></li>
                        <li><a href="{!! route('client.contact') !!}">Liên Hệ</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-3 col-sm-4">
                <div class="block-footer">
                    <h3 class="title-footer">Chính sách</h3>
                    @if(!$page->isEmpty())

                    <ul class="list-footer">
                        @foreach($page as $item_page)
                        <li><a href="{!! route('client.single_page', $item_page->slug) !!}">{!! $item_page->name !!}</a></li>
                        @endforeach
                    </ul>
                    @endif
                </div>
            </div>
            <div class="col-md-3 col-sm-4">
                <div class="block-footer mb-2">
                    <h3 class="title-footer">Lượt Xem: {!! $total_pageview !!}</h3>
                </div>
                <div class="block-subcribe">
                    <h3 class="title-subcribe">ĐĂNG KÝ  NHẬN THÔNG TIN</h3>
                    <p class="sub-title">Đăng ký để nhận thêm thông tin từ Tigerd</p>
                    {!! Form::open(['route'=>'client.subcribe.post', 'class' => 'form-subcribe']) !!}
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <input type="email" name="email_subcribe" class="form-control">
                                <button type="submit" class="btn btn-subcribe"><i class="fa fa-chevron-right"></i></button>
                                @if($errors->error_subcribe->any())
                                    <div class="invalid-feedback">
                                        @foreach($error->error_subcribe->all() as $item_subcribe)
                                        <p>{!! $item_subcribe !!}</p>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</footer>