<div class="col-xs-6 col-sm-3 sidebar-offcanvas" role="navigation">
  <ul class="list-group panel">
    <li class="list-group-item"><b>SIDE PANEL</b></li>
    <li class="list-group-item {{LP_lib::setActive(2,'dashboard')}}"><a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard"></i>Thống Kê</a></li>
    <li class="list-group-item {{LP_lib::setActive(2,'agency')}}"><a href="{{route('admin.agency.index')}}"><i class="fa fa-user-secret"></i>Nhà Cung Cấp</a></li>
    <li class="list-group-item {{LP_lib::setActive(2,'category')}}"><a href="{{route('admin.category.index')}}"><i class="fa fa-user-secret"></i>Danh Mục Sản Phẩm</a></li>
  </ul>
</div>
