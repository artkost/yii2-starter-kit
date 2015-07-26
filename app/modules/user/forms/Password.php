<?php

namespace app\modules\user\forms;

use app\modules\user\models\User;
use app\modules\user\Module;
use Yii;
use yii\base\Model;

/**
 * Class PasswordForm
 * PasswordForm is the model behind the change password form.
 *
 * @property string $password Password
 * @property string $repassword Repeat password
 * @property string $oldpassword Current password
 */
class Password extends Model
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
     * @var string Current password
     */
    public $oldpassword;

    /**
     * @var User User instance
     */
    private $_user;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // Required
            [['password', 'repassword', 'oldpassword'], 'required'],
            // Trim
            [['password', 'repassword', 'oldpassword'], 'trim'],
            // String
            [['password', 'repassword', 'oldpassword'], 'string', 'min' => 6, 'max' => 30],
            // Password
            ['password', 'compare', 'compareAttribute' => 'oldpassword', 'operator' => '!=='],
            // Repassword
            ['repassword', 'compare', 'compareAttribute' => 'password'],
            // Oldpassword
            ['oldpassword', 'validateOldPassword']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'password' => Module::t('model', 'New password'),
            'repassword' => Module::t('model', 'Retype new password'),
            'oldpassword' => Module::t('model', 'Old password')
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     */
    public function validateOldPassword($attribute, $params)
    {
        $user = $this->getUser();

        if (!$user || !$user->validatePassword($this->$attribute)) {
            $this->addError($attribute, Module::t('model', 'Invalid old password'));
        }
    }

    /**
     * Change user password.
     *
     * @return boolean true if password was successfully changed
     */
    public function changePassword()
    {
        if (($model = $this->getUser()) !== null) {
            return $model->changePasswordAndSave($this->password);
        }
        return false;
    }

    /**
     * Finds user by id.
     *
     * @return User|null User instance
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::find()
                ->where(['id' => Yii::$app->user->identity->id])
                ->active()->one();
        }

        return $this->_user;
    }
}
