<?php

namespace App\Entities;

use App\Models\DB;
use Fluent\Auth\Entities\User;

class UserEntity extends User
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
            ->where('follower_id', auth('token')->user()->id)
            ->where('followed_id', $this->id)
            ->countAllResults() !== 0;
    }
}
