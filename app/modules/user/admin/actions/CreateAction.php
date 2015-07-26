<?php

namespace app\modules\user\admin\actions;

use app\modules\user\Module;
use Yii;
use yii\base\Event;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\Response;
use yii\widgets\ActiveForm;

class CreateAction extends Action
{
    public $updateRoute = 'update';
    public $scenario = 'admin-create';

    public $viewFile = 'create';
    public $modelClass = 'app\modules\user\models\User';
    public $profileClass = 'app\modules\user\models\UserProfile';

    public $roleArray;
    public $statusArray;

    public function run()
    {
        $request = Yii::$app->request;
        $user = Yii::createObject($this->modelClass, ['scenario' => $this->scenario]);
        $profile = Yii::createObject($this->profileClass);

        $roles = [];
        if ($this->roleArray !== null) {
            $roles =  call_user_func($this->roleArray, $this);
        }
        $roleArray = ArrayHelper::map($roles, 'name', 'description');

        $statusArray = [];
        if ($this->statusArray !== null) {
            $statusArray =  call_user_func($this->statusArray, $this);
        }

        if ($user->load($request->post()) && $profile->load($request->post())) {
            if ($user->validate() && $profile->validate()) {
                $user->populateRelation('profile', $profile);
                if ($user->save(false)) {
                    $this->trigger('success', new Event([
                        'data' => $user
                    ]));
                    return $this->controller->redirect(Url::to([$this->updateRoute, 'id' => $user->id]));
                } else {
                    $this->trigger('success', new Event([
                        'data' => Module::t('admin', 'Failed create user')
                    ]));
                    return $this->controller->refresh();
                }
            } elseif ($request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return array_merge(ActiveForm::validate($user), ActiveForm::validate($profile));
            }
        }

        return $this->render(compact([
            'user' ,
            'profile',
            'roleArray',
            'statusArray'
        ]));
    }
}
