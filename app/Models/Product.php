<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public $table = 'products';

    protected $guarded = ['id'];

    public function attributes()
    {
        return $this->belongsToMany('App\Models\Product','product_attribute','product_id', 'attribute_id');
    }

    public function values()
    {
        return $this->belongsToMany('App\Models\AttributeValue', 'product_value', 'product_id', 'attribute_value_id');
    }

    public function orders()
    {
        return $this->belongsToMany('App\Models\OrderProduct', 'order_products', 'product_id', 'order_id');
    }
    public function meta_configs()
    {
        return $this->morphMany('App\Models\MetaConfiguration', 'metable');
    }

    public function photos()
    {
        return $this->morphMany('App\Models\Photo','photoable');
    }
}
