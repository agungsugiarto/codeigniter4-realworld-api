<?php

namespace App\Libraries\Auth;

use App\Entities\UserEntity;
use App\Models\UserModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\I18n\Time;
use Firebase\JWT\JWT;

class AuthenticationService
{
    use ResponseTrait;

    const SUBJECT_IDENTIFIER = 'username';

    /** @var \App\Models\UserModel */
    protected $user;

    /** @var \CodeIgniter\HTTP\IncomingRequest */
    protected $request;

    /** @var \CodeIgniter\HTTP\Response */
    protected $response;

    /**
     * Authentication service constructor.
     */
    public function __construct()
    {
        $this->user = new UserModel();
        $this->request = service('request');
        $this->response = service('response');
    }

    /**
     * Generate a new JWT Token.
     *
     * @param \App\Entities\UserEntity $user
     * @return string
     */
    public function generateToken(UserEntity $user)
    {
        $payload = [
            'iat' => Time::now()->getTimestamp(),
            'exp' => Time::now()->addHours(2)->getTimestamp(),
            'jti' => base64_encode(random_bytes(16)),
            'iss' => config('App')->baseURL,
            'sub' => $user->{static::SUBJECT_IDENTIFIER},
        ];
        
        return JWT::encode($payload, config('Encryption')->key, 'HS256');
    }

    /**
     * Attempt to find the user based on email and verify password.
     *
     * @param mixed $email
     * @param mixed $password
     * @return bool|\App\Models\UserModel
     */
    public function attempt($email, $password)
    {
        if (! $user = $this->user->where('email', $email)->first()) {
            return false;
        }

        if (password_verify($password, $user->password)) {
            $this->user
                ->where('email', $user->email)
                ->set(['token' => $this->generateToken($user)])
                ->update();
                
            return $this->user->where('email', $email)->first();
        }

        return false;
    }

    /**
     * Retrive a user by the JWT Token from the request.
     *
     * @return \App\Entities\UserEntity|null
     */
    public function user()
    {
        if ($this->request->hasHeader('Authorization')) {
            $header = $this->request->getServer('HTTP_AUTHORIZATION');
            $token = \trim((string) \preg_replace('/^(?:\s+)?Token\s/', '', $header));

            try {
                $docoded = JWT::decode($token, config('encryption')->key, ['HS256']);
            } catch (\Exception $e) {
                return null;
            }

            if (! $user = $this->user->where(static::SUBJECT_IDENTIFIER, $docoded->sub)->first()) {
                return null;
            }
            
            return $user;
        }

        return null;
    }
}
