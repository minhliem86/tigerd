<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerIdea extends Model
{
    public $table = 'customer_ideas';

    protected $guarded = ['id'];

    public function products()
    {
        return $this->belongsTo('App\Models\Product','product_id');
    }
}
