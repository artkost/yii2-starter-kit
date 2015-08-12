<?php

namespace app\modules\user\models;

use app\modules\rbac\models\RbacAssignment;
use app\modules\user\Module;
use Yii;
use yii\rbac\DbManager;

/**
 * Class User
 * User is the model behind the signup form.
 *
 * @property string $username Username
 * @property string $email E-mail
 * @property string $password Password
 * @property string $repassword Repeat password
 *
 * @property DbManager $auth
 */
class User extends UserBase
{
    /**
     * @var string $password Password
     */
    public $password;

    /**
     * @var string $repassword Repeat password
     */
    public $repassword;

    /**
     * @return \yii\rbac\Role[]
     */
    public static function roles()
    {
        return Yii::$app->authManager->getRoles();
    }

    /**
     * @return array Status array.
     */
    public static function statusLabels()
    {
        return [
            self::STATUS_ACTIVE => Module::t('model', 'Active'),
            self::STATUS_INACTIVE => Module::t('model', 'Inactive'),
            self::STATUS_BANNED => Module::t('model', 'Banned')
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // Required
            [['username', 'email', 'password', 'repassword'], 'required'],

            // Trim
            [['username', 'email', 'password', 'repassword'], 'trim'],

            // String
            [['password', 'repassword'], 'string', 'min' => 6, 'max' => 30],

            // Unique
            [['username', 'email'], 'unique'],

            // Username
            //['username', 'match', 'pattern' => '/^[a-zA-Z0-9_-]+$/'],
            ['username', 'string', 'min' => 3, 'max' => 30],

            // E-mail
            ['email', 'string', 'max' => 100],
            ['email', 'email'],

            // Repassword
            ['repassword', 'compare', 'compareAttribute' => 'password']
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            'signup' => ['username', 'email', 'password', 'repassword'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        $labels = parent::attributeLabels();

        return array_merge($labels, [
            'password' => Module::t('model', 'Password'),
            'repassword' => Module::t('model', 'Repeat Password')
        ]);
    }

    /**
     * @return string Model status.
     */
    public function getStatus()
    {
        return self::statusLabels()[$this->status_id];
    }

    /**
     * @return \yii\rbac\Role[]
     */
    public function getRoles()
    {
        return Yii::$app->authManager->getRolesByUser($this->id);
    }

    /**
     * @return UserProfile|null User profile
     */
    public function getAssignments()
    {
        return $this->hasMany(RbacAssignment::className(), ['user_id' => 'id'])->inverseOf('user');
    }

    public function getFullName()
    {
        return $this->profile ? $this->profile->fullName : $this->username;
    }

    public function getAvatarUrl()
    {
        if ($this->profile && $this->profile->avatar) {
            return $this->profile->avatar->url;
        } else {
            return Module::avatarDefaultUrl();
        }
    }

    /**
     * @return \yii\rbac\ManagerInterface
     */
    public static function getAuth()
    {
        return Yii::$app->authManager;
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->setPassword($this->password);
            }
            return true;
        }
        return false;
    }

    /**
     * @inheritdoc
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        if ($insert) {
            $this->saveProfile();
            $this->assignDefaultRole();
        }
    }

    public function afterDelete()
    {
        parent::afterDelete();

        $this->revokeDefaultRole();
    }

    public function saveProfile()
    {
        if ($this->profile !== null) {
            return $this->profile->save(false);
        }

        return false;
    }

    public function assignDefaultRole($role = self::ROLE_DEFAULT)
    {
        return self::getAuth()->assign(self::getAuth()->getRole($role), $this->id);
    }

    public function revokeDefaultRole($role = self::ROLE_DEFAULT)
    {
        return self::getAuth()->revoke(self::getAuth()->getRole($role), $this->id);
    }

}
