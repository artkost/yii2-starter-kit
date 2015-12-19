<?php
use app\themes\admin\Theme;
use app\themes\admin\widgets\Box;
use yii\bootstrap\ActiveForm;

/**
 * @var $modules array
 */

$this->title = Theme::t('title', 'Admin');
$this->params['subtitle'] = Theme::t('title', 'Modules');
$this->params['breadcrumbs'] = [
    $this->title
];

$form = ActiveForm::begin();
?>
<div class="row">
    <div class="col-xs-12">
        <?php Box::begin(
            [
                'title' => $this->params['subtitle'],
                'bodyOptions' => [
                    'class' => 'table-responsive no-padding'
                ],
                'buttonsTemplate' => '{refresh}',
                'buttons' => [
                    'refresh' => [
                        'label' => Theme::t('admin', 'Refresh Modules'),
                        'url' => ['modules', 'refresh' => true],
                        'icon' => 'refresh'
                    ]
                ]
            ]
        ); ?>
        <table class="table table-hover">
            <tbody>
            <tr>
                <th>Name</th>
                <th>Package</th>
                <th>Required</th>
            </tr>
            <?php foreach($modules as $category => $definitions):?>
                <tr>
                    <td colspan="3"><h3><?= $category ?></h3></td>
                </tr>
                <?php foreach($definitions as $definition): ?>
                    <tr>
                        <td><?= $definition['name'] ?></td>
                        <td></td>
                        <td>
                            <?php if ($definition['required']): ?>
                                <span class="label label-warning">Required</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endforeach; ?>
            </tbody></table>
        <?php Box::end(); ?>
    </div>
</div>
