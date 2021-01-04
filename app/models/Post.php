<?php 

namespace App\Models;

use App\Core\{App, Hash, Token};
use App\Core\Model;

class Post extends Model
{
    public $id, $user_id, $hash, $content, $updated_at, $created_at;

    protected $table = 'posts';
    protected $model = 'Post';

    public function save() {
        $data = [
            'user_id' => $this->user_id,
            'content' => $this->content,
            'hash'    => Hash::randomString(16)
        ];

        if(!App::get('database')->insert($this->table, $data)){
            return false;
        }
        return true;
    }

    // public function getByHash($hash) {
    //     $post = App::get('database')->selectOneModel($this->model, $this->table, ['*'], 'hash', $hash);
    //     return $this->trimErrors($post);
    // }

    public function getPost($hash) {
        $post = App::get('database')->selectOneModel($this->model, $this->table, ['user_id', 'hash', 'content', 'created_at', 'updated_at'], 'hash', $hash);
        $post->token = Token::createCommentToken($post->hash);
        unset($post->errors, $post->id);
        return $post;
    }

    public function getUserPosts($user_id) {
        $posts = App::get('database')->selectAllModel($this->model, $this->table, ['user_id', 'hash', 'content', 'created_at', 'updated_at'], 'user_id', $user_id);
        $posts = $this->trim($posts);
        array_map(function($post) {
            $post->commentCount = (new Comment())->count('hash', $post->hash);
        }, $posts);
        return $posts;
    }

}
