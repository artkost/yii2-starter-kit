<?php

/**
 * Users list view.
 *
 * @var \yii\base\View $this View
 * @var \yii\data\ActiveDataProvider $dataProvider Data provider
 * @var UserSearch $searchModel Search model
 * @var array $roleArray Roles array
 * @var array $statusArray Statuses array
 */

use app\modules\user\models\search\UserSearch;
use app\themes\admin\Theme;
use app\themes\admin\widgets\Box;
use app\themes\admin\widgets\GridView;
use yii\grid\ActionColumn;
use yii\grid\CheckboxColumn;
use yii\helpers\Html;
use yii\jui\DatePicker;

$this->title = Theme::t('title', 'Users');
$this->params['subtitle'] = Theme::t('title', 'Users list');
$this->params['breadcrumbs'] = [
    $this->title
];
$gridId = 'users-grid';
$gridConfig = [
    'id' => $gridId,
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        [
            'class' => CheckboxColumn::classname()
        ],
        'id',
        [
            'attribute' => 'username',
            'format' => 'html',
            'value' => function ($model) {
                return Html::a($model['username'], ['update', 'id' => $model['id']], ['data-pjax' => 0]);
            }
        ],
        'email',
        [
            'attribute' => 'name',
            'value' => 'profile.name'
        ],
        [
            'attribute' => 'surname',
            'value' => 'profile.surname'
        ],
        [
            'attribute' => 'status_id',
            'format' => 'html',
            'value' => function ($model) {
                if ($model->status_id === $model::STATUS_ACTIVE) {
                    $class = 'label-success';
                } elseif ($model->status_id === $model::STATUS_INACTIVE) {
                    $class = 'label-warning';
                } else {
                    $class = 'label-danger';
                }

                return '<span class="label ' . $class . '">' . $model->status . '</span>';
            },
            'filter' => Html::activeDropDownList(
                $searchModel,
                'status_id',
                $statusArray,
                ['class' => 'form-control', 'prompt' => Theme::t('user', 'Select status')]
            )
        ],
        [
            'attribute' => 'assignments',
            'format' => 'html',
            'value' => function($model) {
                $assignments = [];

                foreach ($model->assignments as $assignment) {
                    $assignments[] = '<span class="label label-default">' . $assignment->item_name . '</span>';
                }

                return implode(' ', $assignments);
            }
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

if (Yii::$app->user->can('BCreateUsers')) {
    $boxButtons[] = '{create}';
}
if (Yii::$app->user->can('BUpdateUsers')) {
    $actions[] = '{update}';
    $showActions = $showActions || true;
}
if (Yii::$app->user->can('BDeleteUsers')) {
    $boxButtons[] = '{batch-delete}';
    $actions[] = '{delete}';
    $showActions = $showActions || true;
}

if ($showActions === true) {
    $gridConfig['columns'][] = [
        'class' => ActionColumn::className(),
        'template' => implode(' ', $actions)
    ];
}
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
