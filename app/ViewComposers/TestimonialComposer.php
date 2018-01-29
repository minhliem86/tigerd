<?php
namespace App\ViewComposers;

use Illuminate\View\View;
use App\Repositories\CustomerIdeaRepository;

class TestimonialComposer{

    protected $testimonial;

    public function __construct(CustomerIdeaRepository $testimonial)
    {
        $this->testimonial = $testimonial;
    }

    public function compose(View $view)
    {
        $testimonial = $this->testimonial->getTestimonial(['id', 'slug', 'customer_name', 'img_url', 'content']);
        $view->with(compact('testimonial'));
        // TODO: Bind data to view
    }
}