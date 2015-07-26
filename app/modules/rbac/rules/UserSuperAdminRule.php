<?php
namespace app\modules\rbac\rules;

use Yii;
use yii\rbac\Rule;

class UserSuperAdminRule extends Rule
{
    public $name = 'superAdmin';
    public $role = '';

    public function execute($user, $item, $params)
    {
        var_dump([$user, $item, $params]);
        die();
        if ($user && $item->name == $this->role) {
            return true;
        }

        return false;
    }
}