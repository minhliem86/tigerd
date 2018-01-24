<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public $table = 'orders';

    protected $guarded = ['id'];

    public function users()
    {
        return $this->belongsToMany('App\Models\User');
    }

    public function ship_address()
    {
        return $this->hasOne('App\Models\ShipAddress');
    }

    public function products()
    {
        return $this->belongsToMany('App\Models\Product', 'order_products', 'order_id', 'product_id')->withPivot('quantity','unit_price')->withTimestamps();
    }

    public function shipstatus()
    {
        return $this->belongsToMany('App\Models\ShipStatus');
    }
    public function paymentstatus()
    {
        return $this->belongsToMany('App\Models\PaymentStatus');
    }
}
