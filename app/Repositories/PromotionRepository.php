<?php
namespace App\Repositories;

use App\Repositories\Contract\RestfulInterface;
use App\Repositories\Eloquent\BaseRepository;
use App\Models\Promotion;

class PromotionRepository extends BaseRepository implements RestfulInterface{

    public function getModel()
    {
        return Promotion::class;
    }
    // END

}