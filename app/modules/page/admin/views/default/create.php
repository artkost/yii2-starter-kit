<?php

/**
 * Blog create view.
 *
 * @var \yii\base\View $this View
 * @var \app\themes\admin\widgets\Box $box Box widget instance
 * @var array $statusArray Statuses array
 */

use app\themes\admin\widgets\Box;
use app\modules\page\Module;

$this->title = Module::t('page', 'Pages');
$this->params['subtitle'] = Module::t('page', 'Create post');
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
                'buttonsTemplate' => '{cancel}'
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
