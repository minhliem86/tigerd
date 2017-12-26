<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    public $table = "attributes";

    protected $guarded = ['id'];

    public function products()
    {
        return $this->belongsToMany('App\Models\Product','product_attributes','attribute_id', 'product_id');
    }

    public function attribute_values()
    {
        return $this->hasMany('App\Models\AttributeValue');
    }
}
