<?php 

namespace App\Models;

use App\Core\App;
use App\Core\Model;
use Exception;

class Comment extends Model
{
    public $id, $post_id, $user_id, $content;

    protected $table = 'comments';
    protected $model = 'Comment';

    public function save() {
        $data = [
            'user_id' => $this->user_id,
            'post_id' => $this->post_id,
            'content' => $this->content,
        ];

        if(!App::get('database')->insert($this->table, $data)){
            throw new Exception('Post could not be saved.');
        }
        return true;
    }

}
