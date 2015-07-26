<?php

namespace app\themes\admin\assets;

use yii\web\AssetBundle;

/**
 * Theme main asset bundle.
 */
class ThemeAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@app/themes/admin/assets';

    /**
     * @inheritdoc
     */
    public $css = [
        'css/font-awesome.css',
        'css/ionicons.css',
        'css/AdminLTE.css',
        'css/skins/skin-black.css',
        'css/style.css',
    ];

    public $js = [
        'js/lodash.js',
        'js/app.js'
    ];

    /**
     * @inheritdoc
     */
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset'
    ];
}
