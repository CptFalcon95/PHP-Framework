<?php 

namespace App\Models;

use App\Core\{App, Token};
use App\Core\Model;
use Exception;

class Post extends Model
{
    public $id, $user_id, $content, $updated_at, $created_at;

    protected $table = 'posts';
    protected $model = 'Post';

    public function save() {
        $data = [
            'user_id' => Token::getUserId(),
            'content' => $this->content,
        ];

        if(! App::get('database')->insert($this->table, $data)){
            throw new Exception('Post could not be saved.');
        }
        return true;
    }

    public function getAll() {
        return App::get('database')->selectAllClass("App\\Models\\".$this->model, $this->table, ['*'], 'user_id', Token::getUserId());
    }

}
