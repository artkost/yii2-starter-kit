<?php

/**
 * Blog form view.
 *
 * @var \yii\base\View $this View
 * @var \yii\widgets\ActiveForm $form Form
 * @var \app\themes\admin\widgets\Box $box Box widget instance
 * @var array $statusArray Statuses array
 */

use app\modules\page\Module;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

?>
<?php $form = ActiveForm::begin(); ?>
<?php $box->beginBody(); ?>
    <div class="row">
        <div class="col-sm-12">
            <?= $form->field($model, 'title') ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <?= $form->field($model, 'alias') ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <?= $form->field($model, 'status_id')->dropDownList($statusArray) ?>

        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">

        </div>
        <div class="col-sm-6">

        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">

        </div>
        <div class="col-sm-6">

        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <?= $form->field($model, 'snippet')->widget(
                ImperaviWidget::className(),
                [
                    'settings' => [
                        'minHeight' => 200,
                        'imageGetJson' => Url::to(['/blogs/default/imperavi-get']),
                        'imageUpload' => Url::to(['/blogs/default/imperavi-image-upload']),
                        'fileUpload' => Url::to(['/blogs/default/imperavi-file-upload'])
                    ]
                ]
            ) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <?= $form->field($model, 'content')->widget(
                ImperaviWidget::className(),
                [
                    'settings' => [
                        'minHeight' => 300,
                        'imageGetJson' => Url::to(['/blogs/default/imperavi-get']),
                        'imageUpload' => Url::to(['/blogs/default/imperavi-image-upload']),
                        'fileUpload' => Url::to(['/blogs/default/imperavi-file-upload'])
                    ]
                ]
            ) ?>
        </div>
    </div>
<?php $box->endBody(); ?>
<?php $box->beginFooter(); ?>
<?= Html::submitButton(
    $model->isNewRecord ? Module::t('page', 'BACKEND_CREATE_SUBMIT') : Module::t('page', 'BACKEND_UPDATE_SUBMIT'),
    ['class' => $model->isNewRecord ? 'btn btn-primary btn-large' : 'btn btn-success btn-large']
) ?>
<?php $box->endFooter(); ?>
<?php ActiveForm::end(); ?>
