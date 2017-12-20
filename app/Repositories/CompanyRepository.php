<?php
namespace App\Repositories;

use App\Repositories\Contract\RestfulInterface;
use App\Repositories\Eloquent\BaseRepository;
use App\Models\CompanyInfomations;

class CompanyRepository extends BaseRepository implements RestfulInterface{

    public function getModel()
    {
        return CompanyInfomations::class;
    }
    // END

}