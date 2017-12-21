<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MetaConfiguration extends Model
{
    public $table = 'meta_configurations';

    public function metable()
    {
        return $this->morphTo();
    }
}
