<?php 

namespace App\Controllers;

class PagesController 
{
    public function home()
    {
        return view('index');
    }

    public function about()
    {            // TODO redirect to somewhere
        return view('about');
    }

    public function contact()
    {
        return view('contact');
    }
}