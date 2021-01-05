<?php 

namespace App\Models;

use App\Core\{App, Hash, Token};
use App\Core\Model;
use App\Models\User;

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
    

    // Think im better of constructing an object myself instead of loading DB data into model and then unsetting
    // all the data I dont want to send.
    public function getPostData($hash) {
        $db = App::get('database');
        $post = $db->selectOne($this->table, ['id', 'user_id', 'hash', 'content', 'created_at', 'updated_at'], 'hash', $hash);
        $user = $db->selectOne('users', ['*'], 'id', $post->user_id);
        $postData = [
            'user' => [
                'name' => $user->name,
                'image_url' => "Soon...",
                'profile_url' => "Soon..."
            ]
            ];
        dd($user);
        $post->csrf = Token::createCommentToken($post->hash);
        $post->user = (new User())->get($post->user_id);

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
