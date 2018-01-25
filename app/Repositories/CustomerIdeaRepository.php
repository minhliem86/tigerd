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

}