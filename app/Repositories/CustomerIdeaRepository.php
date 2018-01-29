<?php
namespace App\Repositories;

use App\Repositories\Contract\RestfulInterface;
use App\Repositories\Eloquent\BaseRepository;
use App\Models\CustomerIdea;

class CustomerIdeaRepository extends BaseRepository implements RestfulInterface{

    public function getModel()
    {
        return CustomerIdea::class;
    }
    // END

    public function getTestimonial($columns=['*'])
    {
        return $this->model->where('status',1)->get($columns);
    }

}