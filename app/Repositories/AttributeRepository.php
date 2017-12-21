<?php
namespace App\Repositories;

use App\Repositories\Contract\RestfulInterface;
use App\Repositories\Eloquent\BaseRepository;
use App\Models\Attribute;

class AttributeRepository extends BaseRepository implements RestfulInterface{

    public function getModel()
    {
        return Attribute::class;
    }
    // END

}