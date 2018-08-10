<?php

namespace frontend\modules\user\models\forms;

use Yii;
use yii\base\Model;

class ProfileImgForm extends Model
{
    public $profileImg;

    public function rules()
    {
        return [
            [['profileImg'], 'file',
                'extensions' => ['png', 'jpg'],
                'checkExtensionByMimeType' => true,
                'maxSize' => Yii::$app->params['maxFileSize']
            ],
        ];
    }

    public function save()
    {
        return 1;
    }
}