<?php

namespace app\modules\user\actions;

use app\modules\user\Module;
use Yii;
use yii\base\Event;
use yii\web\Response;
use yii\widgets\ActiveForm;

class RecoveryConfirmationAction extends Action
{

    public $viewFile = 'recovery-confirmation';
    public $modelClass = 'app\modules\user\forms\RecoveryConfirmation';

    /**
     * Confirm password recovery request page.
     *
     * @param string $token Confirmation token
     *
     * @return mixed View
     */
    public function run($token)
    {
        $model = Yii::createObject($this->modelClass, ['token' => $token]);

        if (!$model->isValidToken()) {
            $this->trigger('danger', new Event([
                'data' => Module::t('model', 'Invalid recovery code.')
            ]));
            return $this->controller->goHome();
        }

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                if ($model->recovery()) {
                    $this->trigger('success', new Event([
                        'data' => Module::t('model', 'Success! Password was changed.')
                    ]));
                    return $this->controller->goHome();
                } else {
                    $this->trigger('danger', new Event([
                        'data' => Module::t('model', 'Failed reset password. Try again later.')
                    ]));
                    return $this->controller->refresh();
                }
            } elseif (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
        }

        return $this->render(compact('model'));
    }
}
