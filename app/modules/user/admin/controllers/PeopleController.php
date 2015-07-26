<?php

namespace app\modules\user\admin\controllers;

use app\modules\admin\components\Controller;
use app\modules\user\admin\actions as Actions;
use app\modules\user\models\User;
use app\modules\user\models\UserProfile;
use app\modules\user\models\search\UserSearch;
use app\modules\user\Module;
use Yii;
use yii\filters\VerbFilter;
use yii\web\HttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * Default backend controller.
 */
class PeopleController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['access']['rules'] = [];

        $behaviors['access']['rules'][] = [
            'allow' => true,
            'actions' => ['index'],
            'roles' => ['userCreate', 'userUpdate', 'userDelete']
        ];
        $behaviors['access']['rules'][] = [
            'allow' => true,
            'actions' => ['create'],
            'roles' => ['userCreate']
        ];
        $behaviors['access']['rules'][] = [
            'allow' => true,
            'actions' => ['update'],
            'roles' => ['userUpdate']
        ];
        $behaviors['access']['rules'][] = [
            'allow' => true,
            'actions' => ['delete', 'batch-delete'],
            'roles' => ['userDelete']
        ];
        $behaviors['access']['rules'][] = [
            'allow' => true,
            'actions' => ['fileapi-upload'],
            'roles' => ['userCreate', 'userUpdate', 'userDelete']
        ];
        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'index' => ['get'],
                'create' => ['get', 'post'],
                'update' => ['get', 'put', 'post'],
                'delete' => ['post', 'delete'],
                'batch-delete' => ['post', 'delete']
            ]
        ];

        return $behaviors;
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'index' => [
                'class' => Actions\IndexAction::className(),
                'modelClass' => UserSearch::className(),
                'roleArray' => function () {
                    return User::roles();
                },
                'statusArray' => function () {
                    return User::statusLabels();
                }
            ],

            'create' => [
                'class' => Actions\CreateAction::className(),
                'modelClass' => User::className(),
                'profileClass' => UserProfile::className(),
                'scenario' => 'admin-create',
                'roleArray' => function () {
                    return User::roles();
                },
                'statusArray' => function () {
                    return User::statusLabels();
                }
            ],

            'update' => [
                'class' => Actions\UpdateAction::className(),
                'modelClass' => User::className(),
                'scenario' => 'admin-update',
                'profileRelation' => 'profile',
                'roleArray' => function () {
                    return User::roles();
                },
                'statusArray' => function () {
                    return User::statusLabels();
                }
            ],

            'delete' => [
                'class' => Actions\DeleteAction::className(),
                'modelClass' => User::className(),
                'redirectRoute' => 'index'
            ],

            'batch-delete' => [
                'class' => Actions\BatchDeleteAction::className(),
                'modelClass' => User::className(),
                'redirectRoute' => 'index'
            ]
        ];
    }

    /**
     * Update user page.
     *
     * @param integer $id User ID
     *
     * @return mixed View
     */
    public function actionUpdate($id)
    {
        $user = $this->findModel($id);
        $user->setScenario('admin-update');
        $profile = $user->profile;
        $statusArray = User::statusLabels();

        if ($user->load(Yii::$app->request->post()) && $profile->load(Yii::$app->request->post())) {
            if ($user->validate() && $profile->validate()) {
                $user->populateRelation('profile', $profile);
                if (!$user->save(false)) {
                    Yii::$app->session->setFlash('danger', Module::t('admin', 'Failed update user'));
                }
                return $this->refresh();
            } elseif (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return array_merge(ActiveForm::validate($user), ActiveForm::validate($profile));
            }
        }

        return $this->render('update', [
            'user' => $user,
            'profile' => $profile,
            'roleArray' => [],
            'statusArray' => $statusArray
        ]);
    }

    /**
     * Delete multiple users page.
     */
    public function actionBatchDelete()
    {
        if (($ids = Yii::$app->request->post('ids')) !== null) {
            $models = $this->findModel($ids);
            foreach ($models as $model) {
                $model->delete();
            }
            return $this->redirect(['index']);
        } else {
            throw new HttpException(400);
        }
    }

    /**
     * Find model by ID
     *
     * @param integer|array $id User ID
     *
     * @return User User
     * @throws HttpException 404 error if user was not found
     */
    protected function findModel($id)
    {
        if (is_array($id)) {
            /** @var User $user */
            $model = User::findIdentities($id);
        } else {
            /** @var User $user */
            $model = User::findIdentity($id);
        }
        if ($model !== null) {
            return $model;
        } else {
            throw new HttpException(404);
        }
    }
}
