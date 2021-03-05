<?php

namespace App\Controllers;

use App\Entities\User;
use App\Models\UserModel;
use App\Transformers\UserTransformer;
use Fluent\Auth\Facades\Auth;

class AuthenticationController extends Controller
{
    /** @var \App\Models\UserModel */
    protected $user;

    /** @var \App\Entities\User */
    protected $entity;

    /**
     * AuthenticationController constructor.
     *
     * @return void
     */
    public function __construct()
    {
        $this->entity = new User();
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

        $this->entity->token = Auth::guard('api')->tokenById($this->user->getInsertID());

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

        $credentials = ['email' => $request->email, 'password' => $request->password];

        if (! $token = Auth::guard('api')->attempt($credentials)) {
            return $this->fail(lang('Auth.failed'), 401)->setStatusCode(401);
        }

        $user = Auth::guard('api')->user();
        $user->token = $token;

        return $this->fractalItem($user, new UserTransformer(), 'user');
    }
}
