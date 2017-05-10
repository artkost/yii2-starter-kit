<?php

namespace app\modules\rbac\components;

use Yii;
use yii\helpers\ArrayHelper;
use yii\rbac\DbManager;
use yii\web\User as WebUser;

class User extends WebUser
{
    const SUPER_ADMIN_ROLE = 'superAdmin';

    /**
     * Result of superAdminRole check
     * @var boolean
     */
    protected $superAdminCheck;

    /**
     * Set of permissions available for default roles
     * @var
     */
    protected $defaultRolePermissions;

    /**
     * @inheritdoc
     */
    public function can($permissionName, $params = [], $allowCaching = true)
    {
        return $this->isSuperAdmin() || $this->isGuestCan($permissionName) || parent::can($permissionName, $params, $allowCaching);
    }

    protected function isSuperAdmin()
    {
        /** @var DbManager $auth */
        $auth = Yii::$app->getAuthManager();

        if (is_null($this->superAdminCheck)) {
            $this->superAdminCheck = $auth->getAssignment(self::SUPER_ADMIN_ROLE, $this->getId());
        }

        return (bool) $this->superAdminCheck;
    }

    protected function isGuestCan($permissionName)
    {
        /** @var DbManager $authManager */
        $authManager = Yii::$app->getAuthManager();

        if ($this->defaultRolePermissions == null) {
            foreach ($authManager->defaultRoles as $roleName) {
                $this->defaultRolePermissions[$roleName] = ArrayHelper::index($authManager->getPermissionsByRole($roleName), 'name');
            }
        }

        foreach ($authManager->defaultRoles as $roleName) {
            return isset($this->defaultRolePermissions[$roleName][$permissionName]);
        }

        return false;
    }
}