<?php

namespace App\Transformers;

use App\Entities\User;
use Fluent\Auth\Facades\Auth;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    /**
     * {@inheritdoc}
     */
    public function transform(User $user)
    {
        return [
            'id'            => $user->id,
            'access_token'  => [
                'token'      => $user->token ?? auth('api')->getToken()->__toString() ?? null,
                'token_type' => 'bearer',
                'expires_in' => Auth::guard('api')->factory()->getTTL() * 60 ?? null,
            ],
            'email'    => $user->email,
            'username' => $user->username,
            'bio'      => $user->bio,
            'image'    => $user->image,
        ];
    }
}
