<?php 

namespace App\Models;

use App\Core\{App, Token};
use App\Core\Model;
use Exception;

class User extends Model
{
    public $id, $name, $email, $password;

    protected $table = 'users';
    protected $model = 'User';

    public function save() {
        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password
        ];

        if(! App::get('database')->insert($this->table, $data)){
            throw new Exception('User could not be saved.');
        }
        return true;
    }

    public function authenticate($email, $password) {
        $user = $this->getByMail($email);
        if(password_verify($password, $user->password)) {
            return true;
        }
        return false;
    }

    public function createToken() {
        $user = $this->getByMail($this->email);
        return Token::create($user->id);
    }

    public function posts() {
        return $this->password;
    }

    public function validate() {
        $errMsgs = App::get('err_msgs');
        if($this->exists() == true) {
            $this->errors['email']['exists'] = $errMsgs->email->exists;
        }
        if($this->matchPasswords() == false) {
            $this->errors['password']['no_match'] = $errMsgs->password->no_match;
        }
        if($this->regex('password') == false) {
            $this->errors['password']['unsafe'] = $errMsgs->password->unsafe;
        }
        if($this->regex('email') == false) {
            $this->errors['email']['invalid'] = $errMsgs->email->invalid;
        }
        if(empty($this->errors['email']) && empty($this->errors['password'])) {
            return true;
        }
        return false;   
    }

    private function matchPasswords() {
        if(isset($_POST['password_repeat'])) {
            return $this->password === $_POST['password_repeat'];
        }
        return false;
    }

    private function exists()  {
        $getUser = App::get('database')->selectOne('users', ['name'], 'email', $this->email);
        if(!$getUser) {
            return false;
        }
        return true;
    }


}
