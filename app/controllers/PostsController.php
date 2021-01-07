<?php

namespace App\Controllers;

use App\Core\{Response, Token, App, Request};
use App\Models\{Post};

class PostsController
{
    public function index() {
        $posts = (new Post())->getUserPosts(Token::getUserId());
        if (!count($posts)) {
            Response::json([
                "success" => false,
                "msgs"    => App::get('err_msgs')->post->no_posts
            ]);
        }
        Response::json([
            "success" => true,
            "data" => $posts
        ]);
    }

    public function store() {
        if(isset($_POST['content'])) {
            $post = new Post;
            $post->content = $_POST['content'];
            $post->user_id = Token::getUserId();
            if($post->save()) {
                Response::json([
                    "succes" => true
                ]);
            }
        }
        Response::json([
            "succes" => false,
            "msg" => App::get('err_msgs')->post->failed
        ]);
    }

    public function getPost() {
        if(isset($_GET['hash'])) {
            $post = (new Post())->getPostData($_GET['hash']);
            Response::json([
                "succes" => true,
                "post"   => $post
            ]);
        }
    }

    public function wildcardTest() {
        Response::json([
            "success" => true,
            "data"    => Request::get('wildcard_data')
        ]);
    }

    public function otherFunction() {
        dd(Request::get('wildcard_data')->id);
        Response::json([
            "success" => true,
            "data"    => Request::get('wildcard_data'),
            "hash"    => $_GET['hash']
        ]);
    }

    public function anotherFunction() {
        Response::json([
            "success" => true,
        ]);
    }
}