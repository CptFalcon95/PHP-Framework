<?php

$router->get('', 'PagesController@login');
$router->get('register', 'PagesController@register');

$router->get('api/posts/index', ['Auth@checkToken'], 'PostsController@index');
$router->get('api/p/{hash}', ['Auth@checkToken'], 'PostsController@getPost');

$router->post('api/user/posts', ['Auth@checkToken'], 'UsersController@getPosts');
$router->post('api/user/register', 'UsersController@store');
$router->post('api/user/auth', 'UsersController@authenticate');

$router->post('api/post/store', ['Auth@checkToken'], 'PostsController@store');
$router->post('api/comment/store', ['Auth@checkToken'], 'CommentsController@store');

$router->get('u/{id}', 'PagesController@profile');
$router->get('p/{hash}', 'PostsController@getPost');





