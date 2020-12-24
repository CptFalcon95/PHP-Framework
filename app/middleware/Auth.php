<?php 

namespace App\Middleware;

use App\Core\{App, Response};
use ReallySimpleJWT\Token;

class Auth
{
    public function checkToken() {
        if(isset($_POST['token'])) {
            $secret = App::get('config')['JWT']['secret'];
            
            if(!Token::validate($_POST['token'], $secret)) {
                Response::json([
                    'success' => false,
                    'errors' => 'Token denied.'
                ]);
            }
            return;
        }
        Response::json([
            'success' => false,
            'errors' => 'No token.'
        ]);
    }
}
