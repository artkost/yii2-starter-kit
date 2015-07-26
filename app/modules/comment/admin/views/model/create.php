<?php

/**
 * Comment model create view.
 *
 * @var \yii\base\View $this View
 * @var array $statusArray Statuses array
 */

use app\modules\comment\Module;
use app\themes\admin\widgets\Box;

$this->title = Module::t('admin', 'BACKEND_CREATE_TITLE');
$this->params['subtitle'] = Module::t('admin', 'BACKEND_CREATE_SUBTITLE');
$this->params['breadcrumbs'] = [
    [
        'label' => $this->title,
        'url' => ['index'],
    ],
    $this->params['subtitle']
]; ?>
<div class="row">
    <div class="col-sm-12">
        <?php $box = Box::begin(
            [
                'title' => $this->params['subtitle'],
                'renderBody' => false,
                'options' => [
                    'class' => 'box-primary'
                ],
                'bodyOptions' => [
                    'class' => 'table-responsive'
                ],
                'buttonsTemplate' => '{cancel}',
            ]
        );
        echo $this->render(
            '_form',
            [
                'model' => $model,
                'statusArray' => $statusArray,
                'box' => $box
            ]
        );
        Box::end(); ?>
    </div>
</div>
