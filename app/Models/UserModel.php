<?php
namespace App\Models;
use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'user';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'login', 'password', 'remember_token', 'role'];

    
    public function getUserByToken($token)
    {
        return $this->where('remember_token', $token)->first();
    }
    
    protected function beforeInsert(array $data)
    {
    if(isset($data['data']['password'])) {
        $data['data']['password'] = md5($data['data']['password']);
    }
    return $data;
}
    
    protected function beforeUpdate(array $data)
{
    if(isset($data['data']['password'])) {
        $data['data']['password'] = md5($data['data']['password']);
    }
    return $data;
}
    
    protected function passwordHash(array $data)
    {
        if(isset($data['data']['password']))
            $data['data']['password'] = md5($data['data']['password']);
        
        return $data;
    }
    
    public function login($data)
    {
        $data['password'] = md5($data['password']);
        return $this->asArray()->where($data)->first();
    }
    public function findByLogin($login)
    {
        return $this->where('login', $login)->first();
    }
}