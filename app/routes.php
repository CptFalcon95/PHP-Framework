<?php

$router->get('', 'PagesController@home');
$router->get('about', 'PagesController@about');
$router->get('contact', 'PagesController@contact');
$router->get('users', ['Auth@loggedIn'] ,'UsersController@index');

$router->post('users','UsersController@store');
$router->post('users/auth', 'UsersController@authenticate');