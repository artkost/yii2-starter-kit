<?php

namespace app\themes\admin;

use app\base\ModuleParamTrait;
use app\base\TranslatableTrait;
use Yii;
use yii\base\BootstrapInterface;

/**
 * Class Theme
 * @package app\themes\admin
 */
class Theme extends \yii\base\Theme implements BootstrapInterface
{
    const PARAM_ROOT = 'theme';
    const TRANSLATE_CATEGORY = 'theme';

    use ModuleParamTrait;
    use TranslatableTrait;

    /**
     * @inheritdoc
     */
    public $pathMap = [
        '@app/views' => '@app/themes/admin/views',
        '@app/modules' => '@app/themes/admin/modules'
    ];

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $this->assetManager->bundles['yii\bootstrap\BootstrapAsset'] = [
            'sourcePath' => '@app/themes/admin/assets',
            'css' => [
                'css/bootstrap.css'
            ]
        ];
        $this->assetManager->bundles['yii\bootstrap\BootstrapPluginAsset'] = [
            'sourcePath' => '@app/themes/admin/assets',
            'js' => [
                'js/bootstrap.js'
            ]
        ];

        Yii::$container->set('yii\grid\CheckboxColumn', [
            'checkboxOptions' => [
                'class' => 'simple'
            ]
        ]);
    }

    public function bootstrap($app)
    {
        $app->i18n->translations[self::TRANSLATE_CATEGORY . '*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'basePath' => __DIR__ . '/messages',
            'forceTranslation' => true,
            'fileMap' => [
                'admin' => 'admin.php',
            ]
        ];
    }

    /**
     * @return \yii\web\AssetManager
     */
    public function getAssetManager()
    {
        return Yii::$app->assetManager;
    }
}
