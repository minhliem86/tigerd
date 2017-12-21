<?php
namespace App\Repositories;

use App\Repositories\Contract\RestfulInterface;
use App\Repositories\Eloquent\BaseRepository;
use App\Models\Agencies;

class AgencyRepository extends BaseRepository implements RestfulInterface{

    public function getModel()
    {
        return Agencies::class;
    }
    // END

}