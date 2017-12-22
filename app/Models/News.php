<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{

    public $table = "news";

    protected $guarded =  ['id'];

    public function meta_configs()
    {
        return $this->morphMany('\App\Models\MetaConfiguration', 'metable');
    }

    protected static function boot()
    {
        parent::boot();

        static::deleted(function ($news){
           $news->meta_configs()->delete();
        });
    }
}
