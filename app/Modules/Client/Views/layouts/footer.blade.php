<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-sm-4">
                <div class="block-footer">
                    <h3 class="title-footer">About Tigerd</h3>
                    <ul class="list-footer">
                        <li><a href="#">Product Us</a></li>
                        <li><a href="{!! route('client.news') !!}">News</a></li>
                        <li><a href="{!! route('client.contact') !!}">Contact Us</a></li>
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
                    <form action="" method="POST" id="form-subcribe">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <input type="text" name="ema_subcribe" class="form-control">
                                <button type="submit" class="btn btn-subcribe"><i class="fa fa-chevron-right"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</footer>