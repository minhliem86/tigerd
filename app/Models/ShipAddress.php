<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShipAddress extends Model
{
    public $table = 'ship_addresses';

    protected $guarded = ['id'];

    public function orders()
    {
        return $this->belongsTo('App\Models\Order');
    }
}
