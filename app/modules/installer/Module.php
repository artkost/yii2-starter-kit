<?php

namespace app\modules\installer;

use app\base\ModuleParamTrait;
use app\base\TranslatableTrait;
use Yii;
use yii\base\BootstrapInterface;
use yii\web\HttpException;

class Module extends \yii\base\Module implements BootstrapInterface
{
    const PARAM_ROOT = 'installer';
    const TRANSLATE_CATEGORY = 'installer';

    use ModuleParamTrait;
    use TranslatableTrait;


    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        $app->i18n->translations[Module::TRANSLATE_CATEGORY . '/*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'basePath' => '@app/modules/admin/messages',
            'forceTranslation' => true,
            'fileMap' => [
                'installer/installer' => 'installer.php',
            ]
        ];
    }

        /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        // Block installer, when it's marked as installed
        if (Yii::$app->params['installed']) {
            throw new HttpException(500, 'Application is already installed!');
        }

        Yii::$app->controller->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    /**
     * Checks if database connections works
     *
     * @return boolean state of database connection
     */
    public function checkDBConnection()
    {
        try {
            // call setActive with true to open connection.
            Yii::$app->db->open();
            // return the current connection state.
            return Yii::$app->db->getIsActive();
        } catch (\yii\db\Exception $e) {

        } catch (\PDOException $e) {

        }

        return false;
    }
}