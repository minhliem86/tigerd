<?php
namespace App\Repositories;

use App\Repositories\Contract\RestfulInterface;
use App\Repositories\Eloquent\BaseRepository;
use App\Models\MetaConfiguration;

class MetaRepository extends BaseRepository implements RestfulInterface{

    public function getModel()
    {
        return MetaConfiguration::class;
    }
    // END

}