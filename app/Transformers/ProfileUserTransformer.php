<?php

namespace App\Transformers;

use App\Entities\User;
use League\Fractal\TransformerAbstract;

class ProfileUserTransformer extends TransformerAbstract
{
    public function transform(User $user)
    {
        return [
            'id'        => $user->id,
            'username'  => $user->username,
            'bio'       => $user->bio,
            'image'     => $user->image,
            'following' => $user->isFollowing(),
        ];
    }
}
