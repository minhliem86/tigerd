@if(!$product->photos->isEmpty())
    <ul id="image-gallery" class="gallery">
        @foreach($product->photos as $item_photo)
            <li data-thumb="{!! asset($item_photo->thumb_url) !!}">
                <img src="{!! asset($item_photo->img_url) !!}" class="img-fluid" />
            </li>
        @endforeach
    </ul>
@else
    <img src="{!! asset($product->img_url) !!}" class="img-fluid" alt="{!! $product->name !!}">
@endif
