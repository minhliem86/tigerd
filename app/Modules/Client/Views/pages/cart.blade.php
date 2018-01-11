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
        <div class="col">
            <table class="table table-bordered">
                <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    <th>Sản Phẩm</th>
                    <th>Số lượng</th>
                    <th>Đơn giá</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                    @foreach($cart as $item_cart)
                        <tr>
                            <td>{!! $item_cart->id !!}</td>
                            <td>{!! $item_cart->name !!}</td>
                            <td>{!! $item_cart->quantity !!}</td>
                            <td>{!! $item_cart->price !!}</td>
                            <td><a href="{!! route('client.cart.remove', $item_cart->id) !!}" class="btn btn-xs btn-danger"><i class="fa fa-trash fa-1x"></i></a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="row">
                <div class="col">
                    <a href="{!! route('client.payment') !!}" class="btn btn-xs btn-primary">Thanh Toán</a>
                    <a href="{!! route('client.product') !!}" class="btn btn-xs btn-info">Tiếp tục mua hàng</a>
                    <a href="{!! route('client.cart.removeAll') !!}" class="btn btn-xs btn-danger"><i class="fa fa-trash fa-1x"></i> Xóa Giỏ hàng</a>
                </div>
                <div class="col">
                    <p class="text-right"><b>Tổng tiền: </b> {!! number_format(Cart::getSubtotal()) !!} VND</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>