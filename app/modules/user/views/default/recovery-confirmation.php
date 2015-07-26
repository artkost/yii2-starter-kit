<?php

/**
 * Recovery confirmation page view.
 *
 * @var \yii\web\View $this View
 * @var \yii\widgets\ActiveForm $form Form
 */

use app\modules\user\Module;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = Module::t('user', 'Password recovery confirm');
$this->params['breadcrumbs'] = [
    $this->title
];
$this->params['contentId'] = 'error'; ?>
<?php $form = ActiveForm::begin(
    [
        'options' => [
            'class' => 'center'
        ]
    ]
); ?>
    <fieldset class="registration-form">
        <?= $form->field($model, 'password')
            ->passwordInput(['placeholder' => $model->getAttributeLabel('password')])->label(false) ?>
        <?= $form->field($model, 'repassword')
            ->passwordInput(['placeholder' => $model->getAttributeLabel('repassword')])->label(false) ?>
        <?= $form->field($model, 'token', ['template' => "{input}\n{error}"])->hiddenInput() ?>
        <?= Html::submitButton(
            Module::t('user', 'Confirm'),
            [
                'class' => 'btn btn-success pull-right'
            ]
        ) ?>
    </fieldset>
<?php ActiveForm::end(); ?>
