@extends('Admin::layouts.main-layout')

@section('title','Thống Kê')

@section('content')
    <div class="row">
        <div class="col-lg-3 col-md-4 col-sm-6">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">Nhà Cung Cấp</h3>
                </div>
                <div class="panel-body-dashboard">
                    <a href="{!! route('admin.agency.index') !!}">
                        <div class="wrap-icon text-center">
                            <i class="fa fa-users"></i>
                            <h5><span class="badge badge-info badge-md">{{$number_agency}}</span> Nhà Cung Cấp</h5>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-4 col-sm-6">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">Danh Mục</h3>
                </div>
                <div class="panel-body-dashboard">
                    <a href="{!! route('admin.category.index') !!}">
                        <div class="wrap-icon text-center">
                            <i class="fa fa-server"></i>
                            <h5><span class="badge badge-info badge-md">{{$number_category}}</span> Danh Mục</h5>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-4 col-sm-6">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">Sản Phẩm</h3>
                </div>
                <div class="panel-body-dashboard">
                    <a href="{!! route('admin.product.index') !!}">
                        <div class="wrap-icon text-center">
                            <i class="fa fa-television"></i>
                            <h5><span class="badge badge-info badge-md">{{$number_product}}</span> Sản phẩm</h5>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-4 col-sm-6">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">Tin Tức</h3>
                </div>
                <div class="panel-body-dashboard">
                    <a href="{!! route('admin.news.index') !!}">
                        <div class="wrap-icon text-center">
                            <i class="fa fa-newspaper-o"></i>
                            <h5><span class="badge badge-info badge-md">{{$number_news}}</span> Tin tức</h5>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-4 col-sm-6">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">Khách Hàng Liên Hệ</h3>
                </div>
                <div class="panel-body-dashboard">
                    <a href="{!! route('admin.feedback.index') !!}">
                        <div class="wrap-icon text-center">
                            <i class="fa fa-envelope"></i>
                            <h5><span class="badge badge-info badge-md">{{$number_feedback}}</span> Liên hệ</h5>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-4 col-sm-6">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">Ý Kiến Khách Hàng</h3>
                </div>
                <div class="panel-body-dashboard">
                    <a href="{!! route('admin.customer-idea.index') !!}">
                        <div class="wrap-icon text-center">
                            <i class="fa fa-comment-o"></i>
                            <h5><span class="badge badge-info badge-md">{{$number_customerIdea}}</span> Ý kiến</h5>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-4 col-sm-6">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">Tài Khoản Khách Hàng</h3>
                </div>
                <div class="panel-body-dashboard">
                    <a href="{!! route('admin.customer.index') !!}">
                        <div class="wrap-icon text-center">
                            <i class="fa fa-user"></i>
                            <h5><span class="badge badge-info badge-md">{{$number_customer}}</span> Tài khoản</h5>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Thống kê website</h3>
                </div>
                <div class="panel-body-dashboard">
                    <div class="wrap-selectdate">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-sm-9">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-sm-7">
                                                <div class="input-group input-daterange">
                                                    <input type="text" class="form-control" value="" name="from" required>
                                                    <div class="input-group-addon">to</div>
                                                    <input type="text" class="form-control" value="" name="to" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <button class="btn btn-primary btn-sm" id="btn-date" type="button">Apply</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="text-right">
                                        <button type="button" class="btn btn-primary btn-sm" id="btn-week">Week</button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div> <!-- end wrap select Date -->
                    <div class="wrap-chart">
                        @include('Admin::ajax.ajaxChart')
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h3 class="panel-title">Sản phẩm mới cập nhật</h3>
                </div>
                <div class="panel-body-dashboard">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>SẢN PHẨM</th>
                                <th>HÌNH ẢNH</th>
                                <th>GIÁ</th>
                                <th>NGÀY TẠO</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!$new_sp->isEmpty())
                                @foreach($new_sp as $item_new)
                                <tr>
                                    <td><b>{!! $item_new->name !!}</b></td>
                                    <td><img src="{!! asset($item_new->img_url) !!}" class="img_responsive" style="max-width:50px" alt="{!! $item_new->name !!}"></td>
                                    <td><b>{!! number_format($item_new->price) !!}</b> Vnd</td>
                                    <td>{!! \Carbon\Carbon::parse($item_new->created_at)->format('d-m-Y') !!}</td>
                                </tr>
                                @endforeach
                            @endif
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-danger">
                <div class="panel-heading">
                    <h3 class="panel-title">Sản phẩm được quan tâm nhiều nhất</h3>
                </div>
                <div class="panel-body-dashboard">
                    <div class="wrap-view-product">
                        <canvas id="view-product"></canvas>
                        <script>
                            const ctx_view = document.getElementById('view-product');
                            const myChart_view = new Chart(ctx_view, {
                                type: "doughnut",
                                data: {
                                    labels: [
                                        @foreach($view_sp as $item_view_name)
                                            '{!! $item_view_name->name !!}',
                                        @endforeach
                                    ],
                                    datasets:[
                                        {
                                            label: "Sản Phẩm Yêu Thích",
                                            data:[
                                                @foreach($view_sp as $item_view_count)
                                                {!! $item_view_count->count_number !!},
                                                @endforeach
                                            ],
                                            backgroundColor: [
                                                "rgb(255, 99, 132)",
                                                "rgb(54, 162, 235)",
                                                "rgb(255, 205, 86)"
                                            ],
                                            hoverBackgroundColor: [
                                                "rgb(186,137,183)",
                                                "rgb(82,136,170)",
                                                "rgb(237,237,144)",
                                            ]
                                        }
                                    ],
                                },
                                options: {
                                    responsive: true,

                                }
                            });
                        </script>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-danger">
                <div class="panel-heading">
                    <h3 class="panel-title">Thống Kê Chương Trình Khuyến Mãi</h3>
                </div>
                <div class="panel-body-dashboard">
                    <div class="wrap-view-product">
                        <canvas id="view-promotion"></canvas>
                        <script>
                            const ctx_promotion = document.getElementById('view-promotion');
                            const myChart_promotion = new Chart(ctx_promotion, {
                                type: "pie",
                                data: {
                                    labels: [
                                        'Khuyến mãi đang chạy',
                                        'Khuyến mãi đã ngưng',
                                    ],
                                    datasets:[
                                        {
                                            label: "Các Chương Trình Khuyến Mãi",
                                            data:[
                                                '{!! $promotion_active !!}',
                                                '{!! $promotion_deactive !!}'
                                            ],
                                            backgroundColor: [
                                                "rgb(255, 99, 132)",
                                                "rgb(54, 162, 235)",
                                            ],
                                            hoverBackgroundColor: [
                                                "rgb(186,137,183)",
                                                "rgb(82,136,170)",
                                            ]
                                        }
                                    ],
                                },
                                options: {
                                    responsive: true,

                                }
                            });
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Thống Kê Doanh Số</h3>
                </div>
                <div class="panel-body-dashboard">
                    <div class="wrap-chart-order">
                        <canvas id="chart-order"></canvas>
                        <script>
                            const ctx_order = document.getElementById('chart-order');
                            const data = {
                                labels: [
                                    @foreach($data_bar_chart as $k => $v)
                                        '{!! $k !!}',
                                    @endforeach
                                ],
                                datasets: [
                                    {
                                        label: 'Đơn Hàng',
                                        backgroundColor: "Blue",
                                        hoverBackgroundColor: "Green",
                                        data : [
                                            @foreach($data_bar_chart as  $v)
                                                '{!! $v !!}',
                                            @endforeach
                                        ]
                                    }
                                ]
                            }
                            const myChart_order = new Chart(ctx_order, {
                                type: "bar",
                                data: data,
                                options: {
                                    responsive: true,

                                }
                            });
                        </script>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Thống Kê Doanh Thu</h3>
                </div>
                <div class="panel-body-dashboard">
                    <div class="wrap-chart-order">
                        <canvas id="chart-total"></canvas>
                        <script>
                            const ctx_total = document.getElementById('chart-total');
                            const data2 = {
                                labels: [
                                    @foreach($data_bar_chart as $k => $v)
                                        '{!! $k !!}',
                                    @endforeach
                                ],
                                datasets: [
                                    {
                                        label: 'Doanh Thu',
                                        backgroundColor: "Red",
                                        hoverBackgroundColor: "Yellow",
                                        data : [
                                            @foreach($data_bar_order as  $v)
                                                '{!! $v !!}',
                                            @endforeach
                                        ]
                                    }
                                ]
                            }
                            const myChart_total = new Chart(ctx_total, {
                                type: "bar",
                                data: data2,
                                options: {
                                    tooltips: {
                                        mode: 'label',
                                        label: 'mylabel',
                                        callbacks: {
                                            label: function(tooltipItem, data) {
                                                return tooltipItem.yLabel.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","); }, },
                                    },
                                }
                            });
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <!--  DATE PICKER -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <script>
        $(document).ready(function(){
            // DATETIME
            $('.input-daterange input').each(function() {
                $(this).datepicker({
                    maxDate: '0',
                    dateFormat: 'dd-mm-yy'
                });
            });
            // SET DATE
            $('#btn-date').click(function(){
                var from = $('input[name="from"]').val();
                var to = $('input[name="to"]').val();
                $.ajax({
                    // url: "",
                    data:{from: from, to: to, _token:$('meta[name="csrf-token"]').attr('content') },
                    type: 'GET',
                    beforeSend: function(){
                        $('#btn-date, #btn-week').prop('disabled', true);
                    },
                    success:function(data){
                        $('.wrap-chart').html(data);
                    },
                    complete: function(){
                        $('#btn-date, #btn-week').prop('disabled', false);
                    },
                    error:function(jqXHR, textStatus, errorThrown){
                        if(textStatus){
                            alert('Select date to get Data');
                        }
                    }
                })
            });
            // SET WEEK
            $('#btn-week').click(function(){
                var week = 7;
                $.ajax({
                    data:{week: week, _token:$('meta[name="csrf-token"]').attr('content') },
                    type: 'GET',
                    beforeSend: function(){
                        $('#btn-date, #btn-week').prop('disabled', true);
                    },
                    success:function(data){
                        $('.wrap-chart').html(data);
                    },
                    complete: function(){
                        $('#btn-date, #btn-week').prop('disabled', false);
                        $('.input-daterange input').each(function() {
                            $(this).datepicker("setDate", null);
                        });
                    }
                })
            })

        });
    </script>
@stop
