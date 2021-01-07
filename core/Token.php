<?php 

namespace App\Core;
use ReallySimpleJWT\Token as JWT;
use Ayesh\StatelessCSRF\StatelessCSRF;

class Token
{
    protected $JWTtoken;

    public static function getJWT() {
        if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
            list($type, $token) = explode(' ', $_SERVER['HTTP_AUTHORIZATION'], 2);
            if (strcasecmp($type, 'Bearer') == 0) {
                return $token;
            }
            return false;
        }
    }
    
    public static function createJWT($userId) {
        $secret = $_ENV['JWT_SECRET'];
        $issuer = $_ENV['JWT_ISSUER'];
        $expiration = time() + 60 * 60 * 24 * 60;

        return JWT::create($userId, $secret, $expiration, $issuer);
    }

    public static function payloadJWT($token) {
        return JWT::getPayload($token, $_ENV['JWT_SECRET']);
    }

    public static function getUserIdJWT() {
        $token = static::getJWT();
        if($token) {
            return static::payloadJWT($token)['user_id'];
        }
        return false;
    }

    public static function verifyJWT() {
        $token = (func_num_args()) ? func_get_arg(0) : static::getJWT();
        if($token != false) {
            if(JWT::validate($token, $_ENV['JWT_SECRET'])) {
                return true;
            }
            return false;
        }
        return false;
    }

    public static function verifyCsrfToken($token, $key, $value) {
        $csrf_generator = static::createCSRF($key, $value);
        if($csrf_generator->validate($key, $token)) {
            return true;
        }
        return false;
    }

    public static function createCSRF($key, $value) {
        $csrf_generator = new StatelessCSRF($_ENV['CSRF_KEY']);
        $csrf_generator->setGlueData('ip', $_SERVER['REMOTE_ADDR']);
        $csrf_generator->setGlueData('user-agent', $_SERVER['HTTP_USER_AGENT']);
        $csrf_generator->setGlueData($key, $value);
        $csrf_generator->setGlueData('user', static::getUserIdJWT());
        return $csrf_generator;
    }
}