<?php

namespace App\Models;

use CodeIgniter\Model;
use Faker\Generator;
use Fluent\Auth\Contracts\UserProviderInterface;
use App\Entities\User;
use Fluent\Auth\Traits\UserProviderTrait;

class UserModel extends Model implements UserProviderInterface
{
    use UserProviderTrait;

    /**
     * The table's primary key.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Name of database table
     *
     * @var string
     */
    protected $table = 'users';
    protected $skipValidation = true;
    protected $useSoftDeletes = true;

    /**
     * The format that the results should be returned as.
     * Will be overridden if the as* methods are used.
     *
     * @var User
     */
    protected $returnType = User::class;

    /**
     * An array of field names that are allowed
     * to be set by the user in inserts/updates.
     *
     * @var array
     */
    protected $allowedFields = [
        'email',
        'username',
        'password',
        'email_verified_at',
        'remember_token',
        'bio',
        'image',
    ];

    /**
     * If true, will set created_at, and updated_at
     * values during insert and update routines.
     *
     * @var boolean
     */
    protected $useTimestamps = true;

    /**
     * Generate fake data.
     *
     * @return array
     */
    public function fake(Generator &$faker)
    {
        return [
            'email'    => $faker->unique()->safeEmail,
            'username' => str_replace('.', '', $faker->unique()->userName),
            'password' => 'secret',
            'bio'                  => $faker->sentence,
            'image'                => $faker->imageUrl(125, 125),
        ];
    }
}
