<?php

namespace app\modules\page;

use app\base\ModuleParamTrait;
use app\base\TranslatableTrait;
use yii\base\BootstrapInterface;

class Module extends \yii\base\Module implements BootstrapInterface
{
    const PARAM_ROOT = 'page';
    const TRANSLATE_CATEGORY = 'page';

    use ModuleParamTrait;
    use TranslatableTrait;

    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        // Add module I18N category.
        $app->i18n->translations['page/*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'basePath' => '@app/modules/page/messages',
            'forceTranslation' => true,
            'fileMap' => [
                'page/page' => 'page.php',
                'page/model' => 'model.php',
            ]
        ];
    }
}
