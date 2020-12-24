<?php

namespace App\Controllers;

use App\Core\{App, Response, Auth};
use ReallySimpleJWT\Token;
use App\User;

class UsersController 
{
    public function index() {
        $users = App::get('database')->selectAll('users');
        return view('users', ['users' => $users]);
    }

    public function authenticate() {
        if(Auth::user($_POST['email'], $_POST['password'])) {
            Response::json([
                'success' => true,
                'token' => Auth::$JWTtoken
            ]);
        } else {
            Response::json([
                'success' => false,
                'msg' => App::get('config')['errors']['login']['failed']
            ]);
        }
    }

    public function store() {
        $user = new User(
            $_POST['name'], 
            $_POST['email'], 
            $_POST['password'],
        );
        if(!$user->validate()) {
            Response::json([
                'success' => false, 
                'errors' => $user->getErrors()
            ]);
        }
        if($user->save()) {
            Response::json([
                'success' => true, 
                'user' => [
                    'email' => $user->email, 
                    'name' => $user->name,
                    'token' => $user->token()
                ]
            ]);
        }
    }
    
    public function getPosts() {
        Response::json([
            'success' => true, 
            'data' => User::get(Auth::getId())->posts()
        ]);
    }
}