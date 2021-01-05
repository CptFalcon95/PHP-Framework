<?php

namespace App\Controllers;

use App\Core\{Response, Token, App};
use App\Models\{Post, Comment, User};

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
}