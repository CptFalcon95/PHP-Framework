<?php

namespace App\Controllers;

use App\Core\{Response, Token, App};
use App\Models\{Comment};

class CommentsController
{

    public function store() {
        if(isset($_POST['content'], $_POST['post_hash'], $_POST['post_token'])) {
            // TODO Token is probably invalid need to check the custom token
            if(!Token::verifyCsrfToken($_POST['post_token'], $_POST['post_hash'])) {
                Response::json([
                    "succes" => false,
                    "msg" => App::get('err_msgs')->comment->failed
                ]);
            }
            $comment = new Comment;
            $comment->post_hash = $_POST['post_hash'];
            $comment->user_id   = Token::getUserId();
            $comment->content   = $_POST['content'];
            if($comment->save()) {
                Response::json([
                    "succes" => true,
                    "msg" => App::get('succ_msgs')->comment->success
                ]);
            }
        }
        Response::json([
            "succes" => false,
            "msg" => App::get('err_msgs')->comment->failed
        ]);
    }
}