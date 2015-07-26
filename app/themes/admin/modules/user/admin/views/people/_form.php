<?php

/**
 * User form view.
 *
 * @var \yii\web\View $this View
 * @var \yii\widgets\ActiveForm $form Form
 * @var User $user Model
 * @var UserProfile $profile Profile
 * @var array $roleArray Roles array
 * @var array $statusArray Statuses array
 * @var \app\themes\admin\widgets\Box $box Box widget instance
 */

use app\themes\admin\Theme;
use app\themes\admin\widgets\Box;
use yii\bootstrap\ActiveForm;
use app\modules\user\Module;
?>

<?php $form = ActiveForm::begin(); ?>
<div class="row">
    <div class="col-sm-6">
        <?php $box = Box::begin(
            [
                'title' => Theme::t('user', 'Main Information'),
                'renderBody' => false,
                'options' => [
                    'class' => 'box-success'
                ],
                'bodyOptions' => [
                    'class' => ''
                ],
                'buttonsTemplate' => $boxButtons
            ]
        );
        echo $this->render('_user_fields', [
            'box' => $box,
            'form' => $form,
            'user' => $user,
            'roleArray' => $roleArray,
            'statusArray' => $statusArray,
        ]);
        Box::end(); ?>
    </div>
    <div class="col-sm-6">
        <?php $box = Box::begin(
            [
                'title' => Module::t('admin', 'Profile'),
                'renderBody' => false,
                'options' => [
                    'class' => 'box-success'
                ],
                'bodyOptions' => [
                    'class' => ''
                ],
                'buttonsTemplate' => $boxButtons
            ]
        );
        echo $this->render('_profile_fields', [
            'box' => $box,
            'form' => $form,
            'profile' => $profile,
        ]);
        Box::end(); ?>
    </div>
</div>
<?php ActiveForm::end(); ?>
