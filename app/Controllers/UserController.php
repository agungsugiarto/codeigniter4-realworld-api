<?php

namespace App\Controllers;

use App\Entities\UserEntity;
use App\Models\UserModel;
use App\Transformers\UserTransformer;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Database\Exceptions\DatabaseException;
use Exception;

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
        $user = auth('token')->user();

        return $this->fractalItem($user, new UserTransformer(), 'user');
    }

    /**
     * Update the authenticated user and return the user if successful.
     *
     * @return \CodeIgniter\HTTP\Response
     */
    public function update()
    {
        $user = auth('token')->user();

        if (is_null($user)) {
            return $this->fail('User not found');
        }
        
        $rules = [
            'username' => "if_exist|alpha_numeric|is_unique[users.username,username,{$user->username}]",
            'email'    => "if_exist|valid_email|is_unique[users.email,email,{$user->email}]",
            'bio'      => "if_exist|min_length[5]",
            'image'    => "if_exist|valid_url",
            'password' => "if_exist|min_lenght[5]"
        ];

        if (! $this->validate($rules)) {
            return $this->parseError(
                $this->validator->getErrors()
            );
        }

        try {
            $this->user->update($user->id, new UserEntity($this->request->getRawInput()));
        } catch (Exception $e) {
            return $this->fail($e->getMessage());
        }

        return $this->fractalItem($this->user->find($user->id), new UserTransformer());
    }
}
