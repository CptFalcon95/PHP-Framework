<?php 

namespace App;

use App\Core\{App, Hash, Auth, Token};
use App\User\Validator\UserValidator;

class User extends UserValidator
{
    public $name;
    public $email;
    protected $password;

    public function __construct($name, $email, $password){
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

    public function token() {
        $user = static::getByMail($this->email);
        return Token::createToken($user->id);
    }

    public static function get($id) {
        return App::get('database')->selectOneClass('App\Models\UserModel','users', ['id', 'name', 'email', 'password'], 'id', $id);
    }

    public static function getByMail($email) {
        return App::get('database')->selectOne('users', ['id', 'password', 'email'], 'email', $email);
    }
}