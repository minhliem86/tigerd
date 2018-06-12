@extends('Admin::layouts.main-layout')

@section('link')
    {{Html::link(url()->previous(), 'Cancel', ['class'=>'btn btn-danger'])}}
    <button class="btn btn-primary" onclick="submitForm();">Save Changes</button>
@stop

@section('title','Thể Loại Tin Tức')

@section('content')
    <div class="row">
      <div class="col-sm-12">
        {{Form::model($inst, ['route'=>['admin.newstype.update',$inst->id], 'method'=>'put', 'class' => 'form-horizontal' ])}}
          <fieldset>
              <div class="form-group">
                  <label class="col-md-2 control-label">Thể loại tin:</label>
                  <div class="col-md-10">
                      {{Form::text('title',old('title'), ['class'=>'form-control', 'placeholder'=>'Thể loại tin'])}}
                  </div>
              </div>
              <div class="form-group">
                  <label class="col-md-2 control-label" for="description">Sắp xếp</label>
                  <div class="col-md-10">
                      {{Form::text('order',old('order'), ['class'=>'form-control', 'placeholder'=>'order'])}}
                  </div>
              </div>
              <div class="form-group">
                  <label class="col-md-2 control-label" for="description">Trạng thái</label>
                  <div class="col-md-10">
                      <label class="toggle">
                          <input type="checkbox" name="status" value="1" {{$inst->status == 1 ? 'checked' : '' }}  >
                          <span class="handle"></span>
                      </label>
                  </div>
              </div>
              <div class="form-group">
                  <label class="col-md-2 control-label">Hình Ảnh:</label>
                  <div class="col-md-10">
                      <div class="input-group">
                 <span class="input-group-btn">
                   <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                     <i class="fa fa-picture-o"></i> Chọn
                   </a>
                 </span>
                          {{Form::hidden('img_url',old('img_url'), ['class'=>'form-control', 'id'=>'thumbnail' ])}}
                      </div>
                      <img id="holder" style="margin-top:15px;max-height:100px;" src="{{asset('public/upload/'.$inst->img_url)}}">
                  </div>
              </div>
          </fieldset>

          <fieldset>
              <legend>
                  <div class="checkbox my-checkbox">
                      <input type="checkbox" name="meta_config" id="meta_config" {!! $inst->meta_configs()->count() ? 'checked' : null !!}> CẤU HÌNH SEO
                  </div>
              </legend>
              <div class="wrap-seo">
                  <div class="form-group">
                      <label class="col-md-2 control-label">Meta Keywords:</label>
                      <div class="col-md-10">
                          {!! Form::text('meta_keywords', $inst->meta_configs()->count() ? $inst->meta_configs()->first()->meta_keywords : '' , ['class'=> 'form-control', 'placeholder'=>"Từ khóa bài viết (ngăn cách bởi dấu `,`. Ex: quầy tây, quần kaki)"]) !!}
                      </div>
                  </div>
                  <div class="form-group">
                      <label class="col-md-2 control-label">Meta Description:</label>
                      <div class="col-md-10">
                          {!! Form::text('meta_description', $inst->meta_configs()->count() ? $inst->meta_configs()->first()->meta_description : '', ['class'=> 'form-control', 'placeholder'=>"Mô tả bài viết"]) !!}
                      </div>
                  </div>
                  <div class="form-group">
                      <label class="col-md-2 control-label">Hình ảnh SEO:</label>
                      <div class="col-md-10">
                          <div class="input-group">
                            <span class="input-group-btn">
                            <a id="lfm_meta" data-input="thumbnail_meta" data-preview="holder_meta" class="btn btn-primary">
                            <i class="fa fa-picture-o"></i> Chọn
                            </a>
                            </span>
                              {{Form::hidden('meta_img',$inst->meta_configs()->count() ? $inst->meta_configs()->first()->meta_img : '', ['class'=>'form-control', 'id'=>'thumbnail_meta' ])}}
                          </div>
                          <img id="holder_meta" style="margin-top:15px;max-height:100px;" src="{!! $inst->meta_configs()->count() ? asset('public/upload/'.$inst->meta_configs()->first()->meta_img) : null !!}">
                      </div>
                  </div>
                  {!! Form::hidden('meta_config_id',$inst->meta_configs()->count() ? $inst->meta_configs()->first()->id : '') !!}
              </div>
          </fieldset>
        {!! Form::close() !!}
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
    init_btnImage(url,'#lfm_meta');
    // SUBMIT FORM
    function submitForm(){
     $('form').submit();
    }

    /*CONTROL SEO*/
    var flag = '{!! $inst->meta_configs()->count() ? true : false !!}';
    if(flag){
        $('.wrap-seo').show();
    }else{
        $('.wrap-seo').hide();
    }
    $('input#meta_config').on('ifChecked', function (event) {
        $('.wrap-seo').slideDown();
    })
    $('input#meta_config').on('ifUnchecked', function (event) {
        $('.wrap-seo').slideUp();
    })

    </script>
@stop
