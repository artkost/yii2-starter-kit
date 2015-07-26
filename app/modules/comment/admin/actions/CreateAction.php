<?php

namespace app\modules\comment\admin\actions;

use app\modules\comment\actions\Action;
use app\modules\comment\Module;
use Yii;
use yii\widgets\ActiveForm;

class CreateAction extends Action
{
    public function run()
    {
        $modelClass = $this->modelClass;
        $model = new $modelClass(['scenario' => 'create']);
        $statusArray = $modelClass::statusLabels();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                if ($model->save(false)) {
                    return $this->controller->redirect(['update', 'id' => $model->id]);
                } else {
                    Yii::$app->session->setFlash('danger', Module::t('admin', 'BACKEND_FLASH_FAIL_ADMIN_CREATE'));
                    return $this->controller->refresh();
                }
            } elseif (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
        }

        return $this->controller->render('create', [
            'model' => $model,
            'statusArray' => $statusArray
        ]);
    }
} 