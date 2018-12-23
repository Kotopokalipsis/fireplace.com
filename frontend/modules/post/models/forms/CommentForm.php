<?php
/**
 * Created by PhpStorm.
 * User: Holden
 * Date: 04.10.2018
 * Time: 22:05
 */

namespace frontend\modules\post\models\forms;

use yii\base\Model;
use Yii;
use frontend\models\Comments;


class CommentForm extends Model
{
    public $nickname;
    public $content;
    public $post_id;

    public function __construct($nickname)
    {
        $this->nickname = $nickname;
    }

    public function rules()
    {
        return [
            [['post_id'], 'integer',],
            [['content', 'creation_time', 'update_time', 'post_id', 'nickname'], 'required'],
            [['content', 'nickname'], 'string'],
            [['creation_time', 'update_time'], 'safe'],
        ];
    }

    public function saveNewComment()
    {
        $comment = new Comments();
        $comment->nickname = $this->nickname;
        $comment->content = $this->content;
        $comment->post_id = $this->post_id;
        if($comment->save(false)){
            return $comment;
        }
        return false;
    }
}