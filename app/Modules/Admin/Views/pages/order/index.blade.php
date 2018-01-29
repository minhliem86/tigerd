@extends('Admin::layouts.main-layout')

@section('link')
@stop

@section('title','Quản Lý Đơn Hàng')

@section('content')
    <div class="row">
        <div class="col-md-4 col-sm-6">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">Quản Lý Đơn Hàng</h3>
                </div>
                <div class="panel-body-dashboard">
                    <div class="wrap-icon text-center">
                        <i class="fa fa-shopping-cart"></i>
                        <h5><span class="badge badge-info badge-md">{{$order_quantity}}</span></h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if(Session::has('error'))
        <div class="alert alert-danger alert-dismissable">
            <p>{{Session::get('error')}}</p>
        </div>
    @endif
    @if(Session::has('success'))
        <div class="alert alert-success alert-dismissable">
            <p>{{Session::get('success')}}</p>
        </div>
    @endif
    <div class="row">
        <div class="col-sm-12">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th width="5%">ID</th>
                    <th width="50"><i class="glyphicon glyphicon-search"></i> Mã đơn hàng</th>
                    <th width="80">Ngày Tạo</th>
                    <th width="80">Giá trị</th>
                    <th width="80">Thuộc Khách hàng</th>
                    <th width="80">Khuyến Mãi Áp Dụng</th>
                    <th width="50">PTTT</th>
                    <th width="80">Trạng Thái Đơn Hàng</th>
                    <th width="80">Trạng Thái Giao Dịch</th>
                    <th width="10%">&nbsp;</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript" src="{{asset('/public/assets/admin')}}/bootflat-admin/js/jquery-1.10.1.min.js"></script>
    <script type="text/javascript" src="{{asset('/public/assets/admin')}}/dist/js/scroll/jquery.mCustomScrollbar.min.js"></script>
    <!-- DATA TABLE -->
    <link rel="stylesheet" href="{{asset('/public/assets/admin')}}/dist/js/plugins/datatables/jquery.dataTables.min.css">
    <script src="{{asset('/public/assets/admin')}}/dist/js/plugins/datatables/jquery.dataTables.min.js"></script>

    <!-- ALERTIFY -->
    <link rel="stylesheet" href="{{asset('/public/assets/admin')}}/dist/js/plugins/alertify/alertify.css">
    <link rel="stylesheet" href="{{asset('/public/assets/admin')}}/dist/js/plugins/alertify/bootstrap.min.css">
    <script type="text/javascript" src="{{asset('/public/assets/admin')}}/dist/js/plugins/alertify/alertify.js"></script>

    <script>
        $(document).ready(function(){
            hideAlert('.alert');
            // REMOVE ALL
            var table = $('table').DataTable({
                processing: true,
                serverSide: true,
                ajax:{
                    url:  '{!! route('admin.order.getData') !!}',
                    data: function(d){
                        d.name = $('input[type="search"]').val();
                    }
                },
                columns: [
                    {data: 'id', name: 'id', 'orderable': false, 'visible': false},
                    {data: 'order_name', name: 'order_name','orderable': false,},
                    {data: 'orders.order_date', name: 'orders.order_date', 'orderable': false,},
                    {data: 'orders.total', name: 'orders.total', 'orderable': false,},
                    {data: 'customers.name', name: 'customers.name', 'orderable': false,},
                    {data: 'promotion.status', name: 'promotion.status', 'orderable': false,},
                    {data: 'payment.method', name: 'payment.method', 'orderable': false,},
                    {data: 'shipstatus.name', name: 'shipstatus.name', 'orderable': false,},
                    {data: 'paymentstatus.name', name: 'paymentstatus.name', 'orderable': false,},
                    {data: 'action', name: 'action', 'orderable': false,},

                ],
                initComplete: function(){
                    var table_api = this.api();
                    var data = [];
                    var data_order = {};
                    $('#btn-remove-all').click( function () {
                        var rows = table_api.rows('.selected').data();
                        rows.each(function(index, e){
                            data.push(index.id);
                        })
                    })

                    $('table').on('change','input[name=ship_status]', function(){
                        let value = 0;
                        if($(this).is(':checked')){
                            value = 1;
                        }
                        const id_item = $(this).data('id');
                        console.log(id_item);
                        $.ajax({
                            url: "{{route('admin.order.updateStatus')}}",
                            type : 'POST',
                            data: {value: value, id: id_item, _token:$('meta[name="csrf-token"]').attr('content')},
                            success: function(data){
                                if(!data.error){
                                    alertify.success('Status changed !');
                                }else{
                                    alertify.error('Fail changed !');
                                }
                            }
                        })
                    })
                }
            });
            /*SELECT ROW*/
            $('table tbody').on('click','tr',function(){
                $(this).toggleClass('selected');
            })

        });
        function hideAlert(a){
            setTimeout(function(){
                $(a).fadeOut();
            },2000)
        }
    </script>
@stop
