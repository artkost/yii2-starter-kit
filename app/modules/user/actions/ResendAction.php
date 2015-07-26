<?php

namespace app\modules\user\actions;

use app\modules\user\Module;
use Yii;
use yii\base\Event;
use yii\web\Response;
use yii\widgets\ActiveForm;

class ResendAction extends Action
{
    public $viewFile = 'resend';
    public $modelClass = 'app\modules\user\forms\Resend';

    /**
     * Resend email confirmation token page.
     */
    public function run()
    {
        $model = Yii::createObject($this->modelClass);
        $post = Yii::$app->request->post();

        if ($model->load($post)) {
            if ($model->validate()) {
                if ($model->resend()) {
                    $this->trigger('success', new Event([
                        'data' => Module::t('model', 'On the specified email address was sent a letter with an activation code for new account.')
                    ]));

                    return $this->controller->goHome();
                } else {
                    $this->trigger('danger', new Event([
                        'data' => Module::t('model', 'Failed send email with activation code. Please try again later.')
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
