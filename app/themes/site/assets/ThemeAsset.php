<?php

namespace app\themes\site\assets;

use yii\web\AssetBundle;

/**
 * Theme main asset bundle.
 */
class ThemeAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@app/themes/site/assets';

    /**
     * @inheritdoc
     */
    public $css = [
        'libs/material-design-lite/material.min.css',
        'style.css'
    ];

    public $js = [
        'libs/material-design-lite/material.min.js',
    ];

    /**
     * @inheritdoc
     */
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
