<?php

namespace App\Notifications;

use CodeIgniter\Config\Services;
use CodeIgniter\Email\Email;
use CodeIgniter\I18n\Time;

class VerificationNotification
{
    /** @var string */
    protected $email;

    /** @var Email */
    protected $service;

    /**
     * Instance verification notification.
     */
    public function __construct(string $email)
    {
        $this->email   = $email;
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
            ->setSubject('Verify Email Notification')
            ->setMessage(view('Email\verify_email', [
                'hash'      => sha1($this->email),
                'expire'    => Time::now()->addMinutes(config('Auth')->passwords[config('Auth')->defaults['password']]['expire'])->getTimestamp(),
                'signature' => hash_hmac('sha256', $this->email, config('Encryption')->key),
            ]))
            ->setMailType('html')
            ->send();
    }
}
