<?php

namespace app\modules\user;

use yii\base\BootstrapInterface;

class Bootstrap implements BootstrapInterface
{
    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        // Add module I18N category.
        $app->i18n->translations[Module::TRANSLATE_CATEGORY . '/*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'basePath' => __DIR__ . '/messages',
            'fileMap' => [
                'user/users' => 'users.php',
                'user/user' => 'user.php',
                'user/admin' => 'admin.php',
                'user/mail' => 'mail.php',
                'user/model' => 'model.php',
                'user/console' => 'console.php'
            ]
        ];
    }
} 
