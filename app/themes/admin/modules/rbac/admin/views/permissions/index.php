<?php

/**
 * Users list view.
 *
 * @var \yii\base\View $this View
 * @var array $permissions Permissions
 */

use app\themes\admin\Theme;
use app\themes\admin\widgets\Box;

$this->title = Theme::t('title', 'RBAC');
$this->params['subtitle'] = Theme::t('title', 'Permissions');
$this->params['breadcrumbs'] = [$this->title];
?>

    <div class="row">
        <div class="col-xs-12">
            <?php Box::begin(
                [
                    'title' => $this->params['subtitle'],
                    'bodyOptions' => [
                        'class' => 'no-padding'
                    ]
                ]
            ); ?>

            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                <?php foreach($permissions as $module => $definition): ?>
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="heading<?= md5($module) ?>">
                            <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?= md5($module) ?>" aria-expanded="false" aria-controls="collapse<?= md5($module) ?>">
                                    <?= $module ?>
                                </a>
                            </h4>
                        </div>
                        <div id="collapse<?= md5($module) ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="<?= $module ?>">
                            <div class="panel-body no-padding">
                                <table class="table table-striped">
                                    <tbody>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Name</th>
                                        <th>Description</th>
                                    </tr>
                                    <?php foreach($definition->permissions as $name => $description): ?>
                                        <tr>
                                            <td>#</td>
                                            <td><?= $name ?></td>
                                            <td><?= $description ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php Box::end(); ?>
        </div>
    </div>
<?php
