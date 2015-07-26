<?php

namespace app\modules\rbac\admin\controllers;

use app\modules\admin\components\Controller;
use app\modules\rbac\DefinitionManager;
use app\modules\rbac\models\RbacDefinition;
use Yii;
use yii\filters\VerbFilter;

class PermissionsController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['access']['rules'] = [
            [
                'allow' => true,
                'actions' => ['index'],
                'roles' => ['adminAssignmentView']
            ],
            [
                'allow' => true,
                'actions' => ['create'],
                'roles' => ['adminAssignmentCreate']
            ],
            [
                'allow' => true,
                'actions' => ['update'],
                'roles' => ['adminAssignmentUpdate']
            ],
            [
                'allow' => true,
                'actions' => ['delete', 'batch-delete'],
                'roles' => ['adminAssignmentDelete']
            ]
        ];

        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'index' => ['get'],
                'create' => ['get', 'post'],
                'update' => ['get', 'put', 'post'],
                'delete' => ['post', 'delete'],
                'batch-delete' => ['post', 'delete']
            ]
        ];

        return $behaviors;
    }

    public function actionIndex()
    {
        /** @var DefinitionManager $dm */
        $dm = $this->module->get('definitionManager');

        /** @var RbacDefinition[] $definitions */
        $definitions = $dm->getDefinitions();

        $permissions = [];
        foreach ($definitions as $definition) {

            if (!isset($permissions[$definition->module])) {
                $permissions[$definition->module] = [];
            }

            $permissions[$definition->module] = $definition;
        }

        return $this->render('index', compact('permissions'));
    }
}
