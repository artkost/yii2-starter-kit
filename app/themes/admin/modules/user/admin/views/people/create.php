<?php

/**
 * User create view.
 *
 * @var \yii\web\View $this View
 * @var $profile UserProfile Roles array
 * @var $user User Roles array
 * @var $roleArray string[] Roles array
 * @var $statusArray string[] Statuses array
 */

use app\modules\user\models\User;
use app\modules\user\models\UserProfile;
use app\themes\admin\Theme;

$this->title = Theme::t('title', 'Users');
$this->params['subtitle'] = Theme::t('title', 'Create user');
$this->params['breadcrumbs'] = [
    [
        'label' => $this->title,
        'url' => ['index'],
    ],
    $this->params['subtitle']
];

echo $this->render(
    '_form',
    [
        'boxButtons' => null,
        'profile' => $profile,
        'user' => $user,
        'roleArray' => $roleArray,
        'statusArray' => $statusArray,
    ]
);

?>
