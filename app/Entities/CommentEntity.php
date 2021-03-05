<?php

namespace App\Entities;

use App\Models\DB;
use CodeIgniter\Entity;

class CommentEntity extends Entity
{
    /**
     * Check if the user is following the user with the provided id.
     *
     * @param int $userID
     * @return bool
     */
    public function isFollowing()
    {
        return DB::table('follows')
            ->where('follower_id', auth('api')->user()->id)
            ->where('followed_id', $this->id)
            ->countAllResults() !== 0;
    }
}
