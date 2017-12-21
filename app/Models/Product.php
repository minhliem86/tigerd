<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public $table = 'products';

    protected $guarded = ['id'];

    public function attributes()
    {
        return $this->hasMany('App\Models\Attributes');
    }

    public function orders()
    {
        return $this->belongsToMany('App\Models\OrderProduct', 'order_products', 'product_id', 'order_id');
    }
}
