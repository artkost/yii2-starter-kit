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

            <table class="table">
                <tbody>
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                    </tr>
                    <?php foreach($permissions as $module => $definition): ?>
                        <tr>
                            <td colspan="2"><?= $module ?></td>
                        </tr>
                        <?php foreach($definition->permissions as $name => $description): ?>
                            <tr>
                                <td><?= $description ?></td>
                                <td>Role1 Role2</td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php Box::end(); ?>
        </div>
    </div>
<?php
