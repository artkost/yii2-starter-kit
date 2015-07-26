<?php

namespace app\modules\user\actions;

use app\modules\user\Module;
use Yii;
use yii\base\Event;

class ActivationAction extends Action
{

    public $modelClass = 'app\modules\user\forms\Activation';

    /**
     * Activate a new user page.
     *
     * @param string $token Activation token.
     *
     * @return mixed View
     */
    public function run($token)
    {
        $model = Yii::createObject($this->modelClass, ['token' => $token]);

        if ($model->validate() && $model->activate()) {
            $this->trigger('success', new Event([
                'data' => Module::t('model', 'You successfully activated your account.')
            ]));
        } else {
            $this->trigger('danger', new Event([
                'data' => Module::t('model', 'Account activation failed.')
            ]));
        }

        return $this->controller->goHome();
    }
}
