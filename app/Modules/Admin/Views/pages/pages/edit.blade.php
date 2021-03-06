@extends('Admin::layouts.main-layout')

@section('link')
    {{Html::link(url()->previous(), 'Cancel', ['class'=>'btn btn-danger'])}}
    <button class="btn btn-primary" onclick="submitForm();">Save Changes</button>
@stop

@section('title','Nhà Cung Cấp')

@section('content')
    <div class="row">
      <div class="col-sm-12">
        {{Form::model($inst, ['route'=>['admin.pages.update',$inst->id], 'method'=>'put', 'class' => 'form-horizontal' ])}}
          <fieldset>
              <div class="form-group">
                  <label class="col-md-2 control-label">Tên Trang:</label>
                  <div class="col-md-10">
                      {{Form::text('name',old('name'), ['class'=>'form-control', 'placeholder'=>'Tên'])}}
                  </div>
              </div>
              <div class="form-group">
                  <label class="col-md-2 control-label">Bài viết:</label>
                  <div class="col-md-10">
                      {!! Form::textarea('description',old('description'), ['class'=> 'form-control my-editor', 'placeholder' => 'Mô tả ...']) !!}
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
                          <img id="holder_meta" style="margin-top:15px;max-height:100px;" src="{!! $inst->meta_configs()->count() ? asset($inst->meta_configs()->first()->meta_img) : null !!}">
                      </div>
                  </div>
                  {!! Form::hidden('meta_config_id',$inst->meta_configs()->count() ? $inst->meta_configs()->first()->id : '') !!}
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
