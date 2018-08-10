<?php

namespace frontend\components;

use Yii;
use yii\base\Component;
use yii\helpers\FileHelper;
use yii\imagine\Image;
use Imagine\Image\Box;

class ImgService extends Component
{
    public function saveImg($model, $option = null)
    {
        $directory = Yii::getAlias('@frontend/web/img/temp') . DIRECTORY_SEPARATOR . Yii::$app->user->identity->getNickname() . DIRECTORY_SEPARATOR;
        if (!is_dir($directory)) {
            FileHelper::createDirectory($directory);
        }

        $uid = uniqid(time(), true);
        $fileName = $uid . '.' . $model->profileImg->extension;
        $filePath = $directory . $fileName;

        $model->profileImg->saveAs($filePath);
        if ($option){
            $this->$option($filePath);
        }
        $path = '/img/temp/' . Yii::$app->user->identity->getNickname() . DIRECTORY_SEPARATOR . $fileName;
        return $path;
    }

    private function resize($filePath){
        $imagine = Image::getImagine();
        $image = $imagine->open($filePath);
        $image->resize(new Box(110, 110))->save($filePath);
    }
}