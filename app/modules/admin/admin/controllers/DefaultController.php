<?php

namespace app\modules\admin\admin\controllers;

use app\modules\admin\components\Controller;
use app\modules\admin\DefinitionManager;
use app\modules\admin\models\ModuleDefinition;
use Yii;

class DefaultController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['access']['rules'][] = [
            'allow' => true,
            'actions' => ['error'],
            'roles' => ['?']
        ];

        return $behaviors;
    }

    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            if ($action->id == 'error' && Yii::$app->user->isGuest) {
                $this->layout = '//guest';
            }

            return true;
        }

        return false;
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction'
            ]
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionPreview()
    {
        return $this->render('preview');
    }

    public function actionModules()
    {
        $request = Yii::$app->request;
        /** @var DefinitionManager $dm */
        $dm = $this->module->get('definitionManager');

        if ($request->get('refresh', false)) {
            $dm->refreshDefinitions();
            $this->redirect(['modules']);
        }

        /** @var ModuleDefinition[] $definitions */
        $definitions = $dm->getModulesDefinitions();

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

        return $this->render('modules', compact('modules'));
    }
}
