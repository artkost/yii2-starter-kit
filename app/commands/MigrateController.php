<?php

namespace app\commands;

use app\web\Application;
use bariew\moduleMigration\ModuleMigrateController;
use Yii;

class MigrateController extends ModuleMigrateController
{
    /**
     *
     * @param string $module
     * @return string output
     */
    public static function webModuleUp($module)
    {
        ob_start();
        $controller = new self('migrate', Yii::$app);
        $controller->db = Yii::$app->db;
        $controller->interactive = false;
        $controller->color = false;
        $controller->runAction('module-up', ['module' => $module]);
        return ob_get_clean();
    }

    /**
     *
     * @param string $module
     * @return string output
     */
    public static function webModuleDown($module)
    {
        ob_start();
        $controller = new self('migrate', Yii::$app);
        $controller->db = Yii::$app->db;
        $controller->interactive = false;
        $controller->color = false;
        $controller->runAction('module-down', ['module' => $module]);
        return ob_get_clean();
    }

    public function stderr($string)
    {
        if (Yii::$app instanceof Application) {
            echo $string;
        } else {
            parent::stderr($string);
        }
    }

    public function stdout($string)
    {
        if (Yii::$app instanceof Application) {
            echo $string;
        } else {
            parent::stdout($string);
        }
    }
}