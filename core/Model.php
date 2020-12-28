<?php 

namespace App\Core;

use App\Core\{App, Validator};


class Model extends Validator
{
    
    public function get($id) {
        return App::get('database')->selectOneClass("App\\Models\\".$this->model, $this->table, ['*'], 'id', $id);
    }

    public function getByMail($email) {
        return App::get('database')->selectOneClass("App\\Models\\".$this->model, $this->table, ['*'], 'email', $email);
    }
}