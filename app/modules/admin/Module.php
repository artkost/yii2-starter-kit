<?php

namespace app\modules\admin;

use app\base\ModuleParamTrait;
use app\base\TranslatableTrait;
use Yii;
use yii\base\BootstrapInterface;
use yii\base\InvalidConfigException;
use yii\base\Module as BaseModule;
use yii\console\Application as ConsoleApplication;
use yii\helpers\Url;

class Module extends BaseModule implements BootstrapInterface
{
    const PARAM_ROOT = 'admin';
    const TRANSLATE_CATEGORY = 'admin';

    use ModuleParamTrait;
    use TranslatableTrait;

    protected static $menu;

    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        if ($app instanceof ConsoleApplication) {

        } else {
            if ($app->id = 'admin') {
                // Add module URL rules.
                $app->urlManager->addRules(
                    [
                        '' => 'admin/default/index',
                        '<_m>/<_c>/<_a>' => '<_m>/<_c>/<_a>'
                    ]
                );
            }
        }

        $app->i18n->translations[Module::TRANSLATE_CATEGORY . '/*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'basePath' => '@app/modules/admin/messages',
            'forceTranslation' => true,
            'fileMap' => [
                'admin/admin' => 'admin.php',
            ]
        ];

        if (!$app->has('cache')) {
            throw new InvalidConfigException('Cache component not found, please configure');
        }
    }

    /**
     * @return MenuCollection
     */
    public function getMenu()
    {
        if (self::$menu == null) {
            self::$menu = Yii::createObject([
                'class' => MenuCollection::className(),
                'definitions' => Yii::$app->get('moduleManager')->getEnabledModules()
            ]);
        }

        return self::$menu;
    }

    public static function siteUrl()
    {
        return str_replace(ADMIN_PREFIX, '', Url::base(true));
    }
}
