<?php

namespace app\modules\page\models;

use app\base\behaviors\PurifierBehavior;
use app\base\helpers\Security;
use app\modules\page\Module;
use Yii;
use yii\base\ErrorException;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

/**
 * Class Blog
 * Blog model.
 *
 * @property integer $id ID
 * @property string $parent_id Parent
 * @property string $model_class Model Class
 * @property string $user_id Model Class
 * @property string $title Title
 * @property string $alias Alias
 * @property string $snippet Intro text
 * @property string $content Content
 * @property integer $views Views
 * @property integer $status_id Status
 * @property integer $created_at Created time
 * @property integer $updated_at Updated time
 */
abstract class PostBase extends ActiveRecord
{
    /**
     * Unpublished status
     */
    const STATUS_UNPUBLISHED = 0;
    /**
     * Published status
     */
    const STATUS_PUBLISHED = 1;
    /**
     * Sticky status
     */
    const STATUS_STICKY = 2;

    protected $_children;

    /**
     * @var string Created date
     */
    private $_created;

    /**
     * @var string Updated date
     */
    private $_updated;

    /**
     * @var array
     */
    private $_fields;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%page_post}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'timestampBehavior' => [
                'class' => TimestampBehavior::className(),
            ],
            'sluggableBehavior' => [
                'class' => SluggableBehavior::className(),
                'attribute' => 'title',
                'slugAttribute' => 'alias'
            ],
            'purifierBehavior' => [
                'class' => PurifierBehavior::className(),
                'attributes' => [
                    self::EVENT_BEFORE_VALIDATE => [
                        'snippet',
                        'content' => [
                            'HTML.AllowedElements' => '',
                            'AutoFormat.RemoveEmpty' => true
                        ]
                    ]
                ],
                'textAttributes' => [
                    self::EVENT_BEFORE_VALIDATE => ['title', 'alias']
                ]
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // Required
            [['title', 'content'], 'required'],
            // Trim
            [['title', 'snippet', 'content'], 'trim'],
            // Parent ID
            [
                'parent_id',
                'exist',
                'targetAttribute' => 'id',
                'filter' => [
                    'model_class' => $this->model_class
                ]
            ],
            // Status
            [
                'status_id',
                'default',
                'value' => Yii::$app->getModule('page')->moderation ? self::STATUS_PUBLISHED : self::STATUS_UNPUBLISHED
            ],
            ['status_id', 'in', 'range' => array_keys(self::statusLabels())],
            // Model class
            ['model_class', 'exist', 'targetClass' => PageModel::className(), 'targetAttribute' => 'id'],
            // Model
            [['content', 'data'], 'string'],
            [['created', 'updated'], 'date']
        ];
    }

    /**
     * @return array Status array.
     */
    public static function statusLabels()
    {
        return [
            self::STATUS_UNPUBLISHED => Module::t('page', 'Unpublished'),
            self::STATUS_PUBLISHED => Module::t('page', 'Published'),
            self::STATUS_STICKY => Module::t('page', 'Sticky')
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Module::t('page', 'Id'),
            'title' => Module::t('page', 'Title'),
            'alias' => Module::t('page', 'Alias'),
            'teaser' => Module::t('page', 'Teaser'),
            'content' => Module::t('page', 'Content'),
            'views' => Module::t('page', 'Views'),
            'status_id' => Module::t('page', 'Status Id'),
            'data' => Module::t('page', 'Data'),
            'created_at' => Module::t('page', 'Created at'),
            'updated_at' => Module::t('page', 'Updated at'),
        ];
    }

    /**
     * @return string Created date
     */
    public function getCreated()
    {
        if ($this->_created === null) {
            $this->_created = Yii::$app->formatter->asDate($this->created_at);
        }
        return $this->_created;
    }

    /**
     * @param $date
     */
    public function setCreated($date)
    {
        $this->_created = $date;
    }

    /**
     * @return string Updated date
     */
    public function getUpdated()
    {
        if ($this->_updated === null) {
            $this->_updated = Yii::$app->formatter->asDate($this->updated_at);
        }
        return $this->_updated;
    }

    /**
     * @param $date
     */
    public function setUpdated($date)
    {
        $this->_updated = $date;
    }

    /**
     * Custom fields
     * @return array|mixed
     */
    public function getFields()
    {
        if ($this->_fields === null) {
            $this->_fields = Json::decode($this->data);
        }

        return $this->_fields;
    }

    /**
     * @param array $fields
     */
    public function setFields(array $fields)
    {
        $this->_fields = ArrayHelper::merge($this->_fields, $fields);
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['create'] = ['title', 'snippet', 'content', 'status_id'];
        $scenarios['update'] = ['title', 'snippet', 'content', 'status_id'];

        return $scenarios;
    }

    /**
     * Update views counter.
     *
     * @return boolean Whether views counter was updated or not
     */
    public function updateViews()
    {
        return $this->updateCounters(['views' => 1]);
    }

    /**
     * @param $attachment_id
     * @param $post_id
     * @return boolean
     */
    public function saveAttachment($post_id, $attachment_id)
    {
        $model = new PageAttachment([
            'attachment_id' => $attachment_id,
            'post_id' => $post_id
        ]);

        return $model->save();
    }

    /**
     * @param $post_id
     * @param bool $attachment_id
     */
    public function removeAttachment($post_id, $attachment_id = false)
    {
        $condition = ['post_id' => $post_id];

        if ($attachment_id) {
            $condition['attachment_id'] = $attachment_id;
        }

        $models = PageAttachment::findAll($condition);

        foreach ($models as $model) {
            $model->delete();
        }
    }

    /**
     * @param $postID
     * @param $termID
     * @param $vocabID
     * @return bool
     * @throws ErrorException
     */
    public function saveTerm($termID, $postID, $vocabID)
    {
        return PageTerm::saveTerm($postID, $termID, $vocabID);
    }

    /**
     * @param $postID
     * @param $termID
     * @return bool
     */
    public function removeTerm($postID, $termID)
    {
        return PageTerm::removeTerm($postID, $termID);
    }

    public function removeTermsByVocabulary($postID, $vocabID)
    {
        return PageTerm::removeAllByVocabulary($postID, $vocabID);
    }

    /**
     * @return string Readable blog status
     */
    public function getStatus()
    {
        return self::statusLabels()[$this->status_id];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        $identityClass = Yii::$app->user->identityClass;
        return $this->hasOne($identityClass::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPageAttachments()
    {
        return $this->hasMany(PageAttachment::className(), ['post_id' => 'id']);
    }

    /**
     * @return static
     */
    public function getPageTerms()
    {
        return $this->hasMany(PageTerm::className(), ['post_id' => 'id'])->with('term');
    }

    public function getPageTermsByVocabulary($vid)
    {
        return $this->hasMany(PageTerm::className(), ['post_id' => 'id'])
            ->andWhere(['vocab_id' => $vid])
            ->with('term');
    }

    public function getPageTermByVocabulary($vid)
    {
        return $this->hasOne(PageTerm::className(), ['post_id' => 'id'])
            ->andWhere(['vocab_id' => $vid])
            ->with('term');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClass()
    {
        return $this->hasOne(PageModel::className(), ['id' => 'model_class']);
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
     * @inheritdoc
     */
    public function beforeValidate()
    {
        if (parent::beforeValidate()) {
            $this->model_class = Security::crc32(static::className());

            return true;
        }

        return false;
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->_created) {
                $this->created_at = Yii::$app->formatter->asTimestamp($this->_created);
            }
            if ($this->_updated) {
                $this->updated_at = Yii::$app->formatter->asTimestamp($this->_updated);
            }
            if (!$this->user_id) {
                $this->user_id = Yii::$app->user->id;
            }
            if ($this->_fields && !empty($this->_fields)) {
                $this->data = Json::encode($this->_fields);
            }
            return true;
        } else {
            return false;
        }
    }
}
