<?php

namespace app\web;

use yii\base\Widget;
use yii\helpers\Url;

class Application extends \yii\web\Application
{
    const INSTALL_ROUTE = ['/installer/index'];

    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        /**
         * Check if it's already installed - if not force controller module
         */
        if (!$this->params['installed'] && $this->controller->module != null && $this->controller->module->id != 'installer') {
            $this->controller->redirect(Url::to(self::INSTALL_ROUTE));
            return false;
        }

        /**
         * More random widget autoId prefix
         * Ensures to be unique also on ajax partials
         */
        Widget::$autoIdPrefix = 'h' . mt_rand(1, 999999) . 'w';

        return parent::beforeAction($action);
    }

    /**
     * @inheritdoc
     */
    public function preInit(&$config)
    {
        if (!isset($config['timeZone']) && date_default_timezone_get()) {
            $config['timeZone'] = date_default_timezone_get();
        }

        parent::preInit($config);
    }
}