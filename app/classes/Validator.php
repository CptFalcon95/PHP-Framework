<?php 
namespace App\Core\Validator;

class Validator
{
    private $emailRegex = '/^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i';
    private $passwordRegex = '/[A-Za-z0-9_-]+/';

    protected function regex($type) {
        switch ($type) {
            case 'email':
                return preg_match($this->emailRegex, $this->email);
                break;
            case 'password':
                return preg_match($this->passwordRegex, $this->password);
                break;
            default:
                return false;
                break;
        }
    }
}