<?php

namespace App\Filters;

use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Firebase\JWT\JWT;

class AuthenticationFilter implements FilterInterface
{
    use ResponseTrait;

    /** @var \CodeIgniter\HTTP\Response */
    protected $response;

    public function __construct()
    {
        $this->response = service('response');
    }

    /**
     * {@inheritdoc}
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        if ($request->hasHeader('Authorization') === false) {
            return $this->fail('Missing Authorization header');
        }

        $header = $request->getHeaderLine('Authorization');
        $token = trim((string) \preg_replace('/^(?:\s+)?Token\s/', '', $header));

        try {
            JWT::decode($token, config('Encryption')->key, ['HS256']);
        } catch (\Exception $e) {
            return $this->fail($e->getMessage());
        }
    }

    /**
     * {@inheritdoc}
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
