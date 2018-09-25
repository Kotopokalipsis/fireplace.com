<?php

namespace frontend\widgets;

use Yii;
use yii\base\Widget;
use frontend\modules\post\models\forms\PostForm;

class ModalNewPostWidget extends Widget
{
    public function init()
    {
        return parent::init();
    }

    public function run()
    {
        $model = new PostForm();
        return $this->render('modalNewPost', [
            'model' => $model,
        ]);
    }
}