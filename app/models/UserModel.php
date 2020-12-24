<?php 

namespace App\Models;

class UserModel
{
    private $id, $name, $email, $password;

    public function posts() {
        return $this->id;
    }
}
