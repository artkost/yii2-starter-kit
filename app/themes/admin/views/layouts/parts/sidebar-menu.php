<?php

use app\modules\admin\Module;
use app\themes\admin\widgets\Menu;

/** @var Module $admin */
$admin = Yii::$app->getModule('admin');
?>

<?= Menu::widget([
    'items' => $admin->getMenu()->getItems(),
    'options' => ['class' => 'sidebar-menu']
]) ?>
