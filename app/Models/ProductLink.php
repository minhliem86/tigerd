<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductLink extends Model
{
    public $table = 'product_links';

    protected $guarded = ['id'];

    public function products()
    {
        return $this->belongsTo(\App\Models\Product::class, 'product_id' );
    }
}
