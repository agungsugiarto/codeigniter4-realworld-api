<?php

namespace Fluent\Auth\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Fluent\Auth\Config\Services;

class TokenFilter implements FilterInterface
{
    /**
     * {@inheritdoc}
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        helper('auth');

        $result = auth('token')->check([
            'token' => $request->getHeaderLine('Authorization'),
        ]);

        if (! $result->isOK()) {
            return Services::response()->setJSON([
                'success' => false,
                'message' => $result->reason(),
            ])->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED);
        }

        auth('token')->login($result->extraInfo());
    }

    /**
     * {@inheritdoc}
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
