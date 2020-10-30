<?php

namespace App\Transformers;

use App\Entities\UserEntity;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    /**
     * {@inheritdoc}
     */
    public function transform(UserEntity $user)
    {
        return [
            'email'    => $user->email,
            'username' => $user->username,
            'bio'      => $user->bio,
            'image'    => $user->image,
            'token'    => $user->token,
        ];
    }
}
