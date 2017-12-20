<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    public $table = "news";

    protected $guard =  ['id'];

    public function meta_configs()
    {
        return $this->morphMany('App\Models\MetaConfiguration', 'metable');
    }
}
