<?php

namespace App\Filters;

use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Config\Services;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class ThrottleFilter implements FilterInterface
{
    use ResponseTrait;

    /** @var \CodeIgniter\Throttle\Throttler */
    protected $throttler;

    /** @var \CodeIgniter\HTTP\Response */
    protected $response;

    public function __construct()
    {
        $this->throttler = Services::throttler();
        $this->response = Services::response();
    }

    /**
     * {@inheritdoc}
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        if ($this->throttler->check($request->getIPAddress(), 60, MINUTE) === false) {
            return $this->fail('You submitted over 60 requests within a minute.');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
