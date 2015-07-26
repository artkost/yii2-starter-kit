<?php

namespace app\modules\user\forms;

use app\modules\user\Module;
use app\modules\user\models\User;
use yii\base\Model;
use Yii;

/**
 * Class ActivationForm
 *
 * @property string $secure_key Activation key
 */
class Activation extends Model
{
    /**
     * @var string $token Token
     */
    public $token;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // Secure key
            ['token', 'required'],
            ['token', 'trim'],
            ['token', 'string', 'max' => 53],
            [
                'token',
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
            'token' => Module::t('model', 'Token')
        ];
    }

    /**
     * Activates user account.
     *
     * @return boolean true if account was successfully activated
     */
    public function activate()
    {
        /** @var User $model */
        $model = User::findByToken($this->token, 'inactive');

        if ($model !== null) {
            return $model->activateAndSave();
        }
        return false;
    }
}
