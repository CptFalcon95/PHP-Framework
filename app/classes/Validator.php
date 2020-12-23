<?php 
namespace App\Core\Validator;

use App\Core\App;

class Validator
{
    protected function regex($type) {
        switch ($type) {
            case 'email':
                return preg_match(App::get('config')['regex']['email'], $this->email);
                break;
            case 'password':
                return preg_match(App::get('config')['regex']['password'], $this->password);
                break;
            default:
                return false;
                break;
        }
    }
}