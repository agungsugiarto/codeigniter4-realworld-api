<?php

namespace App\Models;

use App\Entities\UserEntity;
use CodeIgniter\Model;
use Fluent\Auth\Contracts\UserProviderInterface;
use Fluent\Auth\Traits\UserProvider as UserProviderTrait;

class UserModel extends Model implements UserProviderInterface
{
    use UserProviderTrait;

    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $returnType = UserEntity::class;
    protected $useTimestamps = true;
    protected $skipValidation = true;
    protected $useSoftDeletes = true;

    protected $allowedFields = [
        'email',
        'username',
        'bio',
        'image',
        'password',
        'reset_hash',
        'reset_at',
        'reset_expires',
        'activate_hash',
        'status',
        'status_message',
        'active',
        'force_pass_reset',
        'deleted_at',
    ];

    /**
     * Generate fake data.
     *
     * @param \Faker\Generator $faker
     * @return array
     */
    public function fake($faker)
    {
        return [
            'email'                => $faker->unique()->safeEmail,
            'username'             => str_replace('.', '', $faker->unique()->userName),
            'password'             => 'password',
            'bio'                  => $faker->sentence,
            'image'                => $faker->imageUrl(125, 125),
            'active'               => true,
            'force_password_reset' => false,
        ];
    }
}
