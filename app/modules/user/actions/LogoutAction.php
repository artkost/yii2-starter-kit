<?php

namespace app\modules\user\actions;

use Yii;

class LogoutAction extends Action
{
    public $modelClass = 'FakeLogout';

    /**
     * Logout user.
     */
    public function run()
    {
        Yii::$app->user->logout();

        return $this->controller->goHome();
    }
}
