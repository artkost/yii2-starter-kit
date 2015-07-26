<?php

namespace app\modules\comment\actions;

use app\modules\comment\Module;
use Yii;
use yii\db\ActiveRecord;
use yii\widgets\ActiveForm;

class ViewAction extends Action
{
    public function run()
    {
        $modelClass = $this->modelClass;

        /** @var ActiveRecord $model */
        $model = new $modelClass(['scenario' => 'create']);

        if ($this->checkAccess) {
            call_user_func($this->checkAccess, $model);
        }

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                if ($model->save(false)) {
                    return $this->tree($model);
                } else {
                    Yii::$app->response->setStatusCode(500);

                    return Module::t('comment', 'FRONTEND_FLASH_FAIL_CREATE');
                }
            } elseif (Yii::$app->request->isAjax) {
                Yii::$app->response->setStatusCode(400);

                return ActiveForm::validate($model);
            }
        }
    }

    /**
     * @param Comment $model Comment
     *
     * @return string Comments list
     */
    protected function tree($model)
    {
        $models = Comment::getTree($model->model_id, $model->model_class);
        return $this->renderPartial('@app/modules/comment/widgets/views/_index_item', ['models' => $models]);
    }
}
