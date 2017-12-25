<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    public $table = 'promotions';

    protected $guarded = ['id'];

    public function orders()
    {
        return $this->hasMany('App\Models\Order');
    }
}
