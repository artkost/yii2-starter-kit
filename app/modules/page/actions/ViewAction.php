<?php

namespace app\modules\page\actions;


use app\modules\page\models\PostBase;
use Closure;
use Yii;
use yii\web\Cookie;
use yii\web\HttpException;

class ViewAction extends Action
{
    public function run($id, $alias)
    {
        $modelClass = $this->modelClass;

        if ($this->query instanceof Closure) {
            $fn = $this->query;
            $query = $fn();
        } else {
            $query = $modelClass::find()->published();
        }

        $model = $query->andWhere(['id' => $id, 'alias' => $alias])->one();

        if ($this->checkAccess !== null) {
            return call_user_func($this->checkAccess, $this, $model);
        }

        if ($model !== null) {
            $this->updateViews($model);

            return $this->controller->render('view', [
                'model' => $model
            ]);
        } else {
            throw new HttpException(404);
        }
    }

    /**
     * Update blog views counter.
     *
     * @param PostBase $model Model
     */
    protected function updateViews($model)
    {
        $cookieName = 'page-view-views';
        $shouldCount = false;
        $views = Yii::$app->request->cookies->getValue($cookieName);

        if ($views !== null) {
            if (is_array($views)) {
                if (!in_array($model->id, $views)) {
                    $views[] = $model->id;
                    $shouldCount = true;
                }
            } else {
                $views = [$model->id];
                $shouldCount = true;
            }
        } else {
            $views = [$model->id];
            $shouldCount = true;
        }

        if ($shouldCount === true) {
            if ($model->updateViews()) {
                Yii::$app->response->cookies->add(new Cookie([
                    'name' => $cookieName,
                    'value' => $views,
                    'expire' => time() + 86400 * 365
                ]));
            }
        }
    }
} 
