<?php 

namespace App\Core;

Use App\Core\{App, Token};

use App\User;

class Auth 
{
    public static function user($email, $password) {
        $user = User::getByMail($email);
        if(password_verify($password, $user->password)) {
            Token::createToken($user->id);
            return true;
        }
        return false;
    }

    public static function getId() {
        $token = Token::get();
        if(!$token) {
            return false;
        }
        return Token::payload($token)['user_id'];
    }
}
