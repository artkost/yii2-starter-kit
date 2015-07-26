<?php

namespace app\modules\user\admin\actions;

class DeleteAction extends Action
{
    public $redirectRoute = 'index';
    public $viewFile = 'create';
    public $modelClass = 'app\modules\user\models\User';

    /**
     * Delete user page.
     *
     * @param integer $id User ID
     *
     * @return mixed View
     */
    public function run($id)
    {
        $this->findModel($id)->delete();
        return $this->controller->redirect([$this->redirectRoute]);
    }
}
