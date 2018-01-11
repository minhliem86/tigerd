<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{!! csrf_token() !!} ">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css"
          integrity="sha384-Zug+QiDoJOrZ5t4lssLdxGhVrurbmBWopoEl+M6BdEfwnCJZtKxi1KgxUyJq13dy" crossorigin="anonymous">
    <link href="https://use.fontawesome.com/releases/v5.0.3/css/all.css" rel="stylesheet">


    <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
            integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
            crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/js/bootstrap.min.js"
            integrity="sha384-a5N7Y/aK3qNeh15eJKGWxsqtnX/wWdSZSKp+81YjTmS15nvnvxKHuzaWwXHDli+4"
            crossorigin="anonymous"></script>
    <title>Document</title>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col">
            <a href="{!! route('client.payment') !!}"><i class="fa fa-shopping-cart"></i> Cart <span class="badge badge-light" id="quantity">{!! Cart::getTotalQuantity() !!}</span></a>
        </div>
    </div>
    <div class="row">
        @if(!$product->isEmpty())
            @foreach($product as $item)
                <div class="col">
                    <figure class="figure">
                        <img src="{!! $item->img_url !!}" class="figure-img img-fluid mx-auto" alt="">
                        <figcaption>
                            <button type="button" class="btn btn-outline-primary"
                                    onclick="addToCart({!! $item->id !!})">Add To Cart
                            </button>
                        </figcaption>
                    </figure>
                </div>
            @endforeach
        @endif
    </div>
</div>
<link rel="stylesheet" href="{!! asset('public/assets/admin/dist/js/plugins/alertify/alertify.css') !!}">
<script src="{!! asset('public/assets/admin/dist/js/plugins/alertify/alertify.js') !!}"></script>
<script>
    function addToCart(idProduct) {
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: "{!! route('client.addToCart') !!}",
            type: 'POST',
            data: {id: idProduct},
            success: function (data) {
                if (!data.error) {
                    alertify.success('Sản Phẩm đã thêm vào giỏ hàng');
                    $('#quantity').html(data.quantity);
                }
            }
        })
    }

    $(document).ready(function () {

    })
</script>
</body>
</html>