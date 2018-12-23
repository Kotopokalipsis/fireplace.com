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
        'css/postMin.css',
    ];
    public $js = [
        'js/comments.js',
        'js/like.js',
        'js/subscribe.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
