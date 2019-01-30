<?php

namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use frontend\models\User;

/**
 * This is the model class for table "comments".
 *
 * @property int $id
 * @property int $nickname
 * @property int $post_id
 * @property string $content
 * @property string $creation_time
 * @property string $update_time
 */
class Comments extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comments';
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
    public function rules()
    {
        return [
            [['post_id'], 'integer'],
            [['content, nickname'], 'string'],
            [['creation_time', 'update_time'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nickname' => 'Nickname',
            'post_id' => 'Post ID',
            'content' => 'Content',
            'creation_time' => 'Creation Time',
            'update_time' => 'Update Time',
        ];
    }

    public function getPosts()
    {
        return $this->hasOne(Post::className(), ['id' => 'post_id']);
    }

    /**
     * @return bool
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function deleteComment()
    {
        if(Yii::$app->user->identity->getNickname() == $this->nickname){
            $this->delete();
            return true;
        }
        return false;
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['username' => 'nickname']);
    }


}
