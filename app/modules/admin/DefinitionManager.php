<?php

namespace app\modules\admin;

use Yii;
use yii\base\Component;
use app\modules\admin\models\ModuleDefinition;
use yii\base\Module as BaseModule;
use yii\caching\TagDependency;

/**
 * This Manager loads definition files from
 * modules folders and collects info about it
 *
 * Class DefinitionManager
 * @package app\modules\admin
 */
class DefinitionManager extends Component
{
    const DEFINITION_FILE = 'admin.php';

    const CACHE_KEY = 'adminModuleDefinition';
    const CACHE_TAG = 'adminModuleDefinition';

    public $cacheDuration = 604800;

    protected $definitions = [];

    public function init()
    {
        parent::init();
        $this->initModulesDefinitions();
    }

    /**
     * @return ModuleDefinition[]
     */
    protected function initModulesDefinitions()
    {
        foreach (Yii::$app->getModules() as $id => &$config) {
            /** @var BaseModule $module */
            $definition = $this->getModuleDefinition($id, $config);

            if ($definition) {
                $this->definitions[] = $definition;
            }
        }
    }

    public function getModulesDefinitions()
    {
        return $this->definitions;
    }

    /**
     * @param $id
     * @param array $config
     * @return ModuleDefinition|bool
     */
    public function getModuleDefinition($id, $config = [])
    {
        if (is_array($config) && isset($config['admin']) && is_array($config['admin'])) {
            $definition = $config['admin'];
        } else {
            $module = Yii::$app->getModule($id);

            if (isset($module->admin) && is_array($module->admin)) {
                $definition = $module->admin;
            } else {
                $definition = $module->getBasePath() . DIRECTORY_SEPARATOR . self::DEFINITION_FILE;
            }
        }

        return $this->createModuleDefinition($definition);
    }

    /**
     * @param $path
     * @return ModuleDefinition|bool
     */
    public function createModuleDefinition($path)
    {
        $rules = false;

        $cached = $this->getCache()->get(self::CACHE_KEY . ':' . $path);
        $dependency = Yii::createObject(TagDependency::className(), ['tags' => [self::CACHE_TAG]]);

        if ($cached) {
            $rules = $cached;
        } else {
            if (is_array($path)) {
                $rules = $path;
            } elseif (file_exists($path)) {
                $rules = include $path;
            }
        }

        if (is_array($rules)) {
            $this->getCache()->set(self::CACHE_KEY . ':' . $path, $rules, $this->cacheDuration, $dependency);
            return new ModuleDefinition($rules);
        }

        return false;
    }

    public function refreshDefinitions()
    {
        TagDependency::invalidate($this->getCache(), [self::CACHE_TAG]);
    }

    /**
     * @return \yii\caching\Cache
     */
    protected function getCache()
    {
        return Yii::$app->cache;
    }
}
