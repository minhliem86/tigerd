<input type="file" name="thumb-value[{!! LP_lib::unicodenospace($item_value->id) !!}][]" id="{!! LP_lib::unicodenospace($item_value->value) !!}"  multiple>

<script>
    $('document').ready(function () {
        $("#{!! LP_lib::unicodenospace($item_value->value) !!}").fileinput({
            uploadUrl: "{!!route('admin.product.store')!!}", // server upload action
            uploadAsync: false,
            showUpload: false,
            showBrowse: false,
            browseLabel:'Chọn Hình',
            browseClass:'btn btn-primary btn-sm',
            showCaption: false,
            showCancel: false,
<<<<<<< HEAD
            dropZoneEnabled : false,
            browseOnZoneClick: false,

=======
            dropZoneEnabled : true,
            browseOnZoneClick: true,
>>>>>>> 1db5026d0e02a8821385c1070113cd5d5c066229
            fileActionSettings:{
                showUpload : false,
                showZoom: false,
                showDrag: false,
                showDownload: false,
                removeIcon: '<i class="fa fa-trash text-danger"></i>',
            },
            initialPreview: [
                @foreach($item_value->photos as $photo)
                    "{!!asset($photo->thumb_url)!!}",
                @endforeach
            ],
            initialPreviewAsData: true,
            initialPreviewFileType: 'image',
            initialPreviewConfig: [
                    @foreach($item_value->photos as $item_photo)
                {'url': '{!! route("admin.product.AjaxRemovePhoto") !!}', key: "{!! $item_photo->id !!}", caption: "{!! $item_photo->filename !!}"},
                @endforeach
            ],
            layoutTemplates: {
                progress: '<div class="kv-upload-progress hidden"></div>'
            },
        })
    })
</script>