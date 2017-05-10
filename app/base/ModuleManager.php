<?php

namespace app\base;

use app\models\ModuleDefinition;
use Exception;
use Yii;
use yii\base\BootstrapInterface;
use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;

/**
 * Core loader for application, loads modules same way as Yii
 * Manages and bootstraps modules
 * Class ModuleManager
 * @package app\modules\admin
 */
class ModuleManager extends Component implements BootstrapInterface
{
    const CACHE_CONFIGS = 'ModuleManagerConfigs';
    const CACHE_ENABLED = 'ModuleManagerEnabled';

    const CONFIG_FILE = 'config.php';
    const REQUIREMENTS_FILE = 'requirements.php';

    /**
     * List of all modules
     * This also contains installed but not enabled modules.
     *
     * @param ModuleDefinition[] $config moduleId => class pairs
     */
    protected $definitions;

    /**
     * List of all enabled module ids
     *
     * @var string[]
     */
    protected $enabledIds = [];

    public function bootstrap($app)
    {
        $configs = $app->getCache()->get(self::CACHE_CONFIGS);

        if ($configs === false) {
            $configs = $this->getConfigFiles();

            if (!YII_DEBUG && !empty($configs)) {
                $app->getCache()->set(self::CACHE_CONFIGS, $configs);
            }
        }

        $app->get('moduleManager')->registerModules($configs);
    }

    /**
     * Get paths array where to search modules
     * @return array
     */
    public function getSearchPaths()
    {
        return ArrayHelper::getValue(Yii::$app->params, 'modules.path', ['@app/modules']);
    }

    /**
     * Loads modules configs and sorts it by weight
     * @return array
     */
    public function getConfigFiles()
    {
        $configs = [];

        foreach ($this->getSearchPaths() as $alias) {
            $path = Yii::getAlias($alias);
            $files = FileHelper::findFiles($path, ['only' => ['*/' . self::CONFIG_FILE]]);

            foreach ($files as $file) {
                try {
                    $config = require($file);
                    $config['basePath'] = dirname($file);
                    $configs[] = $config;
                } catch (Exception $e) {
                    Yii::trace("Failed loading module config.php file for {$file}: {$e->getMessage()}", __METHOD__);
                }
            }

            usort($configs, function ($configA, $configB) {
                if (isset($configA['weight'], $configB['weight'])) {
                    return (int)$configA['weight'] > (int)$configB['weight'];
                }

                return 0;
            });
        }

        return $configs;
    }

    /**
     * Gets modules requirements files
     * @return array
     */
    public function gerRequirementsFiles()
    {
        $requirements = [];

        foreach ($this->getSearchPaths() as $alias) {
            $path = Yii::getAlias($alias);
            $files = FileHelper::findFiles($path, ['only' => ['*/' . self::REQUIREMENTS_FILE]]);

            foreach ($files as $file) {
                try {
                    $requirements[] = require($file);
                } catch (Exception $e) {
                    Yii::trace("Failed loading requirements.php file: {$e->getMessage()}", __METHOD__);
                }
            }
        }

        return $requirements;
    }

    /**
     *
     */
    public function init()
    {
        parent::init();

        $this->enabledIds = $this->getEnabledIds();
    }

    /**
     * @return array
     */
    public function getEnabledIds()
    {
        $ids = Yii::$app->cache->get(self::CACHE_ENABLED);

        return $ids ? $ids : [];
    }

    /**
     * Flushes module manager configs cache
     */
    public function flushCache()
    {
        Yii::$app->cache->delete(self::CACHE_CONFIGS);
    }

    /**
     * @param array $configs
     * @throws InvalidConfigException
     */
    public function registerModules(array $configs)
    {
        foreach ($configs as $config) {
            $this->registerModule($config);
        }
    }

    /**
     * @param array $config a definition file inside module folder
     * @throws InvalidConfigException
     */
    public function registerModule($config)
    {
        // Check mandatory config options
        if (!isset($config['class']) || !isset($config['id'])) {
            throw new InvalidConfigException("Module configuration requires an 'id' and 'class' attribute!");
        }

        $id = $config['id'];

        if (isset($this->definitions[$id])) {
            /**
             * If this module already loaded just pass away
             */
            return;
        }

        $definition = new ModuleDefinition($config);

        /**
         * Required modules always enabled
         */
        if ($definition->required) {
            $this->enabledIds[] = $id;
        }

        // Not enabled and not core module
        if (!$definition->isCore() && !in_array($id, $this->enabledIds)) {
            return;
        }

        if (isset($config['bootstrap']) && is_callable($config['bootstrap'])) {
            $config['bootstrap'](Yii::$app);
        }

        $definition->register();

        $this->definitions[$id] = $definition;
    }

    /**
     * @return ModuleDefinition[]
     */
    public function getModuleDefinitions()
    {
        return $this->definitions;
    }

    /**
     * Returns only enabled modules
     * @return array
     */
    public function getEnabledModules()
    {
        return array_filter($this->definitions, [$this, 'filterEnabled']);
    }

    public function getCoreModules()
    {
        return array_filter($this->definitions, [$this, 'filterCore']);
    }

    /**
     * Returns a module instance by id
     *
     * @param string $id Module Id
     * @param boolean $forceDisabled force if module disabled
     * @return \yii\base\Module
     * @throws Exception
     * @throws InvalidConfigException
     */
    public function getModule($id, $forceDisabled = false)
    {
        if (!isset($this->definitions[$id])) {
            throw new Exception("Could not find requested module: {$id}");
        }

        if (Yii::$app->hasModule($id)) {
            return Yii::$app->getModule($id);
        }

        if ($forceDisabled) {
            /** @var ModuleDefinition $definition */
            $definition = $this->definitions[$id];

            $definition->register();

            return Yii::$app->getModule($id);
        }

        return null;
    }

    /**
     * Callback for filtering only enabled modules
     * @param ModuleDefinition $definition
     * @return bool
     */
    protected function filterEnabled(ModuleDefinition $definition)
    {
        return in_array($definition->id, $this->enabledIds);
    }

    /**
     * Callback for filtering only core modules
     * @param ModuleDefinition $definition
     * @return bool
     */
    protected function filterCore(ModuleDefinition $definition)
    {
        return $definition->isCore();
    }
}
