<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    public $table = 'user_addresses';

    protected $guard = ['id'];

    public function users()
    {
        return $this->belongsToMany('App\Models\User');
    }
}
