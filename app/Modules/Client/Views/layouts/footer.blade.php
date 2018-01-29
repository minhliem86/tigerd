<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-sm-4">
                <div class="block-footer">
                    <h3 class="title-footer">About Tigerd</h3>
                    <ul class="list-footer">
                        <li><a href="{!! route('client.product.showAll') !!}">Sản Phẩm</a></li>
                        <li><a href="{!! route('client.news') !!}">Tin Tức</a></li>
                        <li><a href="{!! route('client.contact') !!}">Liên Hệ</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-3 col-sm-4">
                <div class="block-footer">
                    <h3 class="title-footer">Guide</h3>
                    @if(!$page->isEmpty())

                    <ul class="list-footer">
                        @foreach($page as $item_page)
                        <li><a href="{!! route('client.single_page', $item_page->slug) !!}">{!! $item_page->name !!}</a></li>
                        @endforeach
                    </ul>
                    @endif
                </div>
            </div>
            <div class="col-md-6 col-sm-4">
                <div class="block-subcribe">
                    <h3 class="title-subcribe">NEWSLETTER SIGN UP</h3>
                    <p class="sub-title">Sign up to get information and more...</p>
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