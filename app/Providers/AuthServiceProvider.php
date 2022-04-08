<?php

namespace App\Providers;

use Config\Services;
use Fluent\JWTAuth\JWTGuard;
use Fluent\Auth\Facades\Auth;
use Fluent\Auth\AbstractServiceProvider;

class AuthServiceProvider extends AbstractServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public static function register()
    {
        Auth::extend(JWTGuard::class, function ($auth, $name, array $config) {
            return new JWTGuard(
                Services::getSharedInstance('jwt'),
                Services::getSharedInstance('request'),
                $auth->createUserProvider($config['provider']),
            );
        });
    }
}
