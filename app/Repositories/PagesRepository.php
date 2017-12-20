<?php
namespace App\Repositories;

use App\Repositories\Contract\RestfulInterface;
use App\Repositories\Eloquent\BaseRepository;
use App\Models\Pages;

class PagesRepository extends BaseRepository implements RestfulInterface{

    public function getModel()
    {
        return Pages::class;
    }
    // END

}