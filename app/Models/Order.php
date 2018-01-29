<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public $table = 'orders';

    protected $guarded = ['id'];

    public function customers()
    {
        return $this->belongsTo('App\Models\Customer', 'customer_id');
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
        return $this->belongsTo('App\Models\ShipStatus', 'shipstatus_id');
    }
    public function paymentstatus()
    {
        return $this->belongsTo('App\Models\PaymentStatus', 'paymentstatus_id');
    }
    public function paymentmethods()
    {
        return $this->belongsTo('App\Models\PaymentMethod', 'paymentmethod_id');
    }
}
