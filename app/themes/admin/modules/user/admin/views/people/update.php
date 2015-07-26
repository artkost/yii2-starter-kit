<?php

/**
 * User update view.
 *
 * @var \yii\web\View $this View
 * @var array $roleArray Roles array
 * @var array $statusArray Statuses array
 */

use app\themes\admin\Theme;
use app\themes\admin\widgets\Box;

$this->title = Theme::t('title', 'Users');
$this->params['subtitle'] = Theme::t('title', 'Update user');
$this->params['breadcrumbs'] = [
    [
        'label' => $this->title,
        'url' => ['index'],
    ],
    $this->params['subtitle']
];
$boxButtons = ['{cancel}'];

if (Yii::$app->user->can('userCreate')) {
    $boxButtons[] = '{create}';
}
if (Yii::$app->user->can('UserDelete')) {
    $boxButtons[] = '{delete}';
}
$boxButtons = !empty($boxButtons) ? implode(' ', $boxButtons) : null; ?>
<div class="row">
    <div class="col-sm-12">
        <?php $box = Box::begin(
            [
                'title' => $this->params['subtitle'],
                'renderBody' => false,
                'options' => [
                    'class' => 'box-success'
                ],
                'bodyOptions' => [
                    'class' => 'table-responsive'
                ],
                'buttonsTemplate' => $boxButtons
            ]
        );
        echo $this->render(
            '_form',
            [
                'user' => $user,
                'profile' => $profile,
                'roleArray' => $roleArray,
                'statusArray' => $statusArray,
                'box' => $box
            ]
        );
        Box::end(); ?>
    </div>
</div>
