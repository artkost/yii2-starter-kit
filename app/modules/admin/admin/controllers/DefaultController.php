<?php

namespace app\modules\admin\admin\controllers;

use app\base\ModuleManager;
use app\modules\admin\components\Controller;
use app\modules\admin\DefinitionManager;
use app\models\ModuleDefinition;
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
        /** @var ModuleManager $dm */
        $dm = Yii::$app->get('moduleManager');

        if ($request->get('refresh', false)) {
            $dm->flushConfigs();
            $this->redirect(['modules']);
        }

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

        return $this->render('modules', compact('modules'));
    }
}
