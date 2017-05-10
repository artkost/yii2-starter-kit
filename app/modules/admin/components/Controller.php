<?php

namespace app\modules\admin\components;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller as BaseController;

class Controller extends BaseController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['viewAdminPanel']
                    ]
                ]
            ]
        ];
    }

    public function getModule()
    {
        return Yii::$app->getModule('admin');
    }
}