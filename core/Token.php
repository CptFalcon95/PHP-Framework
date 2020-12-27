<?php 

namespace App\Core;
use App\Core\App;
use ReallySimpleJWT\Token as JWT;

class Token
{
    public static $JWTtoken;

    public static function get() {
        if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
            list($type, $token) = explode(' ', $_SERVER['HTTP_AUTHORIZATION'], 2);
            if (strcasecmp($type, 'Bearer') == 0) {
                return $token;
            }
            return false;
        }
    }

    public static function verify($token = '') {
        if (func_num_args()) {
            $token = func_get_arg(1);
        } else {
            $token = static::get();
        }
        if(static::get() != false) {
            $secret = $_ENV['JWT_SECRET'];
            if(!JWT::validate($token, $secret)) {
                return false;
            }
            return true;
        }
        return false;
    }

    public static function createToken($userId) {
        $secret = $_ENV['JWT_SECRET'];
        // TODO Needs its own config
        // $expiration = $_ENV['JWT_EXPIRATION'];
        $expiration = time() + 60 * 60 * 24 * 60;
        $issuer = $_ENV['JWT_ISSUER'];
        static::$JWTtoken = JWT::create($userId, $secret, $expiration, $issuer);
        return static::$JWTtoken;
    }

    public static function payload($token) {
        return JWT::getPayload($token, $_ENV['JWT_SECRET']);
    }
}