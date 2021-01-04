<?php 

namespace App\Models;

use App\Core\{App, Hash};
use App\Core\Model;
use Exception;

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
            throw new Exception('Post could not be saved.');
        }
        return true;
    }

    public function getUserPosts($user_id) {
        $posts = App::get('database')->selectAllModel($this->model, $this->table, ['*'], 'user_id', $user_id);
        return $this->trimErrors($posts);
    }

}
