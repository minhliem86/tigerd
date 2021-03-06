<div class="col-xs-6 col-sm-3 sidebar-offcanvas" role="navigation">
  <ul class="list-group panel">
    <li class="list-group-item"><b>SIDE PANEL</b></li>
    <li class="list-group-item {{LP_lib::setActive(2,'dashboard')}}"><a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard"></i>Thống Kê</a></li>
    <li id="list-sanpham">
      <a href="#sanpham"  class="list-group-item " data-toggle="collapse"><b><i class="fa fa-bars"></i>Quản Lý Sản Phẩm</b>  <span class="glyphicon glyphicon-chevron-right"></span></a>
      <div class="collapse" id="sanpham" aria-labelledby="list-sanpham">
        <a class="list-group-item sub-item {{LP_lib::setActive(2,'agency')}}" href="{{route('admin.agency.index')}}"><i class="fa fa-users"></i>Menu Danh Mục</a>
        <a class="list-group-item sub-item {{LP_lib::setActive(2,'category')}}" href="{{route('admin.category.index')}}"><i class="fa fa-server"></i>Danh Mục</a>
        <a class="list-group-item sub-item {{LP_lib::setActive(2,'attribute')}}" href="{{route('admin.attribute.index')}}"><i class="fa fa-check-square-o"></i>Thuộc Tính Sản Phẩm</a>
        <a class="list-group-item sub-item {{LP_lib::setActive(2,'product')}}" href="{{route('admin.product.index')}}"><i class="fa fa-television"></i>Sản Phẩm</a>
        {{--<a class="list-group-item sub-item {{LP_lib::setActive(2,'promotion')}}" href="{{route('admin.promotion.index')}}"><i class="fa fa-gift"></i>Khuyến Mãi</a>--}}
        <a class="list-group-item sub-item {{LP_lib::setActive(2,'don-hang')}}" href="{{route('admin.order.index')}}"><i class="fa fa-gift"></i>Quản lý đơn hàng</a>
        <a class="list-group-item sub-item {{LP_lib::setActive(2,'shippingcost')}}" href="{{route('admin.shippingcost.index')}}"><i class="fa fa-gift"></i>Quản lý Giá Ship</a>
      </div>
    </li>
    <li class="divider"></li>
    <li>
      <a href="#user" class="list-group-item " data-toggle="collapse" ><b><i class="fa fa-comments"></i>Quản Lý User</b>  <span class="glyphicon glyphicon-chevron-right"></span></a>
      <div class="collapse" id="user">
        <a class="list-group-item sub-item {{LP_lib::setActive(2,'customer-idea')}}" href="{{route('admin.customer-idea.index')}}"><i class="fa fa-commenting-o"></i>Ý kiến khách hàng</a>
        <a class="list-group-item sub-item {{LP_lib::setActive(2,'feedback')}}" href="{{route('admin.feedback.index')}}"><i class="fa fa-envelope"></i>Khách Hàng Liên Hệ</a>
        <a class="list-group-item sub-item {{LP_lib::setActive(2,'newsleter')}}" href="{{route('admin.subscribe.index')}}"><i class="fa fa-envelope"></i>Newsletter</a>
        <a class="list-group-item sub-item {{LP_lib::setActive(2,'customer')}}" href="{{route('admin.customer.index')}}"><i class="fa fa-user"></i>Tài Khoản Khách Hàng</a>
      </div>
    </li>
    <li class="divider"></li>
    <li>
      <a href="#location" class="list-group-item " data-toggle="collapse" ><b><i class="fa fa-location-arrow"></i>Quản Lý Dữ Liệu Địa Lý</b>  <span class="glyphicon glyphicon-chevron-right"></span></a>
      <div class="collapse " id="location">
        <a class="list-group-item sub-item {{LP_lib::setActive(2,'city')}}" href="{{route('admin.location.getCity')}}"><i class="fa fa-location-arrow"></i>Tỉnh/ Thành Phố</a>
        <a class="list-group-item sub-item {{LP_lib::setActive(2,'district')}}" href="{{route('admin.location.getDistrict')}}"><i class="fa fa-location-arrow"></i>Quận/ Huyện</a>
        <a class="list-group-item sub-item {{LP_lib::setActive(2,'ward')}}" href="{{route('admin.location.getWard')}}"><i class="fa fa-location-arrow"></i>Phường Xã</a>
      </div>
    </li>
    <li class="divider"></li>
    <li class="list-group-item {{LP_lib::setActive(2,'newstype')}}"><a href="{{route('admin.newstype.index')}}"><i class="fa fa-newspaper-o"></i>Thể Loại Tin Tức</a></li>
    <li class="list-group-item {{LP_lib::setActive(2,'news')}}"><a href="{{route('admin.news.index')}}"><i class="fa fa-newspaper-o"></i>Quản Lý Tin Tức</a></li>
    <li class="list-group-item {{LP_lib::setActive(2,'pages')}}"><a href="{{route('admin.pages.index')}}"><i class="fa fa-braille"></i>Quản Lý Các Trang Đơn</a></li>
    <li class="list-group-item {{LP_lib::setActive(2,'supplier')}}"><a href="{{route('admin.supplier.index')}}"><i class="fa fa-credit-card"></i>Nhà Cung Cấp Cổng Thanh Toán</a></li>
    <li class="list-group-item {{LP_lib::setActive(2,'company')}}"><a href="{{route('admin.company.index')}}"><i class="fa fa-info-circle"></i>Thông tin Cửa Hàng</a></li>
  </ul>
</div>
