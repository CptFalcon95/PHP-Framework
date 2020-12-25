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

    public static function check($token = '') {
        if (func_num_args()) {
            $token = func_get_arg(1);
        } else {
            $token = static::get();
        }
        if(static::get() != false) {
            $secret = App::get('config')['JWT']['secret'];
            if(!JWT::validate($token, $secret)) {
                return false;
            }
            return true;
        }
        return false;
    }

    public static function createToken($userId) {
        $config = App::get('config')['JWT'];
        $secret = $config['secret'];
        $expiration = $config['expiration'];
        $issuer = $config['issuer'];
        static::$JWTtoken = JWT::create($userId, $secret, $expiration, $issuer);
        return static::$JWTtoken;
    }

    public static function payload($token) {
        return JWT::getPayload($token, App::get('config')['JWT']['secret'])["user_id"];
    }
}