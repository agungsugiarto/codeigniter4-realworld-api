<?php

namespace App\Transformers;

use App\Entities\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    /**
     * {@inheritdoc}
     */
    public function transform(User $user)
    {
        return [
            'email'    => $user->email,
            'username' => $user->username,
            'bio'      => $user->bio,
            'image'    => $user->image,
            'token'    => $user->token ?? null,
        ];
    }
}
