<?php

namespace App\Models;
use CodeIgniter\Model;

class ImagenModel extends Model
{
    protected $table = 'imagenes';
    protected $primaryKey = 'id';
    protected $allowedFields = ['usuario_id', 'nombre_archivo', 'ruta_archivo', 'fecha_subida'];

    public function obtenerImagenesPorUsuario($usuarioId)
    {
        return $this->where('usuario_id', $usuarioId)
                    ->orderBy('fecha_subida', 'DESC')
                    ->findAll();
    }

    public function borrarImagen($id, $usuarioId)
    {
        return $this->where(['id' => $id, 'usuario_id' => $usuarioId])->delete();
    }
}
