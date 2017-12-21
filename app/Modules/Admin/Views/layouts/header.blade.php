<!--nav-->
<nav role="navigation" class="navbar navbar-custom">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button data-target="#bs-content-row-navbar-collapse-5" data-toggle="collapse" class="navbar-toggle" type="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a href="#" class="navbar-brand">DASHBOARD</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div id="bs-content-row-navbar-collapse-5" class="collapse navbar-collapse">
      <ul class="nav navbar-nav navbar-right">
        <!-- <li class="disabled"><a href="#">Link</a></li> -->
        <li class="dropdown">
          <a data-toggle="dropdown" class="dropdown-toggle" href="#"><i class="glyphicon glyphicon-user"></i> {{Auth::user()->name}} <b class="caret"></b></a>
          <ul role="menu" class="dropdown-menu">
            <li class="dropdown-header">Tùy Chỉnh</li>
            @role('admin')
            <li><a href="{{route('admin.user.index')}}">Quản lý Quản Trị Viên</a></li>
            @endrole
            <li><a href="{{route('admin.profile.index')}}">Thông tin tài khoản</a></li>
            <li class="divider"></li>
            <li ><a href="{{url('admin/logout')}}">Thoát</a></li>
          </ul>
        </li>
      </ul>

    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
