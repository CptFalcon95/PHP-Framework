<?php 

namespace App\Models;

use App\Core\{App, Hash, Token};
use App\Core\Model;
use App\Models\Comment;

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
    
    // This data will sho
    public function getPostData($hash) {
        $db = App::get('database');
        $post = $db->selectOne($this->table, ['id', 'user_id', 'content', 'updated_at'], 'hash', $hash);
        $user = $db->selectOne('users', ['name'], 'id', $post->user_id);
        if($user) {
            $postData = [
                'user' => [
                    'name'        => $user->name,
                    'image_url'   => "Soon...",
                    'profile_url' => "Soon..."
                ],
                'content'       => $post->content,
                'hash'          => $hash,
                'updated_at'    => $post->updated_at,
                'comment_count' => $this->getCommentCount($hash),
                'likes'         => $this->getLikesCount($hash),
                'csrf'          => $this->createCsrfToken($hash)
            ];
    
            return $postData;
        }
        return false;
    }

    public static function createCsrfToken($post_hash) {
        $csrf_generator = Token::createCSRF('post_hash', $post_hash);
        // Expires in an hour.
        return $csrf_generator->getToken('post_hash', time() + 3600);
    }

    public static function verifyCsrfToken($token, $post_hash) {
        if(Token::verifyCsrfToken($token, 'post_hash', $post_hash)) {
            return true;
        }
        return false;
    }

    private function getCommentCount($hash) {

    }

    private function getLikesCount($hash) {

    }

    // This data will show on the user's profile timeline, 
    // only posts of the specified user will be shown here
    public function getUserPosts($user_id) {
        $posts = App::get('database')->selectAllModel($this->model, $this->table, ['hash','content', 'created_at', 'updated_at'], 'user_id', $user_id);
        $posts = array_map(function($post) {
            $post->commentCount = (new Comment())->count('hash', $post->hash);
            unset($post->hash);
            return $post;
        }, $posts);
        return $this->trim($posts);
    }

}
