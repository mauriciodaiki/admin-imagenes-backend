<?php
namespace App\Controllers;
use App\Models\UserModel;

class User extends BaseController
{
    protected $allowedMethods = ['login', 'logout'];
    
    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        
        $currentURI = $this->request->getUri()->getPath();
        $allowedRoutes = ['/', '/login', '/logout'];
        
        if (!in_array($currentURI, $allowedRoutes)) {
            if (!session()->get('logged_in')) {
                
                if ($token = $this->request->getCookie('remember_token')) {
                    try {
                        $model = new UserModel();
                        $user = $model->where('remember_token', $token)->first();
                        
                        if ($user) {
                
                            $newToken = bin2hex(random_bytes(32));
                            $model->update($user['id'], ['remember_token' => $newToken]);
                            
                
                            $this->response->setCookie('remember_token', $newToken, [
                                'expires' => 30 * 86400,
                                'path' => '/',
                                'domain' => '',
                                'secure' => false,   
                                'httponly' => true,
                                'samesite' => 'Lax'
                            ]);
                            
                            
                            session()->set([
                                'user_id' => $user['id'],
                                'name' => $user['name'] ?? '',
                                'logged_in' => true
                            ]);
                            
                            log_message('info', 'Autologin exitoso via cookie para usuario ID: '.$user['id']);
                            return;
                        }
                    } catch (\Exception $e) {
                        log_message('error', 'Error en autologin: '.$e->getMessage());
                        $this->response->deleteCookie('remember_token');
                    }
                }
                
                return redirect()->to('/')->with('error', 'Debes iniciar sesión primero');
            }
        }
    }

    public function login()
    {
        $model = new UserModel();
        $login = $this->request->getPost('login');
        $password = $this->request->getPost('password');
        
        $user = $model->where('login', $login)->first();
        
        if ($user && md5($password) === $user['password']) {
            session()->set([
                'user_id' => $user['id'],
                'name' => $user['name'],
                'logged_in' => true
            ]);

            if ($this->request->getPost('remember')) {
                $token = bin2hex(random_bytes(32));
                $model->update($user['id'], ['remember_token' => $token]);
                
                $cookie = new \CodeIgniter\Cookie\Cookie(
                    'remember_token',
                    $token,          
                    [
                        'expires'  => time() + (30 * 86400),
                        'path'     => '/',
                        'domain'   => '',
                        'secure'   => false,  
                        'httponly' => true,
                        'samesite' => 'Lax',
                        'raw'      => false
                    ]
                );
                
                $this->response->setCookie($cookie);
            }

            return redirect()->to('/user')->with('success', 'Bienvenido '.$user['name']);
        }
        
        return redirect()->back()->with('login_error', 'Credenciales incorrectas');
    }
    public function index()
    {
        if(!session()->get('logged_in')) {
            return redirect()->to('/')->with('error', 'Debes iniciar sesión');
        }

        $model = new UserModel();
        $data['users'] = $model->findAll();
        
        return view('header') 
            . view('user/list', $data) 
            . view('footer');
    }

    public function edit($id)
    {
        $model = new UserModel();
        $data['user'] = $model->find($id);

        if(empty($data['user'])) {
            return redirect()->to('/user')->with('error', 'Usuario no encontrado');
        }

        return view('header')
            . view('user/edit', $data)
            . view('footer');
    }

    public function delete($id)
    {
        $model = new UserModel();
        
        if(!$model->find($id)) {
            return redirect()->to('/user')->with('error', 'Usuario no encontrado');
        }

        $model->delete($id);
        return redirect()->to('/user')->with('success', 'Usuario eliminado');
    }

    public function update($id)
    {
        $model = new UserModel();
        
        $rules = [
            'name' => 'required',
            'login' => "required|is_unique[user.login,id,$id]"
        ];

        if($this->validate($rules)) {
            $model->save([
                'id' => $id,
                'name' => $this->request->getPost('name'),
                'login' => $this->request->getPost('login')
            ]);
            return redirect()->to('/user')->with('success', 'Usuario actualizado');
        }

        return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
    }

    public function logout()
    {
        if ($userId = session()->get('user_id')) {
            db_connect()->table('user')
                ->where('id', $userId)
                ->update(['remember_token' => null]);
        }
        
        session()->destroy();
        $this->response->deleteCookie('remember_token');
        
        return redirect()->to('/')->with('success', 'Sesión cerrada correctamente');
    }
}