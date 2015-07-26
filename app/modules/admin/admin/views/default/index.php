<?php

/**
 * Backend main page view.
 *
 * @var yii\base\View $this View
 */

use app\modules\admin\Module;

$this->title = Module::t('admin', 'Admin Panel');
$this->params['subtitle'] = Module::t('admin', 'Dashboard');
?>
