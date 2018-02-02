<!--TESTIMONIAL-->
@if(!$testimonial->isEmpty())
<section class="testimonial-container" data-aos="fade-up">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="testimonial-inner">
                    <div class="carousel slide" id="carouselTestimonial" data-ride="carousel" data-interval="5000">
                        <ol class="carousel-indicators">
                            @foreach($testimonial as $k=>$item_indicators)
                            <li data-target="#carouselTestimonial" data-slide-to="{!! $k !!}" class="active"></li>
                            @endforeach
                        </ol>
                        <div class="carousel-inner">
                            @foreach($testimonial as $k=>$item)
                            <div class="carousel-item active">
                                <figure>
                                    <img src="{!! asset($item->img_url) !!}" class="rounded-circle img-fluid" alt="{!! $item->customer_name !!}">
                                    <figcaption>
                                        <h4 class="title-caption">{!! $item->customer_name !!}</h4>
                                        <div class="content-caption">
                                            {!! Str::words($item->content,15) !!}
                                        </div>
                                    </figcaption>
                                </figure>
                            </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif
<!--END TESTIMONIAL-->

