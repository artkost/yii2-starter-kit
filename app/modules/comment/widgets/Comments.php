<?php

namespace app\modules\comment\widgets;

use app\components\helpers\Security;
use app\modules\comment\Asset;
use app\modules\comment\models\Comment;
use app\modules\comment\models\CommentModel;
use Yii;
use yii\base\InvalidConfigException;
use yii\base\Widget;
use yii\helpers\Json;

class Comments extends Widget
{
    /**
     * @var \yii\db\ActiveRecord|null Widget model
     */
    public $model;

    /**
     * @var string route to action
     */
    public $route = '/comment/default/create';

    /**
     * @var array Comments Javascript plugin options
     */
    public $jsOptions = [];

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if ($this->model === null) {
            throw new InvalidConfigException('The "model" property must be set.');
        }

        $this->registerClientScript();
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        $class = $this->model;

        /** @var CommentModel $classModel */
        $classModel = CommentModel::findIdentity($class::className());

        if ($classModel) {
            $model = new Comment(['scenario' => 'create']);
            $model->model_id = $this->model->id; // NewsPost->id, Page->id
            $model->model_class = $classModel->id; // crc32(NewsPost::class), crc32(Page::class)

            $models = Comment::getTree($model->model_id, $model->model_class);

            return $this->render('index', [
                'models' => $models,
                'model' => $model,
                'route' => $this->route
            ]);
        }

        return '';
    }

    /**
     * Register widget client scripts.
     */
    protected function registerClientScript()
    {
        $view = $this->getView();
        $options = Json::encode($this->jsOptions);
        Asset::register($view);
        $view->registerJs('jQuery.comments(' . $options . ');');
    }
}
