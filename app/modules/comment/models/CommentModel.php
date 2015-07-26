<?php

namespace app\modules\comment\models;

use app\components\helpers\Security;
use app\modules\comment\Module;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%comment_model}}".
 *
 * @property integer $id ID
 * @property string $name Model class name
 * @property integer $status_id Status
 * @property integer $created_at Created time
 * @property integer $updated_at Updated time
 *
 * @property Comment[] $comments Comments
 */
class CommentModel extends ActiveRecord
{
    /** Status disabled */
    const STATUS_DISABLED = 0;
    /** Status enabled */
    const STATUS_ENABLED = 1;
    /** Model array cache key */
    const CACHE_KEY = 'CommentModel';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%comment_model}}';
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
     * Find model by ID.
     *
     * @param string|integer $id Model ID
     *
     * @return static|null Found model
     */
    public static function findIdentity($id)
    {
        $id = is_numeric($id) ? $id : Security::crc32($id);

        return self::findOne($id);
    }

    /**
     * @return array Status array
     */
    public static function statusLabels()
    {
        return [
            self::STATUS_DISABLED => Module::t('model', 'STATUS_DISABLED'),
            self::STATUS_ENABLED => Module::t('model', 'STATUS_ENABLED')
        ];
    }

    /**
     * @return string Model readable status
     */
    public function getStatus()
    {
        return self::statusLabels()[$this->status_id];
    }

    /**
     * @return array Model array
     */
    public static function getModelArray()
    {
        $array = Yii::$app->cache->get(self::CACHE_KEY);

        if ($array === false) {

            $array = ArrayHelper::map(self::find()->asArray()->all(), 'id', 'name');

            Yii::$app->cache->set(self::CACHE_KEY, $array);
        }

        return $array;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // Required
            ['name', 'required'],
            // String
            ['name', 'string', 'max' => 255],
            // Name
            ['name', 'unique'],
            // Status
            ['status_id', 'in', 'range' => array_keys(self::statusLabels())],
            ['status_id', 'default', 'value' => self::STATUS_ENABLED]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Module::t('model', 'ATTR_ID'),
            'name' => Module::t('model', 'ATTR_NAME'),
            'status_id' => Module::t('model', 'ATTR_STATUS'),
            'created_at' => Module::t('model', 'ATTR_CREATED'),
            'updated_at' => Module::t('model', 'ATTR_UPDATED'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->id = Security::crc32($this->name);

            return true;
        } else {
            return false;
        }
    }

    /**
     * @inheritdoc
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        Yii::$app->cache->delete(self::CACHE_KEY);
    }

    /**
     * @inheritdoc
     */
    public function beforeDelete()
    {
        if (parent::beforeDelete()) {
            Comment::deleteAll(['model_class' => $this->id]);

            return true;
        } else {
            return false;
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::className(), ['model_class' => 'id']);
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['admin-create'] = ['name'];
        $scenarios['admin-update'] = ['name'];

        return $scenarios;
    }
}
