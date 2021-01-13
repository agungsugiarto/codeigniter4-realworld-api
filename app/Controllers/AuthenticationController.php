<?php

namespace App\Controllers;

use App\Entities\UserEntity;
use App\Models\UserModel;
use App\Transformers\UserTransformer;
use Fluent\Auth\Result;

class AuthenticationController extends Controller
{
    /** @var \App\Models\UserModel */
    protected $user;

    /** @var \App\Entities\UserEntity */
    protected $entity;

    /**
     * AuthenticationController constructor.
     *
     * @return void
     */
    public function __construct()
    {
        $this->entity = new UserEntity();
        $this->user = new UserModel();
    }

    /**
     * Register New Users from POST Requests to /api/users.
     *
     * @return \CodeIgniter\HTTP\Response
     */
    public function register()
    {
        $request = (object) $this->request->getPost();

        $rules = [
            'email'    => 'required|is_unique[users.email]|valid_email',
            'username' => 'required|is_unique[users.username]|alpha_numeric',
            'password' => 'required|min_length[5]',
            'bio'      => 'if_exist|min_length[5]',
            'image'    => 'if_exist|valid_url'
        ];

        if (! $this->validate($rules)) {
            return $this->fail(
                $this->parseError($this->validator->getErrors())
            );
        }
        
        $this->entity->email    = $request->email;
        $this->entity->username = $request->username;
        $this->entity->password = $request->password;
        $this->entity->bio      = $request->bio ?? null;
        $this->entity->image    = $request->image ?? null;

        $this->user->save($this->entity);

        return $this->fractalItem($this->entity, new UserTransformer(), 'user');
    }

    /**
     * Return token after successful login.
     *
     * @return \CodeIgniter\HTTP\Response
     */
    public function login()
    {
        $request = (object) $this->request->getPost();

        $rules = [
            'email'    => 'required|valid_email',
            'password' => 'required',
        ];

        if (! $this->validate($rules)) {
            return $this->fail(
                $this->parseError($this->validator->getErrors())
            );
        }

        // check user credentials
        $result = auth()->check(['email' => $request->email, 'password' => $request->password]);

        if ($result->isOK()) {
            return $this->generateToken($result);
        }

        return $this->fail(['errors' => ['message' => [$result->reason()]]])->setStatusCode(422);
    }

    /**
     * Login this user and try to create token.
     * 
     * @return mixed
     */
    protected function generateToken(Result $result)
    {
        /** @var \App\Entities\UserEntity */
        $user = $result->extraInfo();

        // try to login this user
        auth('token')->login($user);

        // remove all first current token user
        // if you don't need this just uncomment
        $user->revokeAllAccessTokens();

        // generate new token user
        $token = $user->generateAccessToken('login')->raw_token;

        // added object token
        $user->token = $token;

        return $this->fractalItem($user, new UserTransformer(), 'user');
    }
}
