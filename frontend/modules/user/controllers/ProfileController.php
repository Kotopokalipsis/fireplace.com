<?php

namespace frontend\modules\user\controllers;

use frontend\models\Comments;
use frontend\models\User;
use frontend\models\Post;
use frontend\modules\user\models\forms\ProfileImgForm;
use frontend\modules\post\models\forms\CommentForm;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\UploadedFile;

class ProfileController extends Controller
{
    /**
     * @param $nickname
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($nickname)
    {
        $modelComment = new CommentForm(Yii::$app->user->identity->getNickname());
        $user = $this->findUser($nickname);
        return $this->render('index', [
            'currentUser' => Yii::$app->user->identity,
            'user' => $user,
            'posts' => $user->posts,
            'modelComment' => $modelComment,
        ]);
    }

    public function actionSubscribe()
    {
        if(Yii::$app->user->isGuest){
            return $this->redirect(['/user/default/login']);
        };

        Yii::$app->response->format = Response::FORMAT_JSON;

        if($nickname = Yii::$app->request->post()){
            $user = $this->findUser($nickname);
            $user->Subscribe();
            return [
                'success' => true,
            ];
        }

        return [
            'success' => $nickname,
        ];
    }

    public function actionUnsubscribe()
    {
        if(Yii::$app->user->isGuest){
            return $this->redirect(['/user/default/login']);
        };

        Yii::$app->response->format = Response::FORMAT_JSON;

        if($nickname = Yii::$app->request->post()){
            $user = $this->findUser($nickname);
            $user->Unsubscribe();
            return [
                'success' => true,
            ];
        }

        return [
            'success' => $nickname,
        ];
    }


    public function findUser($nickname)
    {
        if($user = User::findOne(['username' => $nickname])){
            return $user;
        }
        throw new NotFoundHttpException('User not found');
    }
}