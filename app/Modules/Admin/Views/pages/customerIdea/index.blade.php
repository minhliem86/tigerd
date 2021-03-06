@extends('Admin::layouts.main-layout')

@section('link')
    {{Html::link(route('admin.customer-idea.create'),'Add New',['class'=>'btn btn-primary'])}}
    <button type="button" class="btn btn-danger" id="btn-remove-all">Remove All Selected</button>
    <button type="button" class="btn btn-warning" id="btn-updateOrder">Update Order</button>
@stop

@section('title','Ý kiến khách hàng')

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
      <div class="col-sm-12">
        <table class="table table-hover">
          <thead>
            <tr>
                <th width="5%">ID</th>
                <th width="120px"><i class="glyphicon glyphicon-search"></i> Tên Khách Hàng</th>
                <th width="120">Hình ảnh</th>
                <th width="">Thuộc Sản Phẩm</th>
                <th width="80">Sắp xếp</th>
                <th >Trạng thái</th>
                <th width="120px">&nbsp;</th>
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
                url:  '{!! route('admin.customer-idea.getData') !!}',
                data: function(d){
                    d.name = $('input[type="search"]').val();
                }
            },
            columns: [
               {data: 'id', name: 'id', 'orderable': false},
               {data: 'customer_name', name: 'customer_name'},
               {data: 'img_url', name: 'img_url', 'orderable': false},
               {data: 'product_name', name: 'product_name'},
               {data: 'order', name: 'order'},
               {data: 'status', name: 'status'},
               {data: 'action', name: 'action', 'orderable': false}
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
                    alertify.confirm('You can not undo this action. Are you sure ?', function(e){
                        if(e){
                            $.ajax({
                                'url':"{!!route('admin.customer-idea.deleteAll')!!}",
                                'data' : {arr: data,_token:$('meta[name="csrf-token"]').attr('content')},
                                'type': "POST",
                                'success':function(result){
                                    if(result.msg = 'ok'){
                                        table.rows('.selected').remove();
                                        table.draw();
                                        alertify.success('The data is removed!');
                                        location.reload();
                                    }
                                }
                            });
                        }
                    })
                })

                $('#btn-updateOrder').click(function(){
                    var rows_order = table_api.rows().data();
                    var data_order = {};
                    $('input[name="order"]').each(function(index){
                        var id = $(this).data('id');
                        var va = $(this).val();
                        data_order[id] = va;
                    });
                    $.ajax({
                        url: '{{route("admin.customer-idea.postAjaxUpdateOrder")}}',
                        type:'POST',
                        data: {data: data_order,  _token:$('meta[name="csrf-token"]').attr('content') },
                        success: function(rs){
                            if(rs.code == 200){
                                location.reload(true);
                            }
                        }
                    })
                })

                $('input[name="status"]').change(function(){
                    let value = 0;
                    if($(this).is(':checked')){
                        value = 1;
                    }
                    const id_item = $(this).data('id');
                    console.log(id_item);
                    $.ajax({
                        url: "{{route('admin.customer-idea.updateStatus')}}",
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
