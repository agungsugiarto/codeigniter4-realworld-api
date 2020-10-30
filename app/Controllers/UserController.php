<?php

namespace App\Controllers;

use App\Entities\UserEntity;
use App\Models\UserModel;
use App\Transformers\UserTransformer;
use CodeIgniter\API\ResponseTrait;
use Config\Services;

class UserController extends Controller
{
    use ResponseTrait;

    /** @var \App\Models\UserModel */
    protected $user;

    /** @var \App\Entities\UserEntity */
    protected $entity;

    /**
     * UserController constructor.
     *
     * @return void
     */
    public function __construct()
    {
        $this->entity = new UserEntity();
        $this->user = new UserModel();
    }

    /**
     * Get the authenticated user.
     *
     * @return \CodeIgniter\HTTP\Response
     */
    public function index()
    {
        $user = Services::auth()->user();

        return $this->fractalItem($user, new UserTransformer(), 'user');
    }

    /**
     * Update the authenticated user and return the user if successful.
     *
     * @return \CodeIgniter\HTTP\Response
     */
    public function update()
    {
        $user = Services::auth()->user();

        if (is_null($user)) {
            return $this->fail('User not found');
        }
        
        $rules = [
            'username' => "if_exist|is_unique[users.username,username,{$user->username}]",
            'email'    => "if_exist|valid_email|is_unique[users.email,email,{$user->email}]",
            'bio'      => "if_exist",
            'image'    => "if_exist|valid_url",
        ];

        if (! $this->validate($rules)) {
            return $this->parseError(
                $this->validator->getErrors()
            );
        }

        $this->user->update($user->id, $this->request->getRawInput());

        return $this->fractalItem($this->user->find($user->id), new UserTransformer());
    }
}
