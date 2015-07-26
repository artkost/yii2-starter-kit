<?php

namespace app\themes\admin\assets;

use yii\web\AssetBundle;

class ICheckAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@app/themes/admin/assets/js/plugins/iCheck/';

    /**
     * @inheritdoc
     */
    public $css = [
        'square/blue.css'
    ];

    /**
     * @inheritdoc
     */
    public $js = [
        'icheck.js'
    ];

    /**
     * @inheritdoc
     */
    public $depends = [
        'app\themes\admin\assets\ThemeAsset'
    ];
}
