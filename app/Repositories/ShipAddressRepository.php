<?php
namespace App\Repositories;

use App\Repositories\Contract\RestfulInterface;
use App\Repositories\Eloquent\BaseRepository;
use App\Models\ShipAddress;

class ShipAddressRepository extends BaseRepository implements RestfulInterface{

    public function getModel()
    {
        return ShipAddress::class;
    }
    // END

}