<?php

namespace app\modules\user\controllers;

use app\modules\user\actions as Actions;
use app\web\Controller;
use Yii;

class DefaultController extends Controller
{
    public function actions()
    {
        return [
            'logout' => [
                'class' => Actions\LogoutAction::className()
            ],
            'login' => [
                'class' => Actions\LoginAction::className()
            ],
            'signup' => [
                'class' => Actions\SignupAction::className(),
                'resendRoute' => ['/user/default/resend']
            ],
            'resend' => [
                'class' => Actions\ResendAction::className()
            ],
            'activation' => [
                'class' => Actions\ActivationAction::className()
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
