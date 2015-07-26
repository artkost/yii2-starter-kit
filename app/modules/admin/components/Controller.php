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

    public function beforeAction($action)
    {
        $user = Yii::$app->user;

        if (parent::beforeAction($action)) {
            if ($user->isGuest) {
                $user->loginRequired();
            }

            return true;
        }

        return false;
    }

    public function getModule()
    {
        return Yii::$app->getModule('admin');
    }
}