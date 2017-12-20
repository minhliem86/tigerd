<?php
namespace App\Repositories;

use App\Repositories\Contract\RestfulInterface;
use App\Repositories\Eloquent\BaseRepository;
use App\Models\Category;

class CategoryRepository extends BaseRepository implements RestfulInterface{

    public function getModel()
    {
        return Category::class;
    }
    // END

}