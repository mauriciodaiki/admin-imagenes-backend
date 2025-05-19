<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class Auth extends BaseController
{
    public function register()
    {
        return view('auth/register');
    }

    public function attemptRegister()
    {
        $validation = \Config\Services::validation();

        $validation->setRules([
            'name'     => 'required',
            'login'    => 'required|is_unique[user.login]',
            'password' => 'required|min_length[5]',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $userModel = new UserModel();

        $userModel->insert([
            'name'     => $this->request->getPost('name'),
            'login'    => $this->request->getPost('login'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
        ]);

        return redirect()->to('/login')->with('success', 'Registro exitoso. Ahora puedes iniciar sesión.');
    }

    public function login()
    {
        helper('url');
        return view('auth/login');
    }

    public function attemptLogin()
{
    $login    = $this->request->getPost('login');
    $password = $this->request->getPost('password');

    $userModel = new UserModel();
    $user      = $userModel->where('login', $login)->first();

    if (!$user || !password_verify($password, $user['password'])) {
        return redirect()->back()->with('error', 'Credenciales incorrectas.')->withInput();
    }

    // Iniciar sesión
    $session = session();
    $session->set([
        'user_id'    => $user['id'],
        'user_name'  => $user['name'],
        'login'      => $user['login'],
        'role'       => $user['role'],
        'isLoggedIn' => true
    ]);

    return redirect()->to('/imagenes');
}

}
