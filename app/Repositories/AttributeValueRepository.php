<?php
namespace App\Repositories;

use App\Repositories\Contract\RestfulInterface;
use App\Repositories\Eloquent\BaseRepository;
use App\Models\AttributeValue;

class AttributeValueRepository extends BaseRepository implements RestfulInterface{

    public function getModel()
    {
        return AttributeValue::class;
    }
    // END

}