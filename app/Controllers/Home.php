<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        // Rediriger vers login par défaut
        return redirect()->to('/login');
    }
}
