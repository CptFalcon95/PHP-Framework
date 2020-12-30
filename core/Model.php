<?php 

namespace App\Core;

use App\Core\{App, Validator};

class Model extends Validator
{

    protected function trimErrors($object) {
        $data = $object;
        return array_map(function($data) {
            unset($data->errors);
            return $data;
        }, $data );
    }
   
    public function get($id) {
        return App::get('database')->selectOneModel($this->model, $this->table, ['*'], 'id', $id);
    }

    public function getByMail($email) {
        return App::get('database')->selectOneModel($this->model, $this->table, ['*'], 'email', $email);
    }
}