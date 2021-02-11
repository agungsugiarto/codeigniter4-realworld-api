<?php

namespace App\Controllers;

class Home extends Controller
{
    public function index()
    {
        return $this->response->setJSON([
            'welcome' => 'CodeIgniter v' . \CodeIgniter\CodeIgniter::CI_VERSION
        ]);
    }
}
