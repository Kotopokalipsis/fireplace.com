<?php

namespace frontend\modules\post\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use frontend\modules\post\models\forms\PostForm;
use frontend\models\Post;
use frontend\models\User;
use yii\web\NotFoundHttpException;
use yii\debug;

/**
 * Default controller for the `post` module
 */
class CommentController extends Controller
{
    public function actionAddComment()
    {
        if (Yii::$app->user->isGuest){
            return $this->redirect(['/user/default/login']);
        }

        Yii::$app->response->format = Response::FORMAT_JSON;


    }
}
