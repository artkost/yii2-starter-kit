<?php

namespace app\themes\site;

use app\base\ModuleParamTrait;
use app\base\TranslatableTrait;
use Yii;
use yii\base\BootstrapInterface;

/**
 * Class Theme
 * @package app\themes\site
 *
 * @property \yii\web\AssetManager $assetManager
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
        '@app/views' => '@app/themes/site/views',
        '@app/modules' => '@app/themes/site/modules'
    ];

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $this->assetManager->bundles['yii\bootstrap\BootstrapAsset'] = [
            'sourcePath' => '@app/themes/site/assets',
            'css' => [
                //'css/bootstrap.css'
            ]
        ];

        $this->assetManager->bundles['yii\bootstrap\BootstrapPluginAsset'] = [
            'sourcePath' => '@app/themes/site/assets',
            'js' => [
                'js/bootstrap.min.js'
            ]
        ];
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
