<?php

$router->get('', 'PagesController@home');
$router->get('about', 'PagesController@about');
$router->get('contact', 'PagesController@contact');
$router->get('users', 'UsersController@index');

$router->post('users/posts', ['Auth@checkToken'], 'UsersController@getPosts');
$router->post('users/register', 'UsersController@store');
$router->post('users/auth', 'UsersController@authenticate');

$router->post('posts/store', ['Auth@checkToken'], 'PostsController@store');
$router->post('posts/index', ['Auth@checkToken'], 'PostsController@index');