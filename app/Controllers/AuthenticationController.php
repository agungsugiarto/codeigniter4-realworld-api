<?php

namespace App\Controllers;

use App\Entities\UserEntity;
use App\Models\UserModel;
use App\Transformers\UserTransformer;
use Config\Services;

class AuthenticationController extends Controller
{
    /** @var \App\Libraries\Auth\AuthenticationService */
    protected $auth;

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
        $this->auth = Services::auth();
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
        ];

        if (! $this->validate($rules)) {
            return $this->fail(
                $this->parseError($this->validator->getErrors())
            );
        }
        
        $this->entity->email = $request->email;
        $this->entity->username = $request->username;
        $this->entity->password = password_hash($request->password, PASSWORD_DEFAULT);
        $this->entity->token = $this->auth->generateToken($this->entity);

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

        if ($user = $this->auth->attempt($request->email, $request->password)) {
            return $this->fractalItem($user, new UserTransformer());
        }

        return $this->fail(['errors' => ['email or password' => ['is invalid']]])->setStatusCode(422);
    }
}
