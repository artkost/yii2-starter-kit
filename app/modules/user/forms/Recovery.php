<?php

namespace app\modules\user\forms;

use app\modules\user\Module;
use app\modules\user\models\User;
use yii\base\Model;
use Yii;

/**
 * Class RecoveryForm
 * RecoveryForm is the model behind the recovery form.
 *
 * @property string $email E-mail
 */
class Recovery extends Model
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
            ['email', 'string', 'max' => 100],
            [
                'email',
                'exist',
                'targetClass' => User::className(),
                'filter' => function ($query) {
                        $query->active();
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
     * Send a recovery password token.
     *
     * @return boolean true if recovery token was successfully sent
     */
    public function recovery()
    {
        $this->_model = User::findByEmail($this->email, 'active');

        if ($this->_model !== null) {
            return Module::sendRecoveryEmail($this->_model);
        }

        return false;
    }
}
