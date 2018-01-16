<!--NAVIGATION-->
<div class="navigation-container">
    <div class="container">
        <nav class="navbar navbar-expand-md navbar-light navbar-toggleable-md">
            <a href="#" class="navbar-brand h1">TIGERD</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mainNavbar" aria-controls="mainNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNavbar">
                <ul class="navbar-nav nav-fill w-100 align-items-start" id="navigation-list">
                    <li class="nav-item">
                        <a href="{!! route('client.home') !!}" class="nav-link">Home</a>
                    </li>
                    <li class="nav-item">
                        <a href="{!! count($about) ? $about->slug : '#' !!}" class="nav-link">About Us</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Product
                        </a>
                        @if(!$cate->isEmpty())
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            @foreach($cate as $item_cate)
                            <a class="dropdown-item" href="{!! route('client.category', $item_cate->slug) !!}">{!! $item_cate->name !!}</a>
                            @endforeach
                        </div>
                        @endif
                    </li>
                    <li class="nav-item">
                        <a href="{!! route('client.news') !!}" class="nav-link">News</a>
                    </li>
                    <li class="nav-item">
                        <a href="{!! route('client.contact') !!}" class="nav-link">Contact Us</a>
                    </li>
                </ul>
                <form class="form-inline my-2 my-lg-0 form-search" method="POST">
                    <div class="search-container">
                        <button class="btn btn-search-trigger" type="button" data-toggle="collapse" data-target="#search-wrapper" aria-controls="search-wrapper" aria-expanded="false"><i class="fa fa-search"></i></button>
                        <div id="search-wrapper" class="collapse">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <button type="submit" class="btn btn-search">Tìm Kiếm</button>
                                </div>
                                <input type="text" name="keywords" class="form-control">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </nav>
    </div>
</div>
<!--END NAVIGATION-->