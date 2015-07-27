<?php

namespace app\base;

use Yii;
use yii\base\BootstrapInterface;
use yii\helpers\ArrayHelper;
use yii\web\Application;

/**
 * Manages and bootstraps modules
 * Class ModuleManager
 * @package app\modules\admin
 */
class ModuleManager implements BootstrapInterface
{
    static $modules = ['admin'];

    public function bootstrap($app)
    {
        if ($app instanceof Application) {
            if ($app->id === 'admin') {
                $modules = self::getConfig('admin');
            } else {
                $modules = self::getConfig('web');
            }
        } else {
            $modules = self::getConfig('console');
        }

        $app->setModules($modules);

        $bootstrap = self::getBootstrap();

        foreach ($bootstrap as $config) {
            if (is_string($config) && $app->has($config)) {
                $component = $app->get($config);
            } else {
                $component = Yii::createObject($config);
            }

            if ($component instanceof BootstrapInterface) {
                Yii::trace("Bootstrap with " . get_class($component) . '::bootstrap()', __METHOD__);
                $component->bootstrap($app);
            }
        }
    }

    /**
     * Finds modules
     * @return array
     */
    public static function findModules()
    {
        $modules = require(Yii::getAlias('@app/config/modules.php'));

        if (is_array($modules) && !empty($modules)) {
            self::$modules = ArrayHelper::merge(self::$modules, $modules);
        }

        return self::$modules;
    }

    /**
     * @param $module
     * @param $name
     * @return string
     */
    public static function getModuleNamespace($module, $name)
    {
        return "app\\modules\\{$module}\\{$name}";
    }

    /**
     * @param $module
     * @param $name
     * @return string
     */
    public static function getModuleAlias($module, $name)
    {
        return "@app/modules/{$module}/{$name}";
    }

    /**
     * Returns modules config
     * @param string $config name
     * @return array
     */
    public static function getConfig($config = 'web')
    {
        self::findModules();

        $modulesConfig = [];

        foreach (self::$modules as $module) {
            $modulesConfig[$module] = [
                'class' => self::getModuleNamespace($module, 'Module')
            ];

            switch($config) {
                case 'admin':
                    $modulesConfig[$module]['controllerNamespace'] = self::getModuleNamespace($module, 'admin\controllers');
                    $modulesConfig[$module]['viewPath'] = self::getModuleAlias($module, 'admin/views');
                break;

                case 'console':
                    $modulesConfig[$module]['controllerNamespace'] = self::getModuleNamespace($module, 'commands');
                break;
            }
        }

        return $modulesConfig;
    }

    /**
     * Array of modules bootstrap classes
     * @return array
     */
    public static function getBootstrap()
    {
        $bootstrapConfig = [];

        foreach (self::$modules as $module) {
            $class = self::getModuleNamespace($module, 'Bootstrap');

            $bootstrapConfig[] = ['class' => $class];
        }

        return $bootstrapConfig;
    }
}
