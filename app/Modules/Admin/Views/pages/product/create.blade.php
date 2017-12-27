@extends('Admin::layouts.main-layout')

@section('link')
    <button class="btn btn-primary" onclick="submitForm();">Save</button>
@stop

@section('title','Sản Phẩm')

@section('content')
    <div class="row">
      <div class="col-sm-12">
          <fieldset>
              <form method="POST" action="{{route('admin.product.store')}}" id="form" role="form" class="form-horizontal" enctype="multipart/form-data">
                  {{Form::token()}}
                  <div class="form-group">
                      <label class="col-md-2 control-label">Danh Mục Sản phẩm</label>
                      <div class="col-md-10">
                          {!! Form::select('category_id', ['' => 'Chọn Danh Mục Sản Phẩm'] + $cate, old('category_id'), ['class'=> 'form-control']) !!}
                      </div>
                  </div>
                  <div class="form-group">
                      <label class="col-md-2 control-label">Tên Sản phẩm</label>
                      <div class="col-md-10">
                          {{Form::text('name',old('name'), ['class'=>'form-control', 'placeholder'=>'Tên Sản Phẩm'])}}
                      </div>
                  </div>
                  <div class="form-group">
                      <label class="col-md-2 control-label">
                          Mã Sản phẩm
                          <p><small>(từ 2,3 ký tự hoa. EX: Quần Tây -> QT)</small></p>
                      </label>
                      <div class="col-md-10">
                          {{Form::text('sku_product',old('sku_product'), ['class'=>'form-control', 'placeholder'=>'Mã Sản Phẩm'])}}
                      </div>
                  </div>
                  <div class="form-group">
                      <label class="col-md-2 control-label">Mô tả</label>
                      <div class="col-md-10">
                          {{Form::textarea('description',old('description'), ['class'=>'form-control', 'placeholder' => 'Mô tả'])}}
                      </div>
                  </div>
                  <div class="form-group">
                      <label class="col-md-2 control-label">Bài viết Sản Phẩm</label>
                      <div class="col-md-10">
                          {{Form::textarea('content',old('content'), ['class'=>'form-control my-editor', 'placeholder' => 'Bài viết Sản Phẩm'])}}
                      </div>
                  </div>
                  <div class="form-group">
                      <label class="col-md-2 control-label">Giá</label>
                      <div class="col-md-10">
                          {{Form::number('price',old('price'), ['class'=>'form-control', 'placeholder'=>'Giá'])}}
                      </div>
                  </div>
                  <div class="form-group">
                      <label class="col-md-2 control-label">Giảm Giá</label>
                      <div class="col-md-10">
                          {{Form::number('price',old('price'), ['class'=>'form-control', 'placeholder'=>'0'])}}
                      </div>
                  </div>
                  <div class="form-group">
                      <label class="col-md-2 control-label">Nhập Kho</label>
                      <div class="col-md-10">
                          {{Form::number('stock_quality',old('stock_quality'), ['class'=>'form-control', 'placeholder'=>'0'])}}
                      </div>
                  </div>
                  <div class="form-group">
                      <label class="col-md-2 control-label">Hình Ảnh</label>
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
              </form>
          </fieldset>

          <fieldset class="area-control img-detail">
              <legend>
                  <div class="checkbox">
                      <input type="checkbox" name="img_detail" id="img_detail" class="trigger_input"> HÌNH ẢNH CHI TIẾT
                  </div>
              </legend>
              <div class="wrap-img_detail wrap_general">
                  <div class="form-group clearfix">
                      <input type="file" name="thumb-input[]" id="thumb-input" multiple >
                  </div>
              </div>
          </fieldset>

          <fieldset class="area-control attribute-section">
              <legend>
                  <div class="flex-container">
                      <div class="checkbox flex-item">
                          <input type="checkbox" name="attribute_section" id="attribute_section" class="trigger_input" data-trigger=".btn-att"> THUỘC TÍNH SẢN PHẨM
                      </div>
                      <div class="flex-item text-right">
                          <button onclick="openModal('modal-add-attribute')" type="button" disabled class="btn btn-primary btn-att" ><i class="fa fa-plus"></i> Thêm Mới</button>
                      </div>
                  </div>
              </legend>
              <div class="wrap-attribute_section wrap_general">
                  @include('Admin::ajax.attribute.attribute')

              </div>
          </fieldset>

          <fieldset>
              <legend>
                  <div class="checkbox">
                      <input type="checkbox" name="meta_config" id="meta_config"> CẤU HÌNH SEO
                  </div>
              </legend>
              <div class="wrap-seo">
                  <div class="form-group clearfix">
                      <label class="col-md-2 control-label">Meta Keywords:</label>
                      <div class="col-md-10">
                          <input type="text" required="" placeholder="Từ khóa bài viết (ngăn cách bởi dấu `,`. Ex: quầy tây, quần kaki)" id="meta_keywords" class="form-control" name="meta_keywords">
                      </div>
                  </div>
                  <div class="form-group clearfix">
                      <label class="col-md-2 control-label">Meta Description:</label>
                      <div class="col-md-10">
                          <input type="text" required="" placeholder="Mô tả bài viết" id="meta_description" class="form-control" name="meta_description">
                      </div>
                  </div>
                  <div class="form-group clearfix">
                      <label class="col-md-2 control-label">Hình ảnh SEO:</label>
                      <div class="col-md-10">
                          <div class="input-group">
                            <span class="input-group-btn">
                            <a id="lfm-meta" data-input="thumbnail_meta" data-preview="holder_meta" class="btn btn-primary">
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

      </div>
    </div>

    <div class="modal fade" tabindex="-1" role="dialog" id="modal-add-attribute">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Thêm Thuộc Tính</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="" class="control-label">Tên Thuộc Tính</label>
                        <input type="text" name="att_name" class="form-control att">
                    </div>
                    <div class="form-group">
                        <label for="" class="control-label">Mô tả</label>
                        <textarea name="att_description" rows="3" class="form-control att"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="addAttribute( '{!! route('admin.product.createAttribute') !!}','modal-add-attribute')">Thêm</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div class="modal fade" tabindex="-1" role="dialog" id="modal-add-value">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Thêm Giá Trị</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="" class="control-label">Tên Thuộc Tính</label>
                        <input type="text" name="att_name" class="form-control att">
                    </div>
                    <div class="form-group">
                        <label for="" class="control-label">Tên Thuộc Tính</label>
                        <input type="text" name="att_name" class="form-control att">
                    </div>
                    <div class="form-group">
                        <label for="" class="control-label">Mô tả</label>
                        <textarea name="att_description" rows="3" class="form-control att"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="addAttribute( '{!! route('admin.product.createAttribute') !!}','modal-add-attribute')">Thêm</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@endsection

