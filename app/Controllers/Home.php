<?php

namespace App\Controllers;

class Home extends Controller
{
    public function index()
    {
        // return $this->response->setJSON([
        //     'welcome' => 'CodeIgniter v' . \CodeIgniter\CodeIgniter::CI_VERSION
        // ]);

        return view('welcome_message');
    }

    public function dashboard()
    {
        return view('dashboard');
    }

    public function confirm()
    {
        return 'granted password';
    }
}
