<?php

namespace App\Controllers;

use App\Models\DB;
use App\Repository\UserRepository;
use App\Transformers\ProfileUserTransformer;
use CodeIgniter\I18n\Time;
use Config\Services;

class ProfileController extends Controller
{
    /** @var \App\Repository\UserRepository */
    protected $repository;

    /**
     * UserController constructor.
     *
     * @return void
     */
    public function __construct()
    {
        $this->repository = new UserRepository();
    }

    /**
     * Get the profile of the user given by their username.
     *
     * @param string $username
     * @return \CodeIgniter\HTTP\Response
     */
    public function show(string $username)
    {
        $user = $this->repository->findWhere(['username' => $username])->first();

        if (is_null($user)) {
            return $this->fail($this->parseError(['profile' => "User {$username} not found"]), 404);
        }
        
        return $this->fractalItem($user, new ProfileUserTransformer(), 'profile');
    }

    /**
     * Follow the user given by their username and return the user if successful.
     *
     * @param string $username
     * @return \CodeIgniter\HTTP\Response
     */
    public function follow(string $username)
    {
        $user = $this->repository->findWhere(['username' => $username])->first();

        if (is_null($user)) {
            return $this->fail($this->parseError(['profile' => "User {$username} not found"]), 404);
        }

        DB::table('follows')
            ->insert([
                'follower_id' => auth('api')->user()->id,
                'followed_id' => $user->id,
                'created_at'  => Time::now(),
                'updated_at'  => Time::now(),
            ]);

        return $this->show($username);
    }

    /**
     * Unfollow the user given by their username and return the user if successful.
     *
     * @param string $username
     * @return \CodeIgniter\HTTP\Response
     */
    public function unFollow(string $username)
    {
        $user = $this->repository->findWhere(['username' => $username])->first();

        if (is_null($user)) {
            return $this->fail($this->parseError(['profile' => "User {$username} not found"]), 404);
        }

        DB::table('follows')
            ->where('follower_id', auth('api')->user()->id)
            ->where('followed_id', $user->id)
            ->delete();

        return $this->show($username);
    }
}
