<?php

namespace frontend\modules\user\controllers;

use frontend\models\User;
use frontend\modules\user\models\forms\ProfileImgForm;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\UploadedFile;

class ProfileController extends Controller
{
    public function actionView($nickname)
    {
        if((Yii::$app->user->identity->getId() != $nickname) and (Yii::$app->user->identity->getNickname() != $nickname)){
            return $this->render('index', [
                'user' => $this->findUser($nickname),
            ]);
        }
        else{
            $modelProfileImg = new ProfileImgForm();

            return $this->render('my', [
                'modelProfileImg' => $modelProfileImg,
                'user' => Yii::$app->user->identity,
            ]);
        }
    }

    public function actionUploadProfileImg()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $currentUser = Yii::$app->user->identity;

        $modelProfileImg = new ProfileImgForm();
        $modelProfileImg->profileImg = UploadedFile::getInstance($modelProfileImg, 'profileImg');

        if ($modelProfileImg->validate()) {

            if ($path = Yii::$app->ImgService->saveImg($modelProfileImg, 'resize')) {

                $currentUser->deleteProfileImg();
                $currentUser->updateProfileImg($path);

                return [
                    'success' => true,
                    'ProfileImgUri' => $path,
                ];
            }
        }
        return ['success' => false, 'errors' => $modelProfileImg->getErrors()];
    }

    public function findUser($nickname)
    {
        if($user = User::find()->where(['username' => $nickname])->orWhere(['id' => $nickname])->one()){
            return $user;
        }
        throw new NotFoundHttpException();
    }
}