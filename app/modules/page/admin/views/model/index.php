<?php

/**
 * @var \yii\base\View $this View
 * @var \yii\data\ActiveDataProvider $dataProvider Data provider
 * @var \app\modules\page\models\PageSearch $searchModel Search model
 * @var array $statusArray Statuses array
 */

use app\modules\page\Module;
use app\themes\admin\widgets\Box;
use app\themes\admin\widgets\GridView;
use yii\grid\ActionColumn;
use yii\grid\CheckboxColumn;
use yii\helpers\Html;
use yii\jui\DatePicker;

$this->title = Module::t('comments-models', 'BACKEND_INDEX_TITLE');
$this->params['subtitle'] = Module::t('comments-models', 'BACKEND_INDEX_SUBTITLE');
$this->params['breadcrumbs'] = [
    $this->title
];
$gridId = 'comments-models-grid';
$gridConfig = [
    'id' => $gridId,
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        [
            'class' => CheckboxColumn::classname()
        ],
        'id',
        'name',
        [
            'attribute' => 'status_id',
            'format' => 'html',
            'value' => function ($model) {
                    $class = ($model->status_id === $model::STATUS_ENABLED) ? 'label-success' : 'label-danger';

                    return '<span class="label ' . $class . '">' . $model->status . '</span>';
                },
            'filter' => Html::activeDropDownList(
                    $searchModel,
                    'status_id',
                    $statusArray,
                    [
                        'class' => 'form-control',
                        'prompt' => Module::t('comments', 'BACKEND_PROMPT_STATUS')
                    ]
                )
        ],
        [
            'attribute' => 'created_at',
            'format' => 'date',
            'filter' => DatePicker::widget(
                    [
                        'model' => $searchModel,
                        'attribute' => 'created_at',
                        'options' => [
                            'class' => 'form-control'
                        ],
                        'clientOptions' => [
                            'dateFormat' => 'dd.mm.yy',
                        ]
                    ]
                )
        ],
        [
            'attribute' => 'updated_at',
            'format' => 'date',
            'filter' => DatePicker::widget(
                    [
                        'model' => $searchModel,
                        'attribute' => 'updated_at',
                        'options' => [
                            'class' => 'form-control'
                        ],
                        'clientOptions' => [
                            'dateFormat' => 'dd.mm.yy',
                        ]
                    ]
                )
        ]
    ]
];

$boxButtons = $actions = [];
$showActions = false;

//if (Yii::$app->user->can('BCreateCommentsModels')) {
    $boxButtons[] = '{create}';
//}
//if (Yii::$app->user->can('BUpdateCommentsModels')) {
    $actions[] = '{update}';
    $showActions = $showActions || true;
//}
//if (Yii::$app->user->can('BDeleteCommentsModels')) {
    $boxButtons[] = '{batch-delete}';
    $actions[] = '{delete}';
    $showActions = $showActions || true;
//}

//if ($showActions === true) {
    $gridConfig['columns'][] = [
        'class' => ActionColumn::className(),
        'template' => implode(' ', $actions)
    ];
//}
$boxButtons = !empty($boxButtons) ? implode(' ', $boxButtons) : null; ?>

<div class="row">
    <div class="col-xs-12">
        <?php Box::begin(
            [
                'title' => $this->params['subtitle'],
                'bodyOptions' => [
                    'class' => 'table-responsive'
                ],
                'buttonsTemplate' => $boxButtons,
                'grid' => $gridId
            ]
        ); ?>
        <?= GridView::widget($gridConfig); ?>
        <?php Box::end(); ?>
    </div>
</div>