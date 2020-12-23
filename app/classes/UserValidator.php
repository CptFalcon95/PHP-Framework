<?php

namespace App\Core\Validator;

use App\Core\App;
use App\User;

class UserValidator extends Validator
{
    private $errors = [
        'email' => [],
        'password' => []
    ];

    public function validate() {
        $errorMsgs = App::get('config')['errors'];
        if($this->exists() == true) {
            $this->errors['email']['exists'] = $errorMsgs['email']['exists'];
        }
        if($this->matchPasswords() != true) {
            $this->errors['password']['no_match'] = $errorMsgs['password']['no_match'];
        }
        if($this->regex('password') == false) {
            $this->errors['password']['unsafe'] = $errorMsgs['password']['unsafe'];
        }
        if($this->regex('email') == false) {
            $this->errors['email']['invalid'] = $errorMsgs['email']['invalid'];
        }
        if(empty($this->errors['email']) && empty($this->errors['password'])) {
            return true;
        }
        return false;   
    }

    public function getErrors() {
        return $this->errors;
    }

    private function matchPasswords() {
        return $this->password === $this->passwordRepeat;
    }

    private function exists()  {
        $getUser = App::get('database')->selectOne('users', ['name'], 'email', $this->email);
        if(!$getUser) {
            return false;
        }
        return true;
    }
}