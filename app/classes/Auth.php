<?php 

namespace App\Core;

Use App\Core\App;
use ReallySimpleJWT\Token;
use App\User;

class Auth 
{
    public static $JWTtoken;

    public static function user($email, $password) {
        $user = User::getByMail($email);
        if(password_verify($password, $user->password)) {
            static::createToken($user);
            return true;
        }
        return false;
    }

    public static function createToken($user) {
        $config = App::get('config')['JWT'];
        $userId = $user->id;
        $secret = $config['secret'];
        $expiration = $config['expiration'];
        $issuer = $config['issuer'];

        static::$JWTtoken = Token::create($user->id, $secret, $expiration, $issuer);
        return static::$JWTtoken;
    }

    public static function getId() {
        return Token::getPayload($_POST['token'], App::get('config')['JWT']['secret'])["user_id"];
    }
}
