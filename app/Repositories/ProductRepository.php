<?php
namespace App\Repositories;

use App\Repositories\Contract\RestfulInterface;
use App\Repositories\Eloquent\BaseRepository;
use App\Models\Product;

class ProductRepository extends BaseRepository implements RestfulInterface{

    public function getModel()
    {
        return Product::class;
    }
    // END

}