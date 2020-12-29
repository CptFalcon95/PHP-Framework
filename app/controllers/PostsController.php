<?php

namespace App\Controllers;

use App\Core\{Response};
use App\Models\Post;

class PostsController
{
    public function index() {
        $posts = array_map(function($post) {
            // FIXME
            // $errors array is redundant in this context, its inherited from the validator class.
            // Within this context validation errors are redudant -
            // because data is returned instead of POSTed so it's already validated.
            unset($post->errors);
            return $post;
        }, (new Post())->getAll());
        Response::json([
            "data" => $posts
        ]);
    }

    public function store() {
        $post = new Post;
        $post->content = $_POST['content'];
        if($post->save()) {
            Response::json([
                "succes" => true
            ]);
        }
        Response::json([
            "succes" => false
        ]);
    }
}