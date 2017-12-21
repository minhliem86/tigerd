<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    public $table = 'comments';

    protected $guard = ['id'];

    public function products()
    {
        return $this->belongsToMany('App\Models\Products');
    }
}
