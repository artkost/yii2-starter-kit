<?php

namespace app\modules\admin\admin\controllers;

use app\base\ModuleManager;
use app\models\ModuleDefinition;
use app\modules\admin\components\Controller;
use Yii;

class ModulesController extends Controller
{
    public function actionIndex()
    {
        $dm = $this->getModuleManager();
        /** @var ModuleDefinition[] $definitions */
        $definitions = $dm->getModules();

        $modules = [];

        foreach ($definitions as $definition) {
            if (!isset($modules[$definition->package])) {
                $modules[$definition->package] = [];
            }

            $modules[$definition->package][] = [
                'name' => $definition->name,
                'required' => $definition->required
            ];
        }

        return $this->render('index', compact('modules'));
    }

    public function actionRefresh()
    {
        $this->getModuleManager()->flushConfigs();
        $this->goBack(['index']);
    }

    /**
     * @return ModuleManager
     * @throws \yii\base\InvalidConfigException
     */
    public function getModuleManager()
    {
        return Yii::$app->get('moduleManager');
    }
}