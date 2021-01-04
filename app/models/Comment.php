<?php 

namespace App\Models;

use App\Core\App;
use App\Core\Model;
use Exception;

class Comment extends Model
{
    public $id, $post_id, $user_id, $content, $created_at, $updated_at;

    protected $table = 'comments';
    protected $model = 'Comment';

    public function save() {
        $data = [
            'user_id' => $this->user_id,
            'post_hash' => $this->post_hash,
            'content' => $this->content
        ];

        if(!App::get('database')->insert($this->table, $data)){
            return false;
        }
        return true;
    }

}
