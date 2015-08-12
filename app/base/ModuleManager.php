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
 * Manages and bootstraps modules
 * Class ModuleManager
 * @package app\modules\admin
 */
class ModuleManager extends Component implements BootstrapInterface
{
    const CACHE_CONFIG_ID = 'ModuleManagerConfigs';
    const CACHE_ENABLED = 'ModuleManagerEnabled';

    const DEFINITION_FILE = 'config.php';

    /**
     * List of all modules
     * This also contains installed but not enabled modules.
     *
     * @param ModuleDefinition[] $config moduleId-class pairs
     */
    protected $modules;

    /**
     * List of all enabled module ids
     *
     * @var string[]
     */
    protected $enabledModules = [];

    /**
     * List of core module classes.
     *
     * @var ModuleDefinition[] the core module class names
     */
    protected $coreModules = [];

    public function bootstrap($app)
    {
        $configs = $app->cache->get(self::CACHE_CONFIG_ID);

        if ($configs === false) {
            $configs = [];
            $paths = ArrayHelper::getValue(Yii::$app->params, 'modules.path', ['@app/modules']);

            foreach ($paths as $alias) {
                $path = Yii::getAlias($alias);
                $files = FileHelper::findFiles($path, [
                    'only' => ['*/' . self::DEFINITION_FILE]
                ]);

                foreach ($files as $file) {
                    try {
                        $config = require($file);
                        $config['basePath'] = dirname($file);
                        $configs[] = $config;
                    } catch (Exception $e) {
                        Yii::trace("Failed loading module config.php file: {$e->getMessage()}", __METHOD__);
                    }
                }

                usort($configs, function ($configA, $configB) {
                    if (isset($configA['weight'], $configB['weight'])) {
                        return (int) $configA['weight'] > (int) $configB['weight'];
                    }

                    return 0;
                });
            }

            if (!YII_DEBUG && !empty($configs)) {
                $app->cache->set(self::CACHE_CONFIG_ID, $configs);
            }
        }

        $app->get('moduleManager')->registerModules($configs);
    }

    /**
     * Module Manager init
     *
     * Loads all enabled moduleId's from database
     */
    public function init()
    {
        parent::init();

        if (!Yii::$app->params['installed']) {
            return;
        }

        $this->enabledModules = self::getEnabledIds();
    }

    /**
     * @return mixed
     */
    public static function getEnabledIds()
    {
        $ids = Yii::$app->cache->get(self::CACHE_ENABLED);

        return $ids ? $ids : [];
    }

    /**
     * Flushes module manager configs cache
     */
    public function flushConfigs()
    {
        Yii::$app->cache->delete(self::CACHE_CONFIG_ID);
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

        if (isset($this->modules[$id])) {
            return;
        }

        $this->modules[$id] = new ModuleDefinition($config);

        if ($this->modules[$id]->required) {
            $this->enabledModules[] = $id;
        }

        // Not enabled and not core module
        if (!$this->modules[$id]->isCore() && !in_array($id, $this->enabledModules)) {
            return;
        }

        if ($this->modules[$id]->isCore()) {
            $this->coreModules[$id] = $this->modules[$id];
        }

        $this->modules[$id]->register();
    }

    public function getModules()
    {
        return $this->modules;
    }

    public function getEnabledModules()
    {
        return array_filter($this->modules, [$this, 'filterEnabled']);
    }

    protected function filterEnabled(ModuleDefinition $definition)
    {
        return in_array($definition->id, $this->enabledModules);
    }

    /**
     * Returns a module instance by id
     *
     * @param string $id Module Id
     * @param boolean $disabled
     * @return \yii\base\Module
     * @throws Exception
     * @throws InvalidConfigException
     */
    public function getModule($id, $disabled = false)
    {
        if (!isset($this->modules[$id])) {
            throw new Exception("Could not find requested module: {$id}");
        }

        if (Yii::$app->hasModule($id)) {
            return Yii::$app->getModule($id);
        }

        if ($disabled) {
            $this->modules[$id]->register();

            return Yii::$app->getModule($id);
        }

        return null;
    }
}
