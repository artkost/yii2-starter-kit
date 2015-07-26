<?php

namespace app\modules\user\admin\models;

use app\modules\user\models\User as Base;

class User extends Base
{
    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['admin-create'] = ['username', 'email', 'password', 'repassword'];
        $scenarios['admin-update'] = ['username', 'email', 'password', 'repassword'];

        return $scenarios;
    }
}
