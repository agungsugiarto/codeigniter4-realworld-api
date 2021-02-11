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

        $user = $this->user->find($this->user->getInsertID());

        Auth::guard('token')->login($user);

        $this->entity->token = Auth::guard('token')
            ->user()
            ->generateAccessToken($request->email)
            ->raw_token;

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

        // check user credentials
        if (Auth::validate($credentials)) {
            // get user from request.
            $user = Auth::guard('token')->getProvider()->findByCredentials([
                'email' => $request->email,
            ]);

            // login this user.
            Auth::guard('token')->login($user);

            // revoke all access token first.
            $user->revokeAllAccessTokens();

            // generate with new token.
            $user->token = $user->generateAccessToken($request->email)->raw_token;

            return $this->fractalItem($user, new UserTransformer(), 'user');
        }

        return $this->fail(lang('Auth.failed'), 401)->setStatusCode(401);
    }
}
