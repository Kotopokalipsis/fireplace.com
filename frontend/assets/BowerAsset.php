<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class BowerAsset extends AssetBundle
{
    public $sourcePath = '@vendor/bower-asset/';

    public $css = [
        'animate.css/animate.min.css',
        'components-font-awesome/css/fontawesome-all.min.css',
    ];
}