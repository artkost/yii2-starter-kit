<?php

/**
 * Recovery confirmation page view.
 *
 * @var \yii\web\View $this View
 * @var \yii\widgets\ActiveForm $form Form
 * @var \app\modules\user\forms\RecoveryConfirmation $model Model
 */

use app\modules\user\Module;
use app\themes\admin\Theme;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = Theme::t('title', 'Confirm Recovery');
$this->params['breadcrumbs'] = [
    $this->title
];
$this->params['contentId'] = 'error'; ?>

<div class="form-box">
    <div class="header"><?= Html::encode($this->title); ?></div>
    <?php $form = ActiveForm::begin(); ?>
    <div class="body bg-gray">
        <?= $form->field($model, 'password')
            ->passwordInput(['placeholder' => $model->getAttributeLabel('password')])->label(false) ?>
        <?= $form->field($model, 'repassword')
            ->passwordInput(['placeholder' => $model->getAttributeLabel('repassword')])->label(false) ?>
        <?= $form->field($model, 'token', ['template' => "{input}\n{error}"])
            ->hiddenInput() ?>
    </div>
    <div class="footer">
        <?= Html::submitButton(Theme::t('user', 'Confirm'), ['class' => 'btn bg-olive btn-block']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
