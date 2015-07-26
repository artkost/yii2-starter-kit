<?php

namespace app\themes\admin\assets;

use yii\web\AssetBundle;

/**
 * Theme data tables asset bundle.
 */
class DataTablesAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@app/themes/admin/assets/js/plugins/datatables/';

    /**
     * @inheritdoc
     */
    public $css = [
        'dataTables.bootstrap.css'
    ];

    /**
     * @inheritdoc
     */
    public $js = [
        'dataTables.bootstrap.js'
    ];

    /**
     * @inheritdoc
     */
    public $depends = [
        'app\themes\admin\assets\ThemeAsset'
    ];
}
