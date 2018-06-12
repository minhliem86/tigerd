<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsType extends Model
{
    public $table = 'news_type';

    protected $guarded = ['id'];

    public function news()
    {
        return $this->hasMany('App\Models\News', 'news_type_id');
    }

    public function meta_configs()
    {
        return $this->morphMany('App\Models\MetaConfiguration', 'metable');
    }
}
