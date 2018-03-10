<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shipping_Cost extends Model
{
    public $table = 'shipping_costs';

    protected $guarded= ['id'];

    public function districts()
    {
        return $this->belongsTo('App\Models\District');
    }
}
