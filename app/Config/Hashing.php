<?php

namespace Config;

class Hashing extends \Fluent\Auth\Config\Hashing
{
    /**
     * --------------------------------------------------------------------------
     * Default Hash Driver
     * --------------------------------------------------------------------------
     *
     * This option controls the default hash driver that will be used to hash
     * passwords for your application. By default, the bcrypt algorithm is
     * used; however, you remain free to modify this option if you wish.
     *
     * Supported: "bcrypt", "argon", "argon2id"
     *
     * @var string
     */
    public $driver = 'bcrypt';

    /**
     * --------------------------------------------------------------------------
     * Bcrypt Options
     * --------------------------------------------------------------------------
     *
     * Here you may specify the configuration options that should be used when
     * passwords are hashed using the Bcrypt algorithm. This will allow you
     * to control the amount of time it takes to hash the given password.
     *
     * @var array
     */
    public $bcrypt = [
        'rounds' => 10,
    ];

    /**
     * --------------------------------------------------------------------------
     * Argon Options
     * --------------------------------------------------------------------------
     *
     * Here you may specify the configuration options that should be used when
     * passwords are hashed using the Argon algorithm. These will allow you
     * to control the amount of time it takes to hash the given password.
     *
     * @var array
     */
    public $argon = [
        'memory'  => 1024,
        'threads' => 2,
        'time'    => 2,
    ];
}