@section('script')
    <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
    <script src="{{asset('public')}}/vendor/laravel-filemanager/js/lfm.js"></script>
    <script src="{{asset('public/assets/admin/dist/js/script.js')}}"></script>

    <!--BT Upload-->
    <link rel="stylesheet" href="{{asset('/public/assets/admin')}}/dist/js/plugins/bootstrap-input/css/fileinput.min.css">
    <script src="{{asset('/public/assets/admin')}}/dist/js/plugins/bootstrap-input/js/plugins/sortable.min.js"></script>
    <script src="{{asset('/public/assets/admin')}}/dist/js/plugins/bootstrap-input/js/plugins/purify.min.js"></script>
    <script src="{{asset('/public/assets/admin')}}/dist/js/plugins/bootstrap-input/js/fileinput.min.js"></script>
    <script>
        const url = "{{url('/')}}"
        init_tinymce(url);
        // BUTTON ALONE
        init_btnImage(url,'#lfm');
        init_btnImage(url,'#lfm-meta');
        // SUBMIT FORM
        function submitForm(){
         $('form').submit();
        }

        /*FUNCTION MODAL*/
        function openModal(id, id_att){
            if(id_att){
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                })
            }else{

            }
            $('#'+id).modal('show');

        }

        /*ADD ATTRIBUTE*/
        function addAttribute(url,idModal){
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url : url,
                type: 'POST',
                data: {name_att: $('input[name=att_name]').val(), description: $('textarea[name=att_name]').val() },
                success: function (data)
                {
                    if(data.rs == 'ok'){
                        $('.wrap-attribute_section').html(data.data)
                        $('#'+idModal).modal('hide');
                        $('input[name=att_name]').val('');
                        $('textarea[name=att_description]').val('');
                        $(document).trigger('icheck');
                    }
                }
            })
        }

        /*ADD ATTRIBUTE VALUE AREA*/
        function addAttArea(url)
        {
            var arr_att = $('input[name="att[]"]').map(function(){
                if($(this). prop("checked") == true){
                    return $(this).val();
                }
            }).get();
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: url,
                type: 'POST',
                data: {arr_att: arr_att},
                success: function(data){

                }
            })
        }

        $(document).ready(function(){
            $('.wrap-seo').hide();
            $('input#meta_config').on('ifChecked', function (event) {
                $('.wrap-seo').slideDown();
            })
            $('input#meta_config').on('ifUnchecked', function (event) {
                $('.wrap-seo').slideUp();
            });

            $('.wrap_general, .wrap-att-value').hide();

            $('input.trigger_input').on('ifChecked', function (event) {
                var name = $(this).attr('name');
                $('.wrap-'+name).slideDown();
                $($(this).data('trigger')).prop('disabled',false);

            }).on('ifUnchecked', function (event) {
                var name = $(this).attr('name');
                $('.wrap-'+name).slideUp();
                $($(this).data('trigger')).prop('disabled',true);
            })
            $(document).on('icheck', function() {
                $('.checkbox-att input').iCheck({
                    checkboxClass:"icheckbox_flat",
                    increaseArea:"20%"
                }).on('ifChecked', function(event){
                    var id_trigger = $(this).data('trigger');
                    console.log(id_trigger);
                    $('#btn-att-create-'+id_trigger).prop('disabled',false);
                    $('#att_value_'+id_trigger).slideDown();
                }).on('ifUnchecked', function(event){
                    var id_trigger = $(this).data('trigger');
                    $('#btn-att-create-'+id_trigger).prop('disabled',true);
                    $('#att_value_'+id_trigger).slideUp();
                });
            }).trigger('icheck');
        })



        $(document).ready(function(){
          // var footerTemplate = '<div class="file-thumbnail-footer" style ="height:94px">\n' +
          // '   <div style="margin:5px 0">\n' +
          // '       <input class="kv-input kv-new form-control input-sm text-center {TAG_CSS_NEW}" value="{caption}" placeholder="Enter caption..." name="caption[]">\n' +
          // '   </div>\n' +
          // '   {size} {progress} {actions}\n' +
          // '</div>';
            $("#thumb-input").fileinput({
                uploadUrl: "{{route('admin.product.store')}}", // server upload action
                uploadAsync: true,
                showUpload: false,
                showCaption: false,
                // layoutTemplates: {footer: footerTemplate},
                // previewThumbTags: {
                //     '{TAG_VALUE}': '',        // no value
                //     '{TAG_CSS_NEW}': '',      // new thumbnail input
                //     '{TAG_CSS_INIT}': 'hide'  // hide the initial input
                // },
                dropZoneEnabled : false,
                fileActionSettings:{
                  showUpload : false,
                }
            })

        })
    </script>
@stop
