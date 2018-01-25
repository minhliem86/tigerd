<?php
namespace App\Repositories;

use App\Repositories\Contract\RestfulInterface;
use App\Repositories\Eloquent\BaseRepository;
use App\Models\Videos;

class VideoRepository extends BaseRepository implements RestfulInterface{

    public function getModel()
    {
        return Videos::class;
    }
    // END

}