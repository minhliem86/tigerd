<?php
namespace App\Repositories;

use App\Repositories\Contract\RestfulInterface;
use App\Repositories\Eloquent\BaseRepository;
use App\Models\PaymentSupplier;

class PaymentSupplierRepository extends BaseRepository implements RestfulInterface{

    public function getModel()
    {
        return PaymentSupplier::class;
    }
    // END

}