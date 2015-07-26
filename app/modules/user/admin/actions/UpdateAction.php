<?php

namespace app\modules\user\admin\actions;

use Yii;
use yii\base\Event;
use yii\helpers\ArrayHelper;
use yii\web\Response;
use yii\widgets\ActiveForm;

class UpdateAction extends Action
{
    public $scenario = 'admin-update';
    public $modelClass = 'app\modules\user\models\User';
    public $profileRelation = 'profile';

    public $viewFile = 'update';

    public $statusArray;
    public $roleArray;

    /**
     * Delete user page.
     *
     * @param integer $id User ID
     *
     * @return mixed View
     */
    public function run($id)
    {
        $request = Yii::$app->request;
        $user = $this->findModel($id);
        $user->scenario = $this->scenario;
        $profile = $user->{$this->profileRelation};

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
                $user->populateRelation($this->profileRelation, $profile);
                if (!$user->save(false)) {
                    $this->trigger('danger', new Event([
                        'data' => $user
                    ]));
                    //Yii::$app->session->setFlash('danger', Module::t('admin', 'Failed update user'));
                }
                return $this->controller->refresh();
            } elseif ($request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return array_merge(ActiveForm::validate($user), ActiveForm::validate($profile));
            }
        }

        return $this->render(compact(['user', 'profile', 'roleArray', 'statusArray']));
    }
}
