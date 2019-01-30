<?php

namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use frontend\models\Comments;
use frontend\models\User;

/**
 * This is the model class for table "post".
 *
 * @property int $id
 * @property string $title
 * @property string $content
 * @property string $date
 * @property int $user_id
 * @property int creation_time
 * @property int update_time
 */
class Post extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'post';
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'creation_time',
                    ActiveRecord::EVENT_BEFORE_UPDATE => 'update_time',
                ],
                'value' => function() { return date('Y-m-d H:i:s');},
            ],
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'content' => 'Content',
            'user_id' => 'User ID',
        ];
    }

    public function getId()
    {
        return $this->id;
    }

    public function findPostByPostId($postId)
    {
        return static::findOne(['id' => $postId]);
    }

    public function findPostsByUserId($userId)
    {
        return static::findAll(['user_id' => $userId]);
    }

    public function like(User $user)
    {
        /* @var $redis Connection */
        $redis = Yii::$app->redis;
        $redis->sadd("post:{$this->getId()}:likes", $user->getId());
    }

    public function unlike(User $user)
    {
        /* @var $redis Connection */
        $redis = Yii::$app->redis;
        $redis->srem("post:{$this->getId()}:likes", $user->getId());
    }

    public function isLiked($userId)
    {
        /* @var $redis Connection */
        $redis = Yii::$app->redis;
        if ($redis->sismember("post:{$this->getId()}:likes", $userId)){
            return true;
        };
        return false;
    }

    public function countLikes()
    {
        /* @var $redis Connection */
        $redis = Yii::$app->redis;
        $count = $redis->scard("post:{$this->getId()}:likes");
        return $count;
    }

    public function getComments()
    {
        return $this->hasMany(Comments::classname(), ['post_id' => 'id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::classname(), ['id' => 'user_id']);
    }
}
