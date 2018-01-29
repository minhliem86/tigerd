@extends('Admin::layouts.main-layout')

@section('link')
    <button class="btn btn-primary" onclick="submitForm();">Save</button>
@stop

@section('title','Tin Tức')

@section('content')
    <div class="row">
      <div class="col-sm-12">
        <form method="POST" action="{{route('admin.news.store')}}" id="form" role="form" class="form-horizontal">
          {{Form::token()}}
            <fieldset>
                <div class="form-group">
                    <label class="col-md-2 control-label">Bài viết:</label>
                    <div class="col-md-10">
                        <input type="text" required="" placeholder="Tiêu đề Tin Tức" id="name" class="form-control" name="name">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Mô tả:</label>
                    <div class="col-md-10">
                        {!! Form::textarea('description',old('description'), ['class'=> 'form-control', 'placeholder' => 'Mô tả ngắn ...']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Nội Dung:</label>
                    <div class="col-md-10">
                        {!! Form::textarea('content',old('content'), ['class'=> 'form-control my-editor', 'placeholder' => 'Nội dung ...']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Hình ảnh:</label>
                    <div class="col-md-10">
                        <div class="input-group">
                            <span class="input-group-btn">
                            <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                            <i class="fa fa-picture-o"></i> Chọn
                            </a>
                            </span>
                            <input id="thumbnail" class="form-control" type="hidden" name="img_url">
                        </div>
                        <img id="holder" style="margin-top:15px;max-height:100px;">
                    </div>
                </div>
            </fieldset>

            <fieldset>
                <legend>
                    <div class="checkbox">
                        <input type="checkbox" name="meta_config" id="meta_config"> CẤU HÌNH SEO
                    </div>
                </legend>
                <div class="wrap-seo">
                    <div class="form-group">
                        <label class="col-md-2 control-label">Meta Keywords:</label>
                        <div class="col-md-10">
                            <input type="text" required="" placeholder="Từ khóa bài viết (ngăn cách bởi dấu `,`. Ex: quầy tây, quần kaki)" id="meta_keywords" class="form-control" name="meta_keywords">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Meta Description:</label>
                        <div class="col-md-10">
                            <input type="text" required="" placeholder="Mô tả bài viết" id="meta_description" class="form-control" name="meta_description">
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
                                <input id="thumbnail_meta" class="form-control" type="hidden" name="meta_img">
                            </div>
                            <img id="holder_meta" style="margin-top:15px;max-height:100px;">
                        </div>
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
        init_btnImage(url,'#lfm_meta');
        // SUBMIT FORM
        function submitForm(){
         $('form').submit();
        }

        /*CONTROL SEO*/
        $('.wrap-seo').hide();
        $('input#meta_config').on('ifChecked', function (event) {
            $('.wrap-seo').slideDown();
        })
        $('input#meta_config').on('ifUnchecked', function (event) {
            $('.wrap-seo').slideUp();
        })
    </script>
@stop
