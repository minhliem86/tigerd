@extends('Admin::layouts.main-layout')

@section('link')
    <a href="{!! route('admin.subscribe.download') !!}" class="btn btn-primary">Download</a>
@stop

@section('title','Quản Lý Newsletter')

@section("content")
    <div class="row">
        <div class="col-md-12">
            <div class="wrap-table-config">
                <table class="table">
                    <thead>
                    <tr>
                        <th width="100">#</th>
                        <th width="40%">Email</th>
                        <th>Thời gian</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($newsletters as $item_newsletter)
                        <tr>
                            <td>{!! $item_newsletter->id !!}</td>
                            <td>{!! $item_newsletter->email !!}</td>
                            <td>{!! Carbon\Carbon::parse($item_newsletter->created_at)->format('d-m-Y') !!}</td>
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
            @if(session('success'))
                alertify.success('{!! session('success') !!}')
            @endif
        })
    </script>
@stop