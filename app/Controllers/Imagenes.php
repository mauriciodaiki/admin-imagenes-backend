<?php

namespace App\Controllers;
use App\Models\ImagenModel;
use CodeIgniter\Controller;

class Imagenes extends BaseController
{
    protected $session;
    protected $imagenesModel;

    public function __construct()
    {
        $this->session = session();
        $this->imagenesModel = new ImagenModel();
        helper(['form', 'url']);
    }

    public function index()
    {
        if (!$this->session->has('user_id')) {
            return redirect()->to('/');
        }

        $usuarioId = $this->session->get('user_id');
        $rol = $this->session->get('role');

        $imagenes = ($rol === 'admin') 
            ? $this->imagenesModel->findAll()
            : $this->imagenesModel->obtenerImagenesPorUsuario($usuarioId);

        return view('imagenes/index', ['imagenes' => $imagenes]);
    }

    public function subir()
    {
        if (!$this->session->has('user_id')) {
            return redirect()->to('/');
        }

        $file = $this->request->getFile('imagen');

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $rules = [
                'imagen' => 'uploaded[imagen]|max_size[imagen,2048]|is_image[imagen]'
            ];

            if (!$this->validate($rules)) {
                return redirect()->back()->with('error', 'Archivo no válido o demasiado grande.');
            }

            $nombre = $file->getRandomName();
            $ruta = ROOTPATH . 'public/uploads/' . $nombre;
            $file->move(ROOTPATH . 'public/uploads', $nombre);

            $this->imagenesModel->insert([
                'usuario_id' => $this->session->get('user_id'),
                'nombre_archivo' => $nombre,
                'ruta_archivo' => $ruta
            ]);

            return redirect()->to('/imagenes');
        }

        return redirect()->back()->with('error', 'Error al subir la imagen.');
    }

    public function borrar($id)
    {
        if (!$this->session->has('user_id')) {
            return redirect()->to('/');
        }

        $usuarioId = $this->session->get('user_id');
        $rol = $this->session->get('role');
        $imagen = $this->imagenesModel->find($id);

        if ($imagen && ($imagen['usuario_id'] == $usuarioId || $rol === 'admin')) {
            if (file_exists($imagen['ruta_archivo'])) {
                unlink($imagen['ruta_archivo']);
            }
            $this->imagenesModel->borrarImagen($id, $usuarioId);
        }

        return redirect()->to('/imagenes');
    }
    public function adminPanel()
{
    $usuarioModel = new \App\Models\UserModel();
    $usuarios = $usuarioModel->findAll();

    return view('admin/usuarios', ['usuarios' => $usuarios]);
}

public function eliminarUsuario($id)
{
    $usuarioModel = new \App\Models\UserModel();
    $usuario = $usuarioModel->find($id);

    if ($usuario && $usuario['role'] !== 'admin') {
        $usuarioModel->delete($id);
    }

    return redirect()->to('/admin/usuarios');
}

}
