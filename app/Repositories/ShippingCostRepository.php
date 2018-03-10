<?php
namespace App\Repositories;

use App\Repositories\Contract\RestfulInterface;
use App\Repositories\Eloquent\BaseRepository;
use App\Models\Shipping_Cost;

class ShippingCostRepository extends BaseRepository implements RestfulInterface{

    public function getModel()
    {
        return Shipping_Cost::class;
    }
    // END

}