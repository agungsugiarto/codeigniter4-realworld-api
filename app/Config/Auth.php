<?php

namespace Config;

use Fluent\Auth\Adapters\SessionAdapter;
use Fluent\Auth\Adapters\TokenAdapter;
use App\Models\UserModel;

class Auth extends \Fluent\Auth\Config\Auth
{
    /**
     * --------------------------------------------------------------------------
     * Authentication Defaults
     * --------------------------------------------------------------------------
     *
     * This option controls the default authentication "guard" and password
     * reset option for your application. You may change these defaults
     * as required, but they're a perfect start for most applications.
     *
     * @var array
     */
    public $defaults = [
        'guard'    => 'web',
        'provider' => 'users',
        'password' => 'users',
    ];

    /**
     * --------------------------------------------------------------------------
     * Authentication Guards
     * --------------------------------------------------------------------------
     *
     * Next, you may define every authentication adapter for your application.
     * Of course, a great default configuration has been defined for you
     * here which uses session storage and the user provider.
     *
     * All authentication drivers have a user provider. This defines how the
     * users are actually retrieved out of your database or other storage
     * mechanisms used by this application to persist your user's data.
     *
     * Supported: "session", "token"
     *
     * @var array
     */
    public $guards = [
        'web'   => [
            'driver'   => SessionAdapter::class,
            'provider' => 'users',
        ],
        'token' => [
            'driver'   => TokenAdapter::class,
            'provider' => 'users',
        ],
        'api' => [
            'driver'   => 'jwt',
            'provider' => 'users',
        ],
    ];

    /**
     * --------------------------------------------------------------------------
     * User Providers
     * --------------------------------------------------------------------------
     *
     * All authentication drivers have a user provider. This defines how the
     * users are actually retrieved out of your database or other storage
     * mechanisms used by this application to persist your user's data.
     *
     * If you have multiple user tables or models you may configure multiple
     * sources which represent each model / table. These sources may then
     * be assigned to any extra authentication guards you have defined.
     *
     * Supported: "model", "database"
     *
     * @var array
     */
    public $providers = [
        'users'    => [
            'driver' => 'model',
            'table'  => UserModel::class,
        ],
        'database' => [
            'connection' => 'default',
            'driver'     => 'connection',
            'table'      => 'users',
        ],
    ];

    /**
     * --------------------------------------------------------------------------
     * Resetting Passwords
     * --------------------------------------------------------------------------
     *
     * You may specify multiple password reset configurations if you have more
     * than one user table or model in the application and you want to have
     * separate password reset settings based on the specific user types.
     *
     * The expire time is the number of minutes that the reset token should be
     * considered valid. This security feature keeps tokens short-lived so
     * they have less time to be guessed. You may change this as needed.
     *
     * @var array
     */
    public $passwords = [
        'users' => [
            'provider'   => 'users',
            'connection' => 'default',
            'table'      => 'auth_password_resets',
            'expire'     => 60,
            'throttle'   => 60,
        ],
    ];

    /**
     * --------------------------------------------------------------------------
     * Password Confirmation Timeout
     * --------------------------------------------------------------------------
     *
     * Here you may define the amount of seconds before a password confirmation
     * times out and the user is prompted to re-enter their password via the
     * confirmation screen. By default, the timeout lasts for three hours.
     *
     * @var int
     */
    public $passwordTimeout = 3 * HOUR;

    /**
     * --------------------------------------------------------------------------
     * Redirect Authenticated
     * --------------------------------------------------------------------------
     *
     * Here you may define the redirect if authenticated success.
     *
     * @var string
     */
    public $home = 'dashboard';
}
