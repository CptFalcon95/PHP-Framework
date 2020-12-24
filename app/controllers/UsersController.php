<?php

namespace App\Controllers;

use App\Core\{App, Response};

use App\User;

class UsersController 
{
    public function index() {
        $users = App::get('database')->selectAll('users');
        return view('users', ['users' => $users]);
    }

    public function login() {
        if(Authenticate::user(User::get($_POST['email']))) {
            
        }
    }

    public function store() {
        $user = new User(
            $_POST['name'], 
            $_POST['email'], 
            $_POST['password'],
            $_POST['password_repeat']
        );
        if(!$user->validate()) {
            Response::json([
                'success' => 'false', 
                'errors' => $user->getErrors()
            ]);
        }
        if($user->save()) {
            Response::json([
                'success' => 'true', 
                'user' => [
                    'email' => $user->email, 
                    'name' => $user->name
                ]
            ]);
        }
    }
}