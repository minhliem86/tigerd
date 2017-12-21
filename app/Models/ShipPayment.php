<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShipPayment extends Model
{
    public $table = 'ship_payments';

    protected $guard = ['id'];

    public function orders()
    {
        return $this->hasMany('App\Models\Order');
    }
}
