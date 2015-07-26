<?php

namespace app\modules\page\admin\controllers;

use app\modules\admin\components\Controller;
use app\modules\page\admin\actions\BatchDeleteAction;
use app\modules\page\admin\actions\CreateAction;
use app\modules\page\admin\actions\DeleteAction;
use app\modules\page\admin\actions\IndexAction;
use app\modules\page\admin\actions\UpdateAction;
use app\modules\page\models\PagePost;
use app\modules\page\models\PagePostSearch;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

class DefaultController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['access']['rules'] = ArrayHelper::merge($behaviors['access']['rules'], [
            [
                'allow' => true,
                'actions' => ['index'],
                'roles' => ['pageView']
            ],
            [
                'allow' => true,
                'actions' => ['create'],
                'roles' => ['pageCreate']
            ],
            [
                'allow' => true,
                'actions' => ['update'],
                'roles' => ['pageUpdate']
            ],
            [
                'allow' => true,
                'actions' => ['delete', 'batch-delete'],
                'roles' => ['pageDelete']
            ]
        ]);

        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'index' => ['get'],
                'update' => ['get', 'put', 'post'],
                'delete' => ['post', 'delete'],
                'batch-delete' => ['post', 'delete']
            ]
        ];

        return $behaviors;
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'index' => [
                'class' => IndexAction::className(),
                'modelClass' => PagePostSearch::className()
            ],
            'create' => [
                'class' => CreateAction::className(),
                'modelClass' => PagePost::className(),
                'scenario' => 'create'
            ],
            'update' => [
                'class' => UpdateAction::className(),
                'modelClass' => PagePost::className(),
                'scenario' => 'update'
            ],
            'delete' => [
                'class' => DeleteAction::className(),
                'modelClass' => PagePost::className(),
                'scenario' => 'delete'
            ],
            'batch-delete' => [
                'class' => BatchDeleteAction::className(),
                'modelClass' => PagePost::className(),
                'scenario' => 'delete'
            ],
        ];
    }
}