<?php
namespace App\Repositories;

use App\Repositories\Contract\RestfulInterface;
use App\Repositories\Eloquent\BaseRepository;
use App\Models\NewsType;

class NewsTypeRepository extends BaseRepository implements RestfulInterface{

    public function getModel()
    {
        return NewsType::class;
    }
    // END

}