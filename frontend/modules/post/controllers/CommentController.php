<?php

namespace frontend\modules\post\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use frontend\models\Comments;
use frontend\modules\post\models\forms\CommentForm;

/**
 * Comment controller for the `post` module
 */
class CommentController extends Controller
{
    /**
     * @return array|Response
     */
    public function actionAddComment()
    {
        if(Yii::$app->user->isGuest){
            return $this->redirect(['/user/default/login']);
        }

        Yii::$app->response->format = Response::FORMAT_JSON;

        $model = new CommentForm(Yii::$app->user->identity->getNickname());
        if($model->load(Yii::$app->request->post())){
            if($comment = $model->saveNewComment()){
                return [
                    'success' => true,
                    'comment' => $comment,
                ];
            };
        };

        return [
            'success' => false,
        ];
    }

    public function actionDeleteComment()
    {
        if(Yii::$app->user->isGuest){
            return $this->redirect(['/user/default/login']);
        }

        Yii::$app->response->format = Response::FORMAT_JSON;

        $comment = $this->findComment(Yii::$app->request->post());
        if($comment->deleteComment()){
            return [
                'success' => true,
            ];
        }

        return [
            'success' => false,
            'res' => Yii::$app->request->post(),
        ];
    }

    public function findComment($commentID)
    {
        if($comment = Comments::find()->where(['id' => $commentID])->one()){
            return $comment;
        };

        throw new NotFoundHttpException();
    }
}
