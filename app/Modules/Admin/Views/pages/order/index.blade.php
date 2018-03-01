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
    {{--@if(Session::has('error'))--}}
        {{--<div class="alert alert-danger alert-dismissable">--}}
            {{--<p>{{Session::get('error')}}</p>--}}
        {{--</div>--}}
    {{--@endif--}}
    {{--@if(Session::has('success'))--}}
        {{--<div class="alert alert-success alert-dismissable">--}}
            {{--<p>{{Session::get('success')}}</p>--}}
        {{--</div>--}}
    {{--@endif--}}
    <div class="row">
        <div class="col-sm-12">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th width="5%">ID</th>
                    <th width="50"><i class="glyphicon glyphicon-search"></i> MÃ ĐƠN</th>
                    <th width="80">NGÀY TẠO</th>
                    <th width="80">GIÁ TRỊ</th>
                    <th width="80">PTTT</th>
                    <th width="80">XỬ LÝ</th>
                    <th width="80">GIAO DỊCH</th>
                    <th width="10%">&nbsp;</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript" src="{{asset('/public/assets/admin')}}/bootflat-admin/js/jquery-1.10.1.min.js"></script>
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
                searching: false,
                ajax:{
                    url:  '{!! route('admin.order.getData') !!}',
                    data: function(d){
                        d.name = $('input[type="search"]').val();
                    }
                },
                columns: [
                    {data: 'id', name: 'id', 'orderable': false,},
                    {data: 'order_name', name: 'order_name','orderable': false,},
                    {data: 'orders.created_at', name: 'orders.created_at', 'orderable': false,},
                    {data: 'orders.total', name: 'orders.total', 'orderable': false,},
                    {data: 'method', name: 'method', 'orderable': false,},
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

                    $('table').on('change','select[name="ship_status"]', function(){
                        const value = $(this).val();
                        const element_id = $(this).data('id')

                        $.ajax({
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            url: "{{route('admin.order.changeShipStatus')}}",
                            type : 'POST',
                            data: {value: value, id: element_id},
                            success: function(data){
                                if(!data.error){
                                    alertify.success('Trạng thái xử lý được cập nhật !');

                                    if(data.data == 3){
                                        $('select[data-id="'+element_id+'"]').val(2);
                                        $.ajax({
                                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                            url: "{{route('admin.order.changePaymentStatus')}}",
                                            type : 'POST',
                                            data: {value: data.data, id: element_id},
                                            success: function(data2){
                                                if(!data2.error){
                                                    alertify.success(' Trạng thái thanh toán được cập nhật !');
                                                }else{
                                                    alertify.error('Fail changed !');
                                                }
                                            }
                                        })
                                    }
                                }else{
                                    alertify.error('Fail changed !');
                                }
                            }
                        })
                    });

                    $('table').on('change','select[name=payment_status]', function(){
                        const value = $(this).val();
                        const ele = $(this).data('id')

                        $.ajax({
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            url: "{{route('admin.order.changePaymentStatus')}}",
                            type : 'POST',
                            data: {value: value, id: ele},
                            success: function(data){
                                if(!data.error){
                                    alertify.success(' Trạng thái thanh toán được cập nhật !');
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
