<?php

namespace frontend\modules\post\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use frontend\modules\post\models\forms\CommentForm;
use frontend\modules\post\models\forms\PostForm;
use frontend\models\Post;
use frontend\models\User;
use yii\web\NotFoundHttpException;


/**
 * Default controller for the `post` module
 */
class DefaultController extends Controller
{
    public $post;

    /**
     * Renders single post view for the module
     * @param string $id of post
     * @throws NotFoundHttpException
     * @return mixed
     */
    public function actionView($id)
    {
        $post = $this->findPost($id);
        $modelComment = new CommentForm(Yii::$app->user->identity->getNickname());
        if($user = User::findOne($post['user_id'])){
            return $this->render('single-post', [
                'post' => $post,
                'user' => $user,
                'currentUser' => Yii::$app->user->identity,
                'modelComment' => $modelComment,
            ]);
        };
        throw new NotFoundHttpException();
    }

    /**
     * Create new post
     * @return array|Response
     */
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

    /**
     * Find single post
     * @param string $id of post
     * @throws NotFoundHttpException
     * @return mixed
     */
    public function findPost($id)
    {
        if($post = Post::findOne($id)){
            return $post;
        }
        throw new NotFoundHttpException();
    }

    /**
     * Put 'like' on the post
     * @return array|Response
     * @throws NotFoundHttpException
     */
    public function actionLike()
    {
        if (Yii::$app->user->isGuest){
            return $this->redirect(['/user/default/login']);
        }

        Yii::$app->response->format = Response::FORMAT_JSON;

        $id = Yii::$app->request->post('id');
        $post = $this->findPost($id);

        /* @var $currentUser User*/
        $currentUser = Yii::$app->user->identity;

        $post->like($currentUser);

        return [
            'success' => true,
            'countLikes' => $post->countLikes(),
        ];
    }

    /**
     * Put unlike on the post
     * @return array|Response
     * @throws NotFoundHttpException
     */
    public function actionUnlike()
    {
        if (Yii::$app->user->isGuest){
            return $this->redirect(['/user/default/login']);
        }

        Yii::$app->response->format = Response::FORMAT_JSON;

        $id = Yii::$app->request->post('id');
        $post = $this->findPost($id);

        /* @var $currentUser User*/
        $currentUser = Yii::$app->user->identity;

        $post->unlike($currentUser);

        return [
            'success' => true,
            'countLikes' => $post->countLikes(),
        ];
    }
}
