<?php

namespace frontend\models;

use Yii;
use frontend\models\User;
use frontend\models\Post;
use yii\redis;

/**
 * This is the model class for table "feed".
 *
 * @property int $id
 * @property int $user_id
 * @property int $author_id
 * @property string $author_nickname
 * @property string $author_photo
 * @property int $post_id
 * @property int $post_title
 * @property string $post_content
 * @property string $post_uploads
 * @property string $post_created_at
 */
class Feed extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'feed';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'author_id', 'post_id'], 'integer'],
            [['post_content'], 'string'],
            [['post_created_at'], 'safe'],
            [['author_nickname', 'author_photo', 'post_uploads', 'post_title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'author_id' => 'Author ID',
            'author_nickname' => 'Author Nickname',
            'author_photo' => 'Author Photo',
            'post_id' => 'Post ID',
            'post_title' => 'Post Title',
            'post_content' => 'Post Content',
            'post_uploads' => 'Post Uploads',
            'post_created_at' => 'Post Created At',
        ];
    }

    public static function addNewFeeds($post)
    {
        $redis = Yii::$app->redis;
        $currentUser = Yii::$app->user->identity;
        $followers = $redis->smembers("user:{$currentUser->getId()}:follower");
        foreach ($followers as $follower){
            $feed = new Feed();
            $feed->user_id = $follower;
            $feed->author_id = $currentUser->getId();
            $feed->author_nickname = $currentUser->getNickname();
            $feed->author_photo = $currentUser->getProfileImg();
            $feed->post_id = $post->id;
            $feed->post_title = $post->title;
            $feed->post_content = $post->content;
            $feed->post_created_at = $post->creation_time;
            $feed->save();
        }
        return true;
    }

    public function getPost()
    {
        return $this->hasOne(Post::className(), ['id' => 'post_id']);
    }

    public function getAuthor()
    {
        return $this->hasOne(User::className(), ['id' => 'author_id']);
    }
}
