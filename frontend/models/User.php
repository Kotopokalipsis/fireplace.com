<?php
namespace frontend\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\helpers\FileHelper;
use frontend\models\Post;
use frontend\models\Comments;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $profile_img
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;

    const DEFAULT_IMAGE = '/img/profile_default_image.png';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by user_id
     *
     * @param string $id
     * @return static|null
     */
    public static function findById($id)
    {
        return static::findOne(['id' => $id]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     *  {@inheritdoc}
     */
    public function getNickname()
    {
        return $this->username;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function getProfileImg()
    {
        if($this->profile_img == null){
            return self::DEFAULT_IMAGE;
        }
        return $this->profile_img;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    public function updateProfileImg($path)
    {
        $this->profile_img = $path;
        $this->save();
    }

    public function deleteProfileImg()
    {
        if($this->profile_img != null){
            $directory =  Yii::getAlias('@frontend/web/') . $this->profile_img;
            FileHelper::removeDirectory($directory);
            FileHelper::unlink("$directory");
            $this->profile_img = null;
        }
    }

    public function getPosts()
    {
        return $this->hasMany(Post::className(), ['user_id' => 'id']);
    }

    public function Subscribe()
    {
        /* @var $redis Connection */
        $redis = Yii::$app->redis;
        $currentUserID = Yii::$app->user->identity->getId();
        $redis->sadd("user:{$currentUserID}:subscription", $this->getId());
        $redis->sadd("user:{$this->getId()}:follower", $currentUserID);
    }

    public function isSubscriber($userId)
    {
        /* @var $redis Connection */
        $redis = Yii::$app->redis;
        if ($redis->sismember("user:{$this->getId()}:subscription", $userId)) {
            return true;
        }
        return false;
    }

    public function getFollowers()
    {
        /* @var $redis Connection */
        $redis = Yii::$app->redis;
        $followers = $redis->smembers("user:{$this->getId()}:follower");
        return User::findAll($followers);
    }

    public function getSubscriptions()
    {
        /* @var $redis Connection */
        $redis = Yii::$app->redis;
        $subscriptions = $redis->smembers("user:{$this->getId()}:subscription");
        return User::findAll($subscriptions);
    }


    public function Unsubscribe()
    {
        /* @var $redis Connection */
        $redis = Yii::$app->redis;
        $currentUserID = Yii::$app->user->identity->getId();
        $redis->srem("user:{$currentUserID}:subscription", $this->getId());
        $redis->srem("user:{$this->getId()}:follower", $currentUserID);
    }

    public function getComments()
    {
        return $this->hasMany(Comments::className(), ['nickname' => 'username']);
    }

    public function countFollowers()
    {
        /* @var $redis Connection */
        $redis = Yii::$app->redis;
        return $redis->scard("user:{$this->getId()}:follower");
    }

    public function countSubscriptions()
    {
        /* @var $redis Connection */
        $redis = Yii::$app->redis;
        return $redis->scard("user:{$this->getId()}:subscription");
    }




}
