<?php

namespace app\modules\comment;

use yii\base\BootstrapInterface;

/**
 * Gallery module bootstrap class.
 */
class Bootstrap implements BootstrapInterface
{
    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        // Add module I18N category.
        $app->i18n->translations['comment/*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'basePath' => '@app/modules/comment/messages',
            'forceTranslation' => true,
            'fileMap' => [
                'comment/comment' => 'comment.php',
                'comment/model' => 'model.php',
                'comment/admin' => 'admin.php',
            ]
        ];
    }
}
