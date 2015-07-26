<?php

namespace app\modules\comment\admin\actions;

use app\modules\page\actions\Action;
use Yii;
use yii\base\Model;
use yii\db\ActiveRecordInterface;
use yii\widgets\ActiveForm;

class UpdateAction extends Action
{

    /**
     * @var string the scenario to be assigned to the model before it is validated and updated.
     */
    public $scenario = Model::SCENARIO_DEFAULT;

    public function run($id)
    {
        $model = $this->findModel($id);

        if ($this->checkAccess) {
            call_user_func($this->checkAccess, $this->id, $model);
        }

        $model->scenario = $this->scenario;

        /* @var $modelClass ActiveRecordInterface */
        $modelClass = $this->modelClass;

        $statusArray = $modelClass::statusLabels();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                if ($model->save(false)) {
                    return $this->refresh();
                } else {
                    Yii::$app->session->setFlash('danger', Module::t('admin', 'BACKEND_FLASH_FAIL_ADMIN_UPDATE'));
                    return $this->refresh();
                }
            } elseif (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'statusArray' => $statusArray
        ]);
    }
} 