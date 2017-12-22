<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pages extends Model
{
    public $table = 'pages';

    protected $guarded = ['id'];

    public function meta_configs()
    {
        return $this->morphMany('App\Models\MetaConfiguration', 'metable');
    }

    public static function boot()
    {
        parent::boot();

        static::deleted(function ($pages){
            $pages->meta_configs()->delete();
        });
    }
}
