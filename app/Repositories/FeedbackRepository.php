<?php
namespace App\Repositories;

use App\Repositories\Contract\RestfulInterface;
use App\Repositories\Eloquent\BaseRepository;
use App\Models\Feedback;

class FeedbackRepository extends BaseRepository implements RestfulInterface{

    public function getModel()
    {
        return Feedback::class;
    }
    // END

}