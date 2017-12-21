<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public $table = 'categories';

    protected $guard = ['id'];

    public function agencies()
    {
        return $this->belongsToMany('App\Models\Agencies');
    }

    public function products()
    {
        return $this->hasMany('App\Models\Products');
    }

    public function meta_configs()
    {
        return $this->morphMany('App\Models\MetaCongiguration', 'metable');
    }
}
