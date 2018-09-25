<?php


namespace frontend\modules\post\models\forms;

use Yii;
use yii\base\Model;
use frontend\models\Post;

class PostForm extends Model
{
    public $title;
    public $content;

    private $user_id;


    public function rules()
    {
        return [
            ['content', 'string', 'length' => [4, 24]],
            ['title', 'string', 'length' => [3, 10]],
            [['content'], 'required'],
        ];
    }

    public function saveNewPost($user_id)
    {
        $post = new Post();
        $post->title = $this->title;
        $post->content = $this->content;
        $post->user_id = $user_id;

        if ($post->save('false')){
            return true;
        };
        return false;
    }
}