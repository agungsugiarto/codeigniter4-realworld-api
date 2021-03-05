<?php

namespace App\Notifications;

use CodeIgniter\Config\Services;
use CodeIgniter\Email\Email;

class ResetPasswordNotification
{
    /** @var string */
    protected $email;

    /** @var string */
    protected $token;

    /** @var Email */
    protected $service;

    /**
     * Instance verification notification.
     */
    public function __construct(string $email, string $token)
    {
        $this->email   = $email;
        $this->token   = $token;
        $this->service = Services::email();
    }

    /**
     * Sending email verification.
     *
     * @return bool
     */
    public function send()
    {
        return $this->service
            ->setTo($this->email)
            ->setSubject("Reset Password Notification")
            ->setMessage(view('Email\reset_email', [
                'token'  => $this->token,
                'email'  => $this->email,
                'expire' => config('Auth')->passwords[config('Auth')->defaults['password']]['expire'],
            ]))
            ->setMailType('html')
            ->send();
    }
}
