<?php 

namespace App\Core;
use ReallySimpleJWT\Token as JWT;
use Ayesh\StatelessCSRF\StatelessCSRF;

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

    public static function verify() {
        $token = (func_num_args()) ? func_get_arg(0) : static::get();
        if($token != false) {
            if(JWT::validate($token, $_ENV['JWT_SECRET'])) {
                return true;
            }
            return false;
        }
        return false;
    }

    public static function createCommentToken($post_hash) {
        $csrf_generator = new StatelessCSRF($_ENV['CSRF_KEY']);
        $csrf_generator->setGlueData('ip', $_SERVER['REMOTE_ADDR']);
        $csrf_generator->setGlueData('user-agent', $_SERVER['HTTP_USER_AGENT']);
        $csrf_generator->setGlueData('post', $post_hash);
        $csrf_generator->setGlueData('user', static::getUserId());
        // Expires in an hour.
        return $csrf_generator->getToken('unique-id-for-key', time() + 3600);
    }

    public static function create($userId) {
        $secret = $_ENV['JWT_SECRET'];
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
            return static::payload($token)['user_id'];
        }
        return false;
    }

    private static function customPayload($payload) {
        return JWT::customPayload($payload, $_ENV['JWT_SECRET']);
    }
}