<?php

namespace app\modules\user\admin\controllers;

use app\modules\user\actions as Actions;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

/**
 * Backend controller for guest users.
 */
class DefaultController extends Controller
{
    /**
     * @inheritdoc
     */
    public $layout = '//guest';

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
                        'roles' => ['?']
                    ],
                    [
                        'allow' => true,
                        'actions' => ['logout']
                    ]
                ]
            ]
        ];
    }

    public function actions()
    {
        return [
            'logout' => [
                'class' => Actions\LogoutAction::className()
            ],
            'login' => [
                'class' => Actions\LoginAction::className()
            ],
            'recovery' => [
                'class' => Actions\RecoveryAction::className()
            ],
            'recovery-confirmation' => [
                'class' => Actions\RecoveryConfirmationAction::className()
            ]
        ];
    }
}
