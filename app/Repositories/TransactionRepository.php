<?php
namespace App\Repositories;

use App\Repositories\Contract\RestfulInterface;
use App\Repositories\Eloquent\BaseRepository;
use App\Models\Transaction;

class TransactionRepository extends BaseRepository implements RestfulInterface{

    public function getModel()
    {
        return Transaction::class;
    }
    // END

}