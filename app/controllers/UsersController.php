<?php

namespace App\Controllers;

use App\Core\{App, Response, Token, Hash};
use App\Models\User;

class UsersController 
{
    public function index() {
        $users = App::get('database')->selectAll('users');
        return view('users', ['users' => $users]);
    }

    public function authenticate() {
        $user = (new User())->getByMail($_POST['email']);
        if($user->authenticate($_POST['password'])) {
            Response::json([
                'success' => true,
                'token' => $user->createToken()
            ]);
        } else {
            Response::json([
                'success' => false,
                'msg' => App::get('err_msgs')->login
            ]);
        }
    }

    public function store() {
        $user = new User;
        $user->name = $_POST['name']; 
        $user->email = $_POST['email']; 
        $user->password = $_POST['password'];

        if(!$user->validate()) {
            Response::json([
                'success' => false, 
                'errors' => $user->getErrors()
            ]);
        }

        $user->password = Hash::password($_POST['password']);
        if($user->save()) {
            Response::json([
                'success' => true, 
                'msg' => App::get('succ_msgs')->registered,
                'user' => [
                    'email' => $user->email, 
                    'name' => $user->name,
                    'token' => $user->createToken()
                ]
            ]);
        }
    }
    
    public function getPosts() {
        $user = (new User())->get(Token::getUserId());
        Response::json([
            'success' => true, 
            'data' => $user->posts()
        ]);
    }
}