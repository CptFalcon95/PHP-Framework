<?php 

namespace App\Middleware;

use App\Core\Response;

class Auth
{
    public function loggedIn() {
        if(true) {
            Response::json([
                'error' => 'Not logged in'
            ]);
        }
    }
}
