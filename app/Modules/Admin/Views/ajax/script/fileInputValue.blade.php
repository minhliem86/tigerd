<input type="file" name="thumb-value[{!! $id !!}][]" id="{!! $id !!}"  multiple>

<script>
    $('document').ready(function () {
        $("#{!! $id !!}").fileinput({
            uploadUrl: "{!!route('admin.product.store')!!}", // server upload action
            uploadAsync: true,
            showUpload: false,
            showBrowse: true,
            browseLabel:'Chọn Hình',
            browseClass:'btn btn-primary btn-sm',
            showCaption: false,
            showCancel: false,
            dropZoneEnabled : false,
            browseOnZoneClick: false,
            fileActionSettings:{
                showUpload : false,
                showZoom: false,
                showDrag: false,
                showDownload: false,
                removeIcon: '<i class="fa fa-trash text-danger"></i>',
            },
            layoutTemplates: {
                progress: '<div class="kv-upload-progress hidden"></div>'
            }
        })
    })
</script>
