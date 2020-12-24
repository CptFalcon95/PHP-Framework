<?php 

namespace App\Core;

Use App\Core\App;
use ReallySimpleJWT\Token;
use App\User;

class Auth 
{
    public static $JWTtoken;

    public static function user($email, $password) {
        $user = User::get($email);
        $config = App::get('config')['JWT'];
        
        $userId = $user->id;
        $secret = $config['secret'];
        $expiration = $config['expiration'];
        $issuer = $config['issuer'];

        if(password_verify($password, $user->password)) {
            static::$JWTtoken = Token::create($user->id, $secret, $expiration, $issuer);
            return true;
        }
        return false;
    }
}
