<?php 

namespace App\Middleware;

use App\Core\{App, Response, Token};

class Auth
{
    public function checkToken() {
        if(!isset($_SERVER['HTTP_AUTHORIZATION'])) {
            Response::json([
                'success' => false,
                'errors' => 'No token.'
            ]);
        }
        if(!Token::verifyJWT()) {
            Response::json([
                'success' => false,
                'errors' => 'Token denied.'
            ]);
        }
        return;
    }
}
