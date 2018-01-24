<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public $table = 'products';

    protected $guarded = ['id'];


    public function categories()
    {
        return $this->belongsTo('App\Models\Category', 'category_id');
    }

    public function attributes()
    {
        return $this->belongsToMany('App\Models\Attribute','product_attribute','product_id', 'attribute_id');
    }

    public function values()
    {
        return $this->belongsToMany('App\Models\AttributeValue', 'product_value', 'product_id', 'attribute_value_id');
    }

    public function orders()
    {
        return $this->belongsToMany('App\Models\OrderProduct', 'order_products', 'product_id', 'order_id')->withPivot('quantity','unit_price')->withTimestamps();
    }
    public function meta_configs()
    {
        return $this->morphMany('App\Models\MetaConfiguration', 'metable');
    }

    public function photos()
    {
        return $this->morphMany('App\Models\Photo','photoable');
    }

    public function product_links()
    {
        return $this->hasMany('App\Models\ProductLink');
    }
}
