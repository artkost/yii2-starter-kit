<?php

namespace app\modules\admin\admin\controllers;

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
}
