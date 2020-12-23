<?php

namespace App\Core\Validator;

use App\Core\App;
use App\User;

class UserValidator extends Validator
{
    private $errors = [];

    public function validate() {
        if($this->exists() == true) {
            array_push($this->errors, "Email already in use.");
        }
        if($this->matchPasswords() != true)
        {
            array_push($this->errors, "Passwords do not match.");
        }
        if($this->regex("password") == false) {
            array_push($this->errors, "Password unsafe.");
        }
        if($this->regex("email") == false) {
            array_push($this->errors, "Invalid email.");
        }
        if(count($this->errors) == 0) {
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