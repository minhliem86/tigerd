<?php
namespace App\Repositories;

use App\Repositories\Contract\RestfulInterface;
use App\Repositories\Eloquent\BaseRepository;
use App\Models\Product;

class ProductRepository extends BaseRepository implements RestfulInterface
{

    public function getModel()
    {
        return Product::class;
    }

    // END
    public function getProductHomePage($columns = ['*'], $with = [])
    {
        $query = $this->make($with);
        return $query->where('status',1)->where('visibility', 1)->get($columns);
    }
    public function hotProduct($data = ['*'])
    {
        return $this->model->where('status', 1)->where('hot', 1)->where('visibility', 1)->get($data);
    }

    public function relateProduct($array_id = [],$data = ['*'], $with = [])
    {
        $query = $this->make($with);
        return $query->where('status',1)->where('visibility', 1)->whereNotIn('id',$array_id)->get($data);
    }

    public function getProductBySlug($slug, $data = ['*'], $with = [])
    {
        $query = $this->make($with);
        return $query->where('status', 1)->where('visibility', 1)->where('slug',$slug)->first($data);
    }

}