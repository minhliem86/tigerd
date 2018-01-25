<?php
namespace App\Repositories;

use App\Repositories\Contract\RestfulInterface;
use App\Repositories\Eloquent\BaseRepository;
use App\Models\Subcribe;

class SubcribeRepository extends BaseRepository implements RestfulInterface{

    public function getModel()
    {
        return Subcribe::class;
    }
    // END

}