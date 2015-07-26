<?php

namespace app\modules\page\admin\actions;

use app\modules\page\actions\Action;
use app\modules\page\models\PostBase;
use app\modules\page\Module;
use Yii;
use yii\web\Response;
use yii\widgets\ActiveForm;

class UpdateAction extends Action
{

    public function run($id)
    {
        /** @var PostBase $model */
        $model = $this->findModel((int)$id);

        if ($this->checkAccess) {
            call_user_func($this->checkAccess, $this->id, $model);
        }

        $model->scenario = $this->scenario;

        /* @var $modelClass PostBase */
        $modelClass = $this->modelClass;

        $statusArray = $modelClass::statusLabels();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                if ($model->save(false)) {
                    return $this->controller->refresh();
                } else {
                    Yii::$app->session->setFlash('danger', Module::t('admin', 'BACKEND_FLASH_FAIL_ADMIN_UPDATE'));
                    return $this->controller->refresh();
                }
            } elseif (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
        }

        return $this->controller->render('update', [
            'model' => $model,
            'statusArray' => $statusArray
        ]);
    }
} 