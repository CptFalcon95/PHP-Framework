<?php 

namespace App;

use App\Core\{App, Hash};
use App\User\Validator\UserValidator;

class User extends UserValidator
{
    public $name;
    public $email;
    protected $password;
    protected $passwordRepeat;

    public function __construct($name, $email, $password, $passwordRepeat){
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->passwordRepeat = $passwordRepeat;
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
}