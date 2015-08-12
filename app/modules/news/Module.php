<?php

namespace app\modules\news;

use app\base\ModuleParamTrait;
use app\base\TranslatableTrait;
use yii\base\BootstrapInterface;

class Module extends \yii\base\Module implements BootstrapInterface
{
    const PARAM_ROOT = 'news';
    const TRANSLATE_CATEGORY = 'news';

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
    }
}
