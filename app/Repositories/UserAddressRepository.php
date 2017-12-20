<?php
namespace App\Repositories;

use App\Repositories\Contract\RestfulInterface;
use App\Repositories\Eloquent\BaseRepository;
use App\Models\UserAddress;

class UserAddressRepository extends BaseRepository implements RestfulInterface{

    public function getModel()
    {
        return UserAddress::class;
    }
    // END

}