<?php

namespace app\modules\user\actions;

use app\modules\user\Module;
use Yii;
use yii\base\Event;
use yii\web\Response;
use yii\widgets\ActiveForm;

class RecoveryAction extends Action
{
    public $viewFile = 'recovery';
    public $modelClass = 'app\modules\user\forms\Recovery';

    /**
     * Request password recovery page.
     */
    public function run()
    {
        $model = Yii::createObject($this->modelClass);
        $post = Yii::$app->request->post();

        if ($model->load($post)) {
            if ($model->validate()) {
                if ($model->recovery()) {
                    $this->trigger('success', new Event([
                        'data' => Module::t('model', 'You successfully recovered your account.')
                    ]));
                    return $this->controller->goHome();
                } else {
                    $this->trigger('success', new Event([
                        'data' => Module::t('model', 'Account recovery failed.')
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
