<?php
namespace App\Repositories;

use App\Repositories\Contract\RestfulInterface;
use App\Repositories\Eloquent\BaseRepository;
use App\Models\PaymentMethod;

class PaymentMethodRepository extends BaseRepository implements RestfulInterface{

    public function getModel()
    {
        return PaymentMethod::class;
    }
    // END

}