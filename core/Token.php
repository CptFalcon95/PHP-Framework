<?php 

namespace App\Core;
use ReallySimpleJWT\Token as JWT;

class Token
{
    protected $JWTtoken;

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
        $token = (func_num_args()) ? func_get_arg(1) : static::get();
        if($token != false) {
            if(JWT::validate($token, $_ENV['JWT_SECRET'])) {
                return true;
            }
            return false;
        }
        return false;
    }

    public static function create($userId) {
        $secret = $_ENV['JWT_SECRET'];
        // TODO Needs its own config
        // $expiration = $_ENV['JWT_EXPIRATION'];
        $expiration = time() + 60 * 60 * 24 * 60;
        $issuer = $_ENV['JWT_ISSUER'];
        return JWT::create($userId, $secret, $expiration, $issuer);
    }

    public static function payload($token) {
        return JWT::getPayload($token, $_ENV['JWT_SECRET']);
    }

    public static function getUserId() {
        $token = static::get();
        if($token) {
            return static::payload($token)['user_id'];;
        }
        return false;
    }
}