<?php
namespace App\Repositories;

use App\Repositories\Contract\RestfulInterface;
use App\Repositories\Eloquent\BaseRepository;
use App\Models\Company;

class CompanyRepository extends BaseRepository implements RestfulInterface{

    public function getModel()
    {
        return Company::class;
    }
    // END

    public function getFirst($columns = ['*'])
    {
        return $this->model->first($columns);
    }

}