<?php 

namespace App;

use App\Core\App;
use App\Core\Hash;

class User
{
    public $name;
    public $email;
    protected $errors = [];
    protected $password;

    public function __construct($name, $email, $password) {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }

    public function save() {
        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::password($this->password)
        ];
        if(! App::get('database')->insert('users', $data)){
            throw new Exception('User could not be saved.');
        }
        return true;
    }

    private function checkEmail()  {

    }
}