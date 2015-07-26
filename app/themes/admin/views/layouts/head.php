<?php

/**
 * Head layout.
 */

use app\themes\admin\assets\ThemeAsset;
use yii\helpers\Html;
use yii\helpers\Url;

?>
<title><?= Html::encode(Yii::$app->name . ' :: ' . $this->title); ?></title>
<?= Html::csrfMetaTags(); ?>
<?php $this->head(); ?>

<?php

ThemeAsset::register($this);

//$this->registerMetaTag(
//    [
//        'charset' => Yii::$app->charset
//    ]
//);
//$this->registerMetaTag(
//    [
//        'name' => 'viewport',
//        'content' => 'width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no'
//    ]
//);
//$this->registerLinkTag(
//    [
//        'rel' => 'canonical',
//        'href' => Url::canonical()
//    ]
//);
?>
