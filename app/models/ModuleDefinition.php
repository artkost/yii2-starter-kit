<?php

namespace app\models;

use app\commands\MigrateController;
use app\modules\admin\Module;
use Yii;
use yii\base\BootstrapInterface;
use yii\base\Event;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
use yii\helpers\Html;

class ModuleDefinition extends Model
{
    const PACKAGE_CORE = 'core';

    /**
     * Module identifier
     * @var string
     */
    public $id;

    /**
     * Always Module::className(), need for Yii::createObject()
     * @var string
     */
    public $class;

    /**
     * Custom namespace for module, for ex MyCompany\MySuperModule
     * @var
     */
    public $namespace;

    /**
     * @var
     */
    public $basePath;

    /**
     * config for Module itself
     * @var array
     */
    public $config = [];

    /**
     * bootstrap function of module, works same way as BootstrapInterface
     * @see \yii\base\BootstrapInterface::bootstrap()
     * @var callable
     */
    public $bootstrap = null;

    /**
     * Human readable name
     * @var string
     */
    public $name;
    public $description = '';
    public $version = '';

    /**
     * Package, contrib by default
     * @var string
     */
    public $package = 'contrib';

    /**
     * Category for grouping
     * @var string
     */
    public $category = 'common';

    /**
     * Required for proper working system, used for critical modules
     * @var bool
     */
    public $required = false;

    /**
     * Url to configuration page
     * @var string
     */
    public $configure = '';
    public $dependencies = [];

    public $events = [];
    public $urlRules = [];
    public $weight = 0;

    public $menu = [];

    /**
     * A module instance
     * @var Module
     */
    public $module;

    /**
     * Registers module in the system
     */
    public function register()
    {
        $this
            ->registerNamespace()
            ->registerEvents()
            ->registerUrlRules()
            ->registerModule();

        return $this;
    }

    /**
     * Register module in Application class
     */
    protected function registerModule()
    {
        Yii::$app->setModule(
            $this->id,
            ArrayHelper::merge(
                $this->getConfig(Yii::$app->id),
                [
                    'class' => $this->class
                ]
            )
        );

        $module = Yii::$app->getModule($this->id);

        if ($module instanceof BootstrapInterface) {
            Yii::trace("Bootstrap with " . get_class($module) . '::bootstrap()', __METHOD__);
            $module->bootstrap(Yii::$app);
        }

        $this->module = $module;

        return $this;
    }

    /**
     * Registers module namespace for loading
     * useful for custom modules, if they have own namespace
     */
    protected function registerNamespace()
    {
        if ($this->namespace && $this->basePath) {
            Yii::setAlias('@' . str_replace('\\', '/', $this->namespace), $this->basePath);
        }

        return $this;
    }

    /**
     * Register Global Event Handlers
     * Some modules can fire events, subscribe here
     */
    protected function registerEvents()
    {
        if (!empty($this->events)) {
            foreach ($this->events as $event) {
                Event::on($event['class'], $event['event'], $event['callback']);
            }
        }

        return $this;
    }

    /**
     * Register url rules from config
     * Module can define any rule
     */
    protected function registerUrlRules()
    {
        if (!empty($this->urlRules)) {
            Yii::$app->urlManager->addRules($this->urlRules, false);
        }

        return $this;
    }

    /**
     * @return Module
     */
    public function getModule()
    {
        return $this->module;
    }

    /**
     * @return string
     */
    public function getModuleNamespace()
    {
        $nsSlices = explode('\\', $this->class);
        array_pop($nsSlices);

        return implode('\\', $nsSlices);
    }

    /**
     * @return string
     */
    public function getModuleAlias()
    {
        return Yii::getAlias($this->basePath);
    }

    /**
     * Returns modules config
     * @param string $type name
     * @return array
     */
    public function getConfig($type)
    {
        $moduleConfig = $this->config;

        switch ($type) {
            case 'admin':
                /**
                 * For admin interface we use custom controllers namespace for loading from admin folder
                 */
                $moduleConfig['controllerNamespace'] = $this->getModuleNamespace() . '\admin\controllers';
                $moduleConfig['viewPath'] = FileHelper::normalizePath($this->getModuleAlias() . '/admin/views');
                break;

            case 'console':
                $moduleConfig['controllerNamespace'] = $this->getModuleNamespace() . '\commands';
                break;

            case 'site':
                break;
        }

        return $moduleConfig;
    }

    public function isCore()
    {
        return $this->package === self::PACKAGE_CORE;
    }

    public function isInstalled()
    {
        return false;
    }

    public function migrateUp()
    {
        return MigrateController::webModuleUp($this->id);
    }

    public function migrateDown()
    {
        return MigrateController::webModuleDown($this->id);
    }

    /**
     * Tries to install module, execs all install hooks, applies migrations
     */
    public function install()
    {
        $migrationStatus = $this->migrateUp();
    }

    /**
     * Deletes module, removes all tables
     */
    public function uninstall()
    {
        $migrationStatus = $this->migrateDown();
    }

    public function createMenuItem($item)
    {
        return [
            'label' => Module::t($this->category, Html::encode($item['title'])),
            'url' => isset($item['route']) ? $item['route'] : false,
            'icon' => isset($item['icon']) ? $item['icon'] : false
        ];
    }
}
