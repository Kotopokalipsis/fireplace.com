<?php

namespace frontend\modules\feed\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\Feed;

/**
 * Default controller for the `feed` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionView()
    {
        if(Yii::$app->user->isGuest) {
            return $this->redirect('user/login');
        }
        if($feeds = $this->findFeeds(Yii::$app->user->identity->getId())){
            return $this->render('index', [
                'feeds' => $feeds,
                'currentUser' => Yii::$app->user->identity,
            ]);
        }
        return $this->render('index');
    }

    public function findFeeds($id)
    {
        if($feeds = Feed::findAll(['user_id' => $id])){
            return $feeds;
        }
        return false;
    }
}
