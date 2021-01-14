<?php 

namespace App\Controllers;
use App\Core\App;

class PagesController 
{
    public function login()
    {
        return view('guest/login', [
            "pageTitle" => "Login",
            "page" => "login"
        ]);
    }

    public function register()
    {
        return view('guest/register', [
            "pageTitle" => "Register",
            "page" => "register"
        ]);
    }

    public function profile()
    {
        return view('user_profile', [
            "pageTitle" => "Profile",
        ]);
    }
}