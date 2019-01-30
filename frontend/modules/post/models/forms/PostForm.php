<?php


namespace frontend\modules\post\models\forms;

use Yii;
use yii\base\Model;
use frontend\models\Post;
use frontend\models\Feed;

/**
 * Form for the `post` module
 */

class PostForm extends Model
{
    public $title;
    public $content;

    private $user_id;

    /**
     * Rules of validation
     * @return array
     */
    public function rules()
    {
        return [
            ['content', 'string', 'length' => [4, 4096]],
            ['title', 'string', 'length' => [3, 255]],
            [['content'], 'required'],
        ];
    }

    /**
     * Creating, filling and save new post in db
     * @param string $user_id
     * @return bool
     */
    public function saveNewPost($user_id)
    {
        $post = new Post();
        $post->title = $this->title;
        $post->content = $this->content;
        $post->user_id = $user_id;

        if ($post->save('false') && Feed::addNewFeeds($post)){
            return true;
        };
        return false;
    }
}