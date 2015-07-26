<?php

namespace app\modules\admin;

use Yii;
use yii\base\BootstrapInterface;
use yii\base\InvalidConfigException;
use yii\console\Application as ConsoleApplication;

class Bootstrap implements BootstrapInterface
{
    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        if ($app instanceof ConsoleApplication) {

        } else {
            // Add module URL rules.
            $app->getUrlManager()->addRules(
                [
                    '' => 'admin/default/index',
                    '<_m>/<_c>/<_a>' => '<_m>/<_c>/<_a>'
                ]
            );
        }

        $app->i18n->translations[Module::TRANSLATE_CATEGORY . '/*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'basePath' => '@app/modules/admin/messages',
            'forceTranslation' => true,
            'fileMap' => [
                'admin/admin' => 'admin.php',
            ]
        ];

        if (! $app->has('cache')) {
            throw new InvalidConfigException('Cache component not found, please configure');
        }
    }
}
