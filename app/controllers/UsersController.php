<?php

namespace App\Controllers;

use App\Core\App;
use App\Core\Response;
use App\Core\UserValidator;

use App\User;

class UsersController 
{
    public function index()
    {
        $users = App::get('database')->selectAll('names');
        return view('users', ['users' => $users]);
    }

    public function store()
    {
        $user = new User(
            $_POST['name'], 
            $_POST['email'], 
            $_POST['password']
        );
        if($user->exists()) {
            Response::json([
                "success" => "false", 
                "message" => "Email already in use"
            ]);
        }
        if($user->save()) {
            Response::json([
                "success" => "true", 
                "user" => [
                    "email" => $user->email, 
                    "name" => $user->name
                ]
            ]);
        }
    }
}