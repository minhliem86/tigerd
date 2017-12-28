<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public $table = 'products';

    protected $guarded = ['id'];

    public function attributes()
    {
        return $this->belongsToMany('App\Models\Product','product_attributes','product_id', 'attribute_id');
    }

    public function orders()
    {
        return $this->belongsToMany('App\Models\OrderProduct', 'order_products', 'product_id', 'order_id');
    }
}
