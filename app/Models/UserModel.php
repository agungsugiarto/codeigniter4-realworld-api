<?php

namespace App\Models;

use App\Entities\UserEntity;
use App\Libraries\Auth\AuthenticationService;
use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $returnType = UserEntity::class;
    protected $allowedFields = ['email', 'username', 'password', 'token', 'bio', 'image'];
    protected $useTimestamps = true;
    protected $skipValidation = true;

    /**
     * Generate fake data.
     *
     * @param \Faker\Generator $faker
     * @return array
     */
    public function fake($faker)
    {
        return [
            'email'    => $faker->unique()->safeEmail,
            'username' => $username = str_replace('.', '', $faker->unique()->userName),
            'password' => password_hash('password', PASSWORD_DEFAULT),
            'token'    => (new AuthenticationService())->generateToken(new UserEntity(['username' => $username])),
            'bio'      => $faker->sentence,
            'image'    => $faker->imageUrl(125, 125),
        ];
    }
}
