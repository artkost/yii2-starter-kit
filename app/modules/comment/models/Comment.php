<?php

namespace app\modules\comment\models;

use app\modules\comment\Module;
use app\modules\user\models\User;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%comments}}".
 *
 * @property integer $id ID
 * @property integer $model_class Model class ID
 * @property integer $model_id Model ID
 * @property integer $author_id Author ID
 * @property string $content Content
 * @property integer $status_id Status
 * @property integer $created_at Create time
 * @property integer $updated_at Update time
 *
 * @property User $author Author
 * @property CommentModel $model Model
 */
class Comment extends ActiveRecord
{
    /** Status banned */
    const STATUS_BANNED = 0;
    /** Status active */
    const STATUS_ACTIVE = 1;
    /** Status deleted */
    const STATUS_DELETED = 2;

    /**
     * @var null|array|\yii\db\ActiveRecord[] Comment children
     */
    protected $_children;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%comment}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'timestampBehavior' => [
                'class' => TimestampBehavior::className()
            ]
        ];
    }

    /**
     * @return array Status array
     */
    public static function statusLabels()
    {
        return [
            self::STATUS_BANNED => Module::t('model', 'STATUS_BANNED'),
            self::STATUS_ACTIVE => Module::t('model', 'STATUS_ACTIVE'),
            self::STATUS_DELETED => Module::t('model', 'STATUS_DELETED')
        ];
    }

    /**
     * $_children getter.
     *
     * @return null|array|]yii\db\ActiveRecord[] Comment children
     */
    public function getChildren()
    {
        return $this->_children;
    }

    /**
     * $_children setter.
     *
     * @param array|\yii\db\ActiveRecord[] $value Comment children
     */
    public function setChildren($value)
    {
        $this->_children = $value;
    }

    /**
     * @return string Comment status
     */
    public function getStatus()
    {
        return self::statusLabels()[$this->status_id];
    }

    /**
     * @return boolean Whether comment is active or not
     */
    public function getIsActive()
    {
        return $this->status_id === self::STATUS_ACTIVE;
    }

    /**
     * @return boolean Whether comment is banned or not
     */
    public function getIsBanned()
    {
        return $this->status_id === self::STATUS_BANNED;
    }

    /**
     * @return boolean Whether comment is deleted or not
     */
    public function getIsDeleted()
    {
        return $this->status_id === self::STATUS_DELETED;
    }

    public function getAuthorAvatarUrl()
    {
        if ($this->author) {
            return $this->author->avatarUrl;
        }

        return '';
    }

    /**
     * Model ID validation.
     *
     * @param string $attribute Attribute name
     * @param array $params Attribute params
     *
     * @return mixed
     */
    public function validateModelId($attribute, $params)
    {
        /** @var CommentModel $class */
        $class = CommentModel::findIdentity($this->model_class); // find valid owner model class by crc32 summ

        if ($class === null) {
            $this->addError($attribute, Module::t('model', 'ERROR_MSG_INVALID_MODEL_ID'));
        } else {
            // class name of model comment attached to
            $model = $class->name;
            if ($model::find()->andWhere(['id' => $this->model_id])->one() === false) {
                $this->addError($attribute, Module::t('model', 'ERROR_MSG_INVALID_MODEL_ID'));
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // Require
            ['content', 'required'],
            // Parent ID
            [
                'parent_id',
                'exist',
                'targetAttribute' => 'id',
                'filter' => ['model_id' => $this->model_id, 'model_class' => $this->model_class]
            ],
            // Model class
            ['model_class', 'exist', 'targetClass' => CommentModel::className(), 'targetAttribute' => 'id'],
            // Model
            ['model_id', 'validateModelId'],
            // Content
            ['content', 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Module::t('model', 'ATTR_ID'),
            'parent_id' => Module::t('model', 'ATTR_PARENT'),
            'model_class' => Module::t('model', 'ATTR_MODEL_CLASS'),
            'model_id' => Module::t('model', 'ATTR_MODEL'),
            'author_id' => Module::t('model', 'ATTR_AUTHOR'),
            'content' => Module::t('model', 'ATTR_CONTENT'),
            'status_id' => Module::t('model', 'ATTR_STATUS'),
            'created_at' => Module::t('model', 'ATTR_CREATED'),
            'updated_at' => Module::t('model', 'ATTR_UPDATED'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(User::className(), ['id' => 'author_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClass()
    {
        return $this->hasOne(CommentModel::className(), ['id' => 'model_class']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModel()
    {
        /** @var ActiveRecord $class */
        $class = CommentModel::find()->where(['id' => $this->model_class])->asArray()->one();
        $model = $class->name;

        return $this->hasOne($model::className(), ['id' => 'model_id']);
    }

    /**
     * Get comments tree.
     *
     * @param integer $id Model ID
     * @param integer $class Model class ID
     *
     * @return array|\yii\db\ActiveRecord[] Comments tree
     */
    public static function getTree($id, $class)
    {
        $models = self::find()
            ->where([
                'model_id' => $id,
                'model_class' => $class
            ])
            ->orderBy(['parent_id' => 'ASC', 'created_at' => 'ASC'])
            ->with(['author'])
            ->all();

        if ($models !== null) {
            $models = self::buildTree($models);
        }

        return $models;
    }

    /**
     * Build comments tree.
     *
     * @param array $data Records array
     * @param int $rootID parent_id Root ID
     *
     * @return array|\yii\db\ActiveRecord[] Comments tree
     */
    protected static function buildTree(&$data, $rootID = 0)
    {
        $tree = [];

        foreach ($data as $id => $node) {
            if ($node->parent_id == $rootID) {
                unset($data[$id]);
                $node->children = self::buildTree($data, $node->id);
                $tree[] = $node;
            }
        }

        return $tree;
    }

    /**
     * Delete comment.
     *
     * @return boolean Whether comment was deleted or not
     */
    public function deleteComment()
    {
        $this->status_id = self::STATUS_DELETED;

        return $this->save(false, ['status_id', 'content']);
    }

    /**
     * @var string Created date
     */
    private $_created;

    /**
     * @var string Updated date
     */
    private $_updated;

    /**
     * @return string Created date
     */
    public function getCreated()
    {
        if ($this->_created === null) {
            $this->_created = Yii::$app->formatter->asDate($this->created_at, 'd LLL Y');
        }

        return $this->_created;
    }

    /**
     * @return string Updated date
     */
    public function getUpdated()
    {
        if ($this->_updated === null) {
            $this->_updated = Yii::$app->formatter->asDate($this->updated_at, 'd LLL Y');
        }

        return $this->_updated;
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            'create' => ['parent_id', 'model_class', 'model_id', 'content'],
            'update' => ['content'],
            'admin-update' => ['status_id', 'content']
        ];
    }


    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert) {
                if (!$this->author_id) {
                    $this->author_id = Yii::$app->user->id;
                }
                if (!$this->status_id) {
                    $this->status_id = self::STATUS_ACTIVE;
                }
            }

            return true;
        } else {
            return false;
        }
    }
}
