<?php

/**
 * Sign In page view.
 *
 * @var \yii\web\View $this View
 * @var \yii\widgets\ActiveForm $form Form
 * @var \app\modules\user\forms\Login $model Model
 */

use app\modules\user\Module;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = Module::t('user', 'Login');
$this->params['breadcrumbs'] = [$this->title];

$form = ActiveForm::begin(
    [
        'options' => [
            'class' => 'center'
        ]
    ]
);

?>
<fieldset class="registration-form">
    <?= $form->field($model, 'username')
        ->textInput(['placeholder' => $model->getAttributeLabel('username')])->label(false) ?>
    <?= $form->field($model, 'password')
        ->passwordInput(['placeholder' => $model->getAttributeLabel('password')])->label(false) ?>
    <?= $form->field($model, 'rememberMe')->checkbox() ?>
    <?= Html::submitButton(Module::t('user', 'Login'), ['class' => 'btn btn-primary']) ?>
    &nbsp;
    <?= Module::t('user', 'or') ?>
    &nbsp;
    <?= Html::a(Module::t('user', 'Recovery password'), ['recovery']) ?>
</fieldset>
<?php ActiveForm::end(); ?>
