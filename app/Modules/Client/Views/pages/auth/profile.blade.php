@extends("Client::layouts.default")

@section("meta")

@stop

@section("content")
    @include("Client::layouts.banner")
    <section class="page-section profile-page">
        <div class="container">
            <div class="row">
                <div class="col">
                    <h2 class="title-section mx-auto">Thông Tin Khách Hàng</h2>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="profile-wrapper">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="home" aria-selected="true">Thông Tin Khách Hàng</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#changePassword" role="tab" aria-controls="profile" aria-selected="false">Thay Đổi Mật Khẩu</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="contact-tab" data-toggle="tab" href="#cartHistory" role="tab" aria-controls="contact" aria-selected="false">Lịch Sử Mua Hàng</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="home-tab">
                                <div class="profile-info">
                                    <form action="" method="POST" class="form-profile form">
                                        {!! Form::open(['route' => 'client.auth.profile.post', 'class'=>'form-profile form']) !!}
                                        <fieldset>
                                            <legend>Thông tin khách hàng</legend>
                                            <div class="form-group">
                                                <div class="form-row">
                                                    <div class="col">
                                                        <label for="lastname">Họ</label>
                                                        {!! Form::text('lastname', Auth::guard('customer')->user()->lastname, ['class' => 'form-control']) !!}
                                                    </div>
                                                    <div class="col">
                                                        <label for="firstname">Tên</label>
                                                        {!! Form::text('firstname', Auth::guard('customer')->user()->firstname, ['class' => 'form-control']) !!}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="form-row">

                                                    <div class="col-md-4">
                                                        <label for="username">Username</label>
                                                        {!! Form::text('username', Auth::guard('customer')->user()->username, ['class' => 'form-control']) !!}
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="phone">Số điện thoại</label>
                                                        {!! Form::text('phone', Auth::guard('customer')->user()->phone, ['class' => 'form-control']) !!}
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="birthday">Ngày Sinh</label>
                                                        {!! Form::text('birthday', Auth::guard('customer')->user()->birthday ? \Carbon\Carbon::createFromFormat("Y-m-d",Auth::guard('customer')->user()->birthday)->format('d-m-Y') : '', ['class' => 'form-control']) !!}
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>
                                        <fieldset>
                                            <legend>Thông tin giao hàng</legend>
                                            <div class="form-group">
                                                <label for="address">Địa chỉ giao hàng</label>
                                                <input type="text" name="address" class="form-control">
                                                <small id="address" class="form-text text-muted">
                                                    <b>Lưu ý:</b> Thông tin này có thể thay đổi khi thanh toán đơn hàng
                                                </small>
                                            </div>
                                            <div class="form-row">
                                                <div class="col">
                                                    <label for="city">Thành Phố</label>
                                                    <select name="city" class="form-control">
                                                        <option value="">-- Chọn Thành Phố --</option>
                                                    </select>
                                                </div>
                                                <div class="col">
                                                    <label for="district">Quận/huyện</label>
                                                    <select name="district" class="form-control">
                                                        <option value="">-- Chọn Quận/huyện --</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="postcole">Mã Bưu Điện</label>
                                                <input type="text" name="postcode" class="form-control">
                                                <small id="address" class="form-text text-muted">
                                                    <b>Lưu ý:</b> Thông tin này không bắt buộc
                                                </small>
                                            </div>
                                        </fieldset>
                                        <div class="form-group text-center">
                                            <button type="submit" class="btn btn-info btn-profile">Lưu Thông Tin</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="changePassword" role="tabpanel" aria-labelledby="profile-tab">
                                <div class="changePassword-wrapper">
                                    <form action="" method="POST" class="form form-changePassword">
                                        <div class="form-group">
                                            <input type="password" name="oldPassword" class="form-control" placeholder="Mật Khẩu Cũ">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="newPassword" class="form-control" placeholder="Mật Khẩu Mới">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="newPassword_confirmation" class="form-control" placeholder="Xác Nhận Mật Khẩu Mới">
                                        </div>
                                        <div class="form-group">
                                            <input type="submit" class="btn btn-info btn-changePassword" value="Lưu Thay Đổi">
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="cartHistory" role="tabpanel" aria-labelledby="contact-tab">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Mã Đơn Hàng</th>
                                        <th>Ngày Thanh Toán</th>
                                        <th>Hóa Đơn Điện Tử</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(!$orders->isEmpty())
                                        @foreach($orders as $item_order)
                                            <tr>
                                                <td>{!! $item_order->id !!}</td>
                                                <td>{!! $item_order->name !!}</td>
                                                <td>{!! Carbon\Carbon::parse($item_order->created_at)->format('d/m/Y H:i') !!}</td>
                                                <td><a href="#" class="btn btn-outline-secondary btn-order-detail">Chi Tiết</a></td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="4">Hiện chưa cho đơn hàng</td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop

@section("script")

@stop