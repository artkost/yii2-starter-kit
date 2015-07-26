<?php

/**
 * Users list view.
 *
 * @var \yii\base\View $this View
 * @var \yii\rbac\Role[] $roles Roles
 */

use app\modules\rbac\Module;
use app\themes\admin\Theme;
use app\themes\admin\widgets\Box;
use yii\helpers\Json;

$this->title = Theme::t('title', 'RBAC');
$this->params['subtitle'] = Theme::t('title', 'Roles');
$this->params['breadcrumbs'] = [
    $this->title
];

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

        <table class="table table-striped">
            <tbody>
            <tr>
                <th style="width: 10px">#</th>
                <th>Name</th>
                <th>Description</th>
                <th>Data</th>
            </tr>

            <?php foreach($roles as $id => $role): ?>

            <tr>
                <td>#</td>
                <td><?= $role->name ?></td>
                <td>
                    <?= $role->description ?>
                </td>
                <td>
                    <span class="badge"><?= $role->ruleName ?></span>
                    <code><?= Json::encode($role->data) ?></code>
                </td>
            </tr>

            <?php endforeach; ?>
            </tbody>
        </table>

        <?php Box::end(); ?>
    </div>
</div>
