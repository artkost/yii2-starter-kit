<?php

namespace app\modules\user\actions;

use app\modules\user\Module;
use Yii;
use yii\base\Event;
use yii\helpers\Url;
use yii\web\Response;
use yii\widgets\ActiveForm;

class SignupAction extends Action
{
    public $resendRoute = ['resend'];

    public $viewFile = 'signup';

    public $modelClass = 'app\modules\user\models\User';
    public $profileClass = 'app\modules\user\models\UserProfile';

    /**
     * Sign Up page.
     * If record will be successful created, user will be redirected to home page.
     */
    public function run()
    {
        /** @var \app\modules\user\models\User $user */
        $user = Yii::createObject($this->modelClass, ['scenario' => 'signup']);
        /** @var \app\modules\user\models\UserProfile $profile */
        $profile = Yii::createObject($this->profileClass);

        $post = Yii::$app->request->post();

        if ($user->load($post) && $profile->load($post)) {
            if ($user->validate() && $profile->validate()) {
                $user->populateRelation('profile', $profile);
                if ($user->save(false)) {
                    if (Module::param('requireEmailConfirmation', false)) {
                        $this->trigger('success', new Event([
                            'data' => Module::t(
                                'model',
                                'Your account has been created successfully. An email has been sent to you with detailed instructions.',
                                ['url' => Url::to($this->resendRoute)]
                            )
                        ]));
                    } else {
                        Yii::$app->user->login($user);

                        $this->trigger('success', new Event([
                            'data' => Module::t('model', 'Your account has been created successfully.')
                        ]));
                    }
                    return $this->controller->goHome();
                } else {
                    $this->trigger('danger', new Event([
                        'data' => Module::t('model', 'Create account failed. Please try again later.')
                    ]));
                    return $this->controller->refresh();
                }
            } elseif (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return array_merge(ActiveForm::validate($user), ActiveForm::validate($profile));
            }
        }

        return $this->render(compact('user', 'profile'));
    }
}
