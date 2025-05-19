<?php
namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        return view('header') . view('auth/login') . view('footer');
    }
}