<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agencies extends Model
{
    public $table = 'agencies';

    protected $guarded = ['id'];

    public function categories()
    {
        return $this->hasMany('App\Models\Category', 'agency_id');
    }

    public function products()
    {
        return $this->hasManyThrough('App\Models\Product', 'App\Models\Category');
    }
}
