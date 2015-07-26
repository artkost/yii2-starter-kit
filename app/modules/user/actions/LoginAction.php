<?php

namespace app\modules\user\actions;

use Yii;
use yii\web\Response;
use yii\widgets\ActiveForm;

class LoginAction extends Action
{

    public $viewFile = 'login';
    public $modelClass = 'app\modules\user\forms\Login';

    /**
     * Sign In page.
     */
    public function run()
    {
        if (!Yii::$app->user->isGuest) {
            $this->controller->goHome();
        }

        $model = Yii::createObject($this->modelClass);
        $post = Yii::$app->request->post();

        if ($model->load($post)) {
            if ($model->validate()) {
                if ($model->login()) {
                    return $this->controller->goHome();
                }
            } elseif (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
        }

        return $this->render(compact('model'));
    }
}
