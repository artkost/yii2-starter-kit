<?php

namespace app\models;

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

    const CACHE_ENABLED = 'ModuleDefinitionEnabled';

    public $id;
    public $class;
    public $config = [];
    public $basePath;

    public $name;
    public $package = 'contrib';
    public $category = 'common';
    public $required = false;

    public $configure = false;
    public $dependencies = [];

    public $events = [];
    public $urlRules = [];
    public $namespace;
    public $weight = 0;

    public $menu = [];

    public function register()
    {
        $this->registerNamespace();
        $this->registerEvents();
        $this->registerUrlRules();
        $this->registerModule();
    }

    protected function registerModule()
    {
        Yii::$app->setModule($this->id, ArrayHelper::merge($this->getConfig(Yii::$app->id), ['class' => $this->class]));

        $module = Yii::$app->getModule($this->id);

        if ($module instanceof BootstrapInterface) {
            Yii::trace("Bootstrap with " . get_class($module) . '::bootstrap()', __METHOD__);
            $module->bootstrap(Yii::$app);
        }
    }

    protected function registerNamespace()
    {
        if ($this->namespace && $this->basePath) {
            Yii::setAlias('@' . str_replace('\\', '/', $this->namespace), $this->basePath);
        }
    }

    protected function registerEvents()
    {
        // Register Global Event Handlers
        if (!empty($this->events)) {
            foreach ($this->events as $event) {
                Event::on($event['class'], $event['event'], $event['callback']);
            }
        }
    }

    protected function registerUrlRules()
    {
        if (!empty($this->urlRules)) {
            Yii::$app->urlManager->addRules($this->urlRules, false);
        }
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
    public function getConfig($type = 'web')
    {
        $moduleConfig = $this->config;

        switch($type) {
            case 'admin':
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

    /**
     * @return mixed
     */
    public static function getEnabledIds()
    {
        $ids = Yii::$app->cache->get(self::CACHE_ENABLED);

        return $ids ? $ids : [];
    }

    public function isCore()
    {
        return $this->package === self::PACKAGE_CORE;
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
