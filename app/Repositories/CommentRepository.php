<?php
namespace App\Repositories;

use App\Repositories\Contract\RestfulInterface;
use App\Repositories\Eloquent\BaseRepository;
use App\Models\Comment;

class CommentRepository extends BaseRepository implements RestfulInterface{

    public function getModel()
    {
        return Comment::class;
    }
    // END

}