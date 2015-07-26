<?php
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $generators \yii\gii\Generator[] */
/* @var $activeGenerator \yii\gii\Generator */
/* @var $content string */

$generators = Yii::$app->controller->module->generators;
$activeGenerator = Yii::$app->controller->generator;
?>
<?php $this->beginContent('@app/modules/gii/admin/views/layouts/main.php'); ?>
<div class="row">
    <div class="col-md-3">

        <div class="box box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">Generators</h3>
            </div>
            <div class="box-body no-padding">
                <ul class="nav nav-pills nav-stacked">
                    <?php
                    foreach ($generators as $id => $generator) {
                        $label = '<i class="glyphicon glyphicon-chevron-right"></i>' . Html::encode($generator->getName());
                        echo Html::tag('li', Html::a($label, ['default/view', 'id' => $id], [
                            'class' => $generator === $activeGenerator ? 'active' : '',
                        ]));
                    }
                    ?>
                </ul>
            </div><!-- /.box-body -->
        </div>
    </div>
    <div class="col-md-9">
        <?= $content ?>
    </div>
</div>
<?php $this->endContent(); ?>
