<?php

namespace app\modules\user\admin\actions;

use Yii;
use yii\web\HttpException;

class BatchDeleteAction extends Action
{
    public $redirectRoute = 'index';
    public $viewFile = 'create';
    public $modelClass = 'app\modules\user\models\User';

    /**
     * Batch Delete
     */
    public function run()
    {
        $ids = Yii::$app->request->post('ids');
        $modelClass = $this->modelClass;

        if ($ids !== null) {
            $models = $modelClass::find()->where('id', $ids)->all();

            foreach ($models as $model) {
                $model->delete();
            }

            return $this->controller->redirect([$this->redirectRoute]);
        } else {
            throw new HttpException(400);
        }
    }
}
