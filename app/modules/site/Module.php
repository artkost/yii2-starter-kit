<?php

namespace app\modules\site;

use app\base\ModuleParamTrait;
use app\base\TranslatableTrait;
use yii\base\BootstrapInterface;

class Module extends \yii\base\Module implements BootstrapInterface
{
    const PARAM_ROOT = 'site';
    const TRANSLATE_CATEGORY = 'site';

    use ModuleParamTrait;
    use TranslatableTrait;

    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        // Add module I18N category.
        $app->i18n->translations[Module::TRANSLATE_CATEGORY . '/*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'basePath' => __DIR__ . '/messages',
            'forceTranslation' => true,
            'fileMap' => [
            ]
        ];

        $app->errorHandler->errorAction = ['site/default/error'];
    }
}
