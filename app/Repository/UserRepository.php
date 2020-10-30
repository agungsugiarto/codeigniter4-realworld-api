<?php

namespace App\Repository;

use App\Models\UserModel;
use Fluent\Repository\Eloquent\BaseRepository;

class UserRepository extends BaseRepository
{
    /**
     * {@inheritdoc}
     */
    public function entity()
    {
        return UserModel::class;
    }
}
