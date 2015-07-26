<?php

namespace app\modules\page;

use yii\base\BootstrapInterface;

class Bootstrap implements BootstrapInterface
{
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