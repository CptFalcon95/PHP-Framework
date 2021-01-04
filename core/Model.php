<?php 

namespace App\Core;

use App\Core\{App, Validator};

class Model extends Validator
{
    
    protected function trim($object) {
        $data = $object;
        return array_map(function($data) {
            unset($data->errors);
            foreach($data as $key => $value) {
                if($value === null) {
                    unset($data->$key);
                } 
            }
            return $data;
        }, $data);
    }

    public function count($key, $value) {
        return App::get('database')->count($this->table, $key, $value);
    }   
   
    public function get($id) {
        return App::get('database')->selectOneModel($this->model, $this->table, ['*'], 'id', $id);
    }

    public function getByMail($email) {
        return App::get('database')->selectOneModel($this->model, $this->table, ['*'], 'email', $email);
    }
}