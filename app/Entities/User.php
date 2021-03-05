<?php

namespace App\Entities;

use App\Models\DB;
use CodeIgniter\Entity;
use Fluent\Auth\Contracts\AuthenticatorInterface;
use Fluent\Auth\Contracts\HasAccessTokensInterface;
use Fluent\Auth\Contracts\ResetPasswordInterface;
use Fluent\Auth\Contracts\VerifyEmailInterface;
use Fluent\Auth\Facades\Hash;
use Fluent\Auth\Traits\AuthenticatableTrait;
use Fluent\Auth\Traits\CanResetPasswordTrait;
use Fluent\Auth\Traits\HasAccessTokensTrait;
use Fluent\Auth\Traits\MustVerifyEmailTrait;
use Fluent\JWTAuth\Contracts\JWTSubjectInterface;

class User extends Entity implements
    AuthenticatorInterface,
    HasAccessTokensInterface,
    ResetPasswordInterface,
    JWTSubjectInterface,
    VerifyEmailInterface
{
    use AuthenticatableTrait;
    use CanResetPasswordTrait;
    use HasAccessTokensTrait;
    use MustVerifyEmailTrait;

    /**
     * Array of field names and the type of value to cast them as
     * when they are accessed.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Fill set password hash.
     *
     * @return $this
     */
    public function setPassword(string $password)
    {
        $this->attributes['password'] = Hash::make($password);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getJWTIdentifier()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

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
