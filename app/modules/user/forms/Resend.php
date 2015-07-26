<?php

namespace app\modules\user\forms;

use app\modules\user\models\User;
use app\modules\user\Module;
use Yii;
use yii\base\Model;

/**
 * Class ResendForm
 *
 * @property string $email E-mail
 */
class Resend extends Model
{

    /**
     * @var string $email E-mail
     */
    public $email;

    /**
     * @var User User instance
     */
    private $_model;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // E-mail
            ['email', 'required'],
            ['email', 'trim'],
            ['email', 'email'],
            ['email', 'string', 'max' => 100],
            [
                'email',
                'exist',
                'targetClass' => User::className(),
                'filter' => function ($query) {
                    $query->inactive();
                }
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'email' => Module::t('model', 'Email')
        ];
    }

    /**
     * Resend email confirmation token
     *
     * @return boolean true if message was sent successfully
     */
    public function resend()
    {
        $this->_model = User::findByEmail($this->email, 'inactive');

        if ($this->_model !== null) {
            // Module::sendSignUpEmail($this->_model)
            return true;
        }

        return false;
    }
}
