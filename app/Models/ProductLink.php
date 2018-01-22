<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductLink extends Model
{
    public $table = 'product_links';

    public function products()
    {
        return $this->belongsTo(\App\Models\Product::class, 'product_id' );
    }
}
