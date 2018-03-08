<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    public $table = 'district';

    protected $guarded = ['id'];

    public function shippingcosts()
    {
        return $this->hasOne('App\Models\Shipping_Cost');
    }
}
