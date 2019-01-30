<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Required set assets for module post.
 */
class PostAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
    ];
    public $js = [
        'js/like.js',
        'js/subscribe.js',
        'js/comments.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'grozzzny\depends\bootstrap4\Bootstrap4Asset',
    ];
}
