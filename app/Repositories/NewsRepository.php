<?php
namespace App\Repositories;

use App\Repositories\Contract\RestfulInterface;
use App\Repositories\Eloquent\BaseRepository;
use App\Models\News;

class NewsRepository extends BaseRepository implements RestfulInterface{

    public function getModel()
    {
        return News::class;
    }
    // END

}