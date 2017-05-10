<?php

namespace app\modules\admin\admin\controllers;

use app\base\ModuleManager;
use app\modules\admin\components\Controller;
use Yii;

class DefaultController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        if (isset($behaviors['access'])) {
            array_unshift($behaviors['access']['rules'], [
                'allow' => true,
                'roles' => ['?'],
                'actions' => ['error']
            ]);
        }

        return $behaviors;
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

    public function beforeAction($action)
    {
        $user = Yii::$app->get('user');

        if ($action->id == 'error') {
            if ($user->isGuest) {
                $this->layout = '//guest';
            }
        }

        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionPreview()
    {
        return $this->render('preview');
    }
}
