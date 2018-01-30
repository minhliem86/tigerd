@extends('Admin::layouts.main-layout')

@section('link')
    <a href="{!! route('admin.product.configuable.create', $parent_product->id) !!}" class="btn btn-primary">Tạo thêm sản phẩm</a>
@stop

@section('title','Quản lý Sản phẩm phức hợp')

@section("content")
    <div class="row">
        <div class="col-md-12">
            <div class="wrap-title">
                <p style="font-size:16px; text-transform: uppercase;">Sản Phẩm: <b><a href="{!! route('admin.product.configuable.s1.edit', $parent_product->id) !!}">{!! $parent_product->name !!}</a></b></p>
            </div>

            <div class="wrap-table-config">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Hình Ảnh</th>
                            <th>Tên Sản Phẩm</th>
                            <th>Giá</th>
                            <th>Tồn Kho</th>
                            <th>Thuộc tính</th>
                            <th>Default</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($product_child as $item_child)
                            @php
                                $array_att = [];
                                   foreach($item_child->values as $item_value){
                                       $array_att[$item_value->attributes->name][$item_value->id] = $item_value->value;
                                   }
                                   $string = '';

                                   foreach ($array_att as $k => $v){
                                       $string .= '<p>'.$k.':';
                                       foreach ($v as $item_v){
                                           if($item_v == end($v)){
                                               $string .= ' '.$item_v.'</p>';
                                           }else{
                                               $string .= ' '.$item_v.',';
                                           }
                                       }
                                   }
                            @endphp
                        <tr>
                            <td><img src="{!! asset($item_child->img_url) !!}" class="img-responsive" style="width:80px" alt="{!! $item_child->name !!}"></td>
                            <td>{!! $item_child->name !!}</td>
                            <td>{!! number_format($item_child->price) !!} VND</td>
                            <td>{!! $item_child->stock !!}</td>
                            <td>{!! $string !!}</td>
                            <td>
                                <div class="radio">
                                    <input type="radio" name="default_att" data-parent="{!! $parent_product->id !!}"  value="{!! $item_child->id !!}" {!! $item_child->default ? 'checked': '' !!}>
                                </div>
                            </td>
                            <td>
                                <a href="{!! route('admin.product.configuable.edit',[$item_child->id, $parent_product->id]) !!}" class="btn btn-info btn-xs inline-block-span"> Edit </a>

                                <a href="{!! route('admin.product.configuable.remove', $item_child->id) !!}" class="btn btn-danger btn-xs inline-block-span"> Remove </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop

@section("script")
    <!-- ALERTIFY -->
    <link rel="stylesheet" href="{{asset('/public/assets/admin')}}/dist/js/plugins/alertify/alertify.css">
    <link rel="stylesheet" href="{{asset('/public/assets/admin')}}/dist/js/plugins/alertify/bootstrap.min.css">
    <script type="text/javascript" src="{{asset('/public/assets/admin')}}/dist/js/plugins/alertify/alertify.js"></script>

    <script>
        $(document).ready(function(){
            @if(Session::has('error'))
                alertify.error('{!! Session::get("error") !!}')
            @endif
            @if(Session::has('success'))
                alertify.success('{!! Session::get("success") !!}')
            @endif

            $('input[name=default_att]').on('ifChecked', function(e){
                var id = $(this).val();
                var parent_id = $(this).data('parent');
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: '{!! route("admin.product.configuable.changeDefault") !!}',
                    type: 'POST',
                    data: {id: id, parent_id: parent_id},
                    success: function(data){
                        if(!data.error){
                            alertify.success('Sản phẩm mặc định: '+ data.data);
                        }
                    }
                })
            })
        })
    </script>
@stop