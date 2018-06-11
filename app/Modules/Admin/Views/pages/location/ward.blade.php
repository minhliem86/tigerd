@extends('Admin::layouts.main-layout')

@section('link')
    <button type="button" class="btn btn-warning" id="btn-updateOrder">Update Order</button>
@stop

@section('title','Phường/Xã')

@section('content')
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
        <div class="col-sm-6 col-md-4">
            <div class="wrap-select" style="margin-bottom:10px;">
                <form method="POST" class="form-inline" role="form">
                    <div class="form-group">
                        <div>
                            <label for="city_code" >Chọn Thành Phố</label>
                        </div>
                        {!! Form::select('city_code',[''=> 'Chọn Thành Phố'] + $list_city, '',['class'=>'form-control']) !!}
                    </div>
                </form>
            </div>
        </div>
        <div class="col-sm-6 col-md-4">
            <div class="wrap-select" style="margin-bottom:10px;">
                <form method="POST" class="form-inline" role="form">
                    <div class="form-group">
                        <div>
                            <label for="district_code" >Chọn Quận/Huyện</label>
                        </div>
                        <div id="ward-wrapper">
                            <select name="district_code" class="form-control" disabled="">
                                <option value="">Quận/Huyện</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <table class="table table-hover">
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
                    url:  '{!! route('admin.location.getWard') !!}',
                    data: function(d){
                        d.name = $('input[type="search"]').val();
                        d.district_code = $('select[name=district_code]').val();
                    }
                },
                columns: [
                    {data: 'id', name: 'id', 'orderable': false, 'visible': false},
                    {data: 'name_with_type', name: 'name_with_type', title: 'Quận/Huyện'},
                    {data: 'order', name: 'order', title: 'Sắp Xếp'},
                ],
                initComplete: function(){
                    var table_api = this.api();
                    var data = [];
                    var data_order = {};
                    $('body').on('click', '#btn-updateOrder', function (){
                        var rows_order = table_api.rows().data();
                        var data_order = {};
                        $('input[name="order"]').each(function(index){
                            var id = $(this).data('id');
                            var va = $(this).val();
                            data_order[id] = va;
                        });
                        $.ajax({
                            url: '{{route("admin.localtion.postAjaxUpdateOrder")}}',
                            type:'POST',
                            data: {data: data_order, key: 'ward',  _token:$('meta[name="csrf-token"]').attr('content') },
                            success: function(rs){
                                if(rs.code == 200){
                                    location.reload(true);
                                }
                            }
                        })
                    })
                }
            });
            $('select[name=city_code]').on('change', function(){
                $.ajax({
                    url: '{{route("admin.location.getDistrictAjax")}}',
                    type:'POST',
                    data: {city_code: $(this).val(),  _token:$('meta[name="csrf-token"]').attr('content') },
                    success: function(rs){
                        $('#ward-wrapper').html(rs.data)
                    }
                })
            });
            $('body').on('change',"select[name=district_code]", function(){
                table.draw();
            });
            /*SELECT ROW*/
            $('table tbody').on('click','tr',function(){
                $(this).toggleClass('selected');
            })

        });
        function confirm_remove(a){
            alertify.confirm('You can not undo this action. Are you sure ?', function(e){
                if(e){
                    a.parentElement.submit();
                }
            });
        }

        function hideAlert(a){
            setTimeout(function(){
                $(a).fadeOut();
            },2000)
        }
    </script>
@stop
