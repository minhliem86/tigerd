<?php
namespace App\Repositories;

use App\Repositories\Contract\RestfulInterface;
use App\Repositories\Eloquent\BaseRepository;
use App\Models\Customer;

class CustomerRepository extends BaseRepository implements RestfulInterface{

    public function getModel()
    {
        return Customer::class;
    }
    // END

}