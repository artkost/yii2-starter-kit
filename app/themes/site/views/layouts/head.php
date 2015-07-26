<?php

/**
 * Head layout.
 */

/**
 * @var $this yii\web\View
 */
use app\themes\site\assets\ThemeAsset;
use app\web\helpers\AssetHelper;
use yii\helpers\Html;
use yii\helpers\Url;

$aM = Yii::$app->assetManager;
$params = Yii::$app->params;

echo Html::tag('title', Html::encode(Yii::$app->name . ' :: ' . $this->title));
echo Html::csrfMetaTags();

$this->head();

ThemeAsset::register($this);

$this->registerMetaTag(
    [
        'charset' => Yii::$app->charset
    ]
);
$this->registerMetaTag(
    [
        'name' => 'viewport',
        'content' => 'width=device-width, initial-scale=1.0'
    ]
);

?>
<link href="https://fonts.googleapis.com/css?family=Roboto:regular,bold,italic,thin,light,bolditalic,black,medium&amp;lang=en" rel="stylesheet">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
