<?php 

namespace App\Controllers;

class PagesController 
{
    public function login()
    {
        return view('login', [
            "pageTitle" => "Login",
            "page" => "login"
        ]);
    }

    public function register()
    {
        return view('register', [
            "pageTitle" => "Register",
            "page" => "register"
        ]);
    }

    public function contact()
    {
        return view('contact');
    }
}