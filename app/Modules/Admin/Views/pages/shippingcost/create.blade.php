@extends('Admin::layouts.main-layout')

@section('link')
    <button class="btn btn-primary" onclick="submitForm();">Save</button>
@stop

@section('title','Giá Ship')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <form method="POST" action="{{route('admin.shippingcost.store')}}" id="form" role="form" class="form-horizontal">
                {{Form::token()}}
                <fieldset>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Thành Phố:</label>
                        <div class="col-md-10">
                            {!! Form::select('city_id', $city, old('city_id'), ['class' =>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Quận/Huyện:</label>
                        <div class="col-md-10">
                            {!! Form::select('district_id', ['' => 'Vui lòng chọn Quận/Huyện'], old('district_id'), ['class' =>'form-control', 'disabled']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Giá ship:</label>
                        <div class="col-md-10">
                            {!! Form::number('cost', old('cost'), ['class'=>'form-control', 'placeholder' => 'VD: 30000', 'min'=>0]) !!}
                        </div>
                    </div>

                </fieldset>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
    <script src="{{asset('public')}}/vendor/laravel-filemanager/js/lfm.js"></script>
    <script src="{{asset('public/assets/admin/dist/js/script.js')}}"></script>
    <script>
        const url = "{{url('/')}}"
        init_tinymce(url);
        // BUTTON ALONE
        init_btnImage(url,'#lfm');
        // SUBMIT FORM
        function submitForm(){
            $('form').submit();
        }
    </script>
@stop
