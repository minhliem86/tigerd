<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttributeValue extends Model
{
    public $table = 'attribute_values';

    protected $guarded = ['id'];

    public function attributes()
    {
        return $this->belongsToMany('App\Models\Attribute');
    }
}
