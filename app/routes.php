<?php

$router->get('', 'PagesController@login');
$router->get('register', 'PagesController@register');
$router->get('about', 'PagesController@about');
$router->get('contact', 'PagesController@contact');
$router->get('users', 'UsersController@index');

$router->post('users/posts', ['Auth@checkToken'], 'UsersController@getPosts');
$router->post('users/register', 'UsersController@store');
$router->post('users/auth', 'UsersController@authenticate');

$router->post('posts/store', ['Auth@checkToken'], 'PostsController@store');
$router->post('comments/store', 'CommentsController@store');
$router->get('posts/index', ['Auth@checkToken'], 'PostsController@index');
$router->get('p', ['Auth@checkToken'], 'PostsController@getPost');