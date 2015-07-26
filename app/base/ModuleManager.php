<?php

namespace app\base;

use Yii;

class ModuleManager
{
    static $modules = ['admin'];

    public static function findModules()
    {
        static::$modules = include(dirname(__DIR__) . '/config/modules.php');
    }

    public static function getModuleFile($module, $name)
    {
        return "app\\modules\\{$module}\\{$name}";
    }

    public static function getConfig($config = 'web')
    {
        self::findModules();

        $modulesConfig = [];

        foreach (self::$modules as $module) {
            $class = self::getModuleFile($module, 'Module');

            $modulesConfig[$module] = ['class' => $class];

            if ($config == 'console') {
                $modulesConfig[$module]['controllerNamespace'] = self::getModuleFile($module, 'commands');
            }
        }

        return $modulesConfig;
    }

    public static function getBootstrap()
    {
        $bootstrapConfig = [];

        foreach (self::$modules as $module) {
            $class = self::getModuleFile($module, 'Bootstrap');

            $bootstrapConfig[] = ['class' => $class];
        }

        return $bootstrapConfig;
    }

}
