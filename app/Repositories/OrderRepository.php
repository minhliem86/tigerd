<?php
namespace App\Repositories;

use App\Repositories\Contract\RestfulInterface;
use App\Repositories\Eloquent\BaseRepository;
use App\Models\Order;

class OrderRepository extends BaseRepository implements RestfulInterface{

    public function getModel()
    {
        return Order::class;
    }
    // END

}