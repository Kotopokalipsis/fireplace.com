<?php

namespace frontend\modules\post\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use frontend\modules\post\models\forms\PostForm;
use frontend\models\Post;
use frontend\models\User;

/**
 * Default controller for the `post` module
 */
class DefaultController extends Controller
{
    public $post;

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionView($id)
    {
        $post = Post::findPostByPostId($id);
        $user = User::findById($post['user_id']);

        return $this->render('index', [
            'post' => $post,
            'nickname' => $user->username,
        ]);
    }

    public function actionNewPost()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $model = new PostForm();
        $this->post = $model;

        if($model->load(Yii::$app->request->post())){
            if($model->validate() && $model->saveNewPost(Yii::$app->user->identity->getId()))
            {
                return [
                    'success' => $this->post,
                ];
            };
        }
        return [
            'success' => $this->post,
        ];
    }
}
