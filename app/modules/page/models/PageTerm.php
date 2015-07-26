<?php

namespace app\modules\page\models;

use app\modules\taxonomy\models\TaxonomyTerm;
use Yii;
use app\modules\page\Module;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "page_term".
 *
 * @property integer $post_id
 * @property string $vocab_id
 * @property string $term_id
 */
class PageTerm extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%page_term}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['post_id', 'vocab_id', 'term_id'], 'required'],
            [['post_id', 'vocab_id', 'term_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'post_id' =>  Module::t('page', 'Post ID'),
            'vocab_id' =>  Module::t('page', 'Vocab ID'),
            'term_id' =>  Module::t('page', 'Term ID'),
        ];
    }

    public function getTerm()
    {
        return $this->hasOne(TaxonomyTerm::className(), ['id' => 'term_id']);
    }

    public static function saveTerm($postID, $termID, $vocabID)
    {
        return (new self([
            'term_id' => $termID,
            'post_id' => $postID,
            'vocab_id' => $vocabID
        ]))->save();
    }

    public static function removeTerm($postID, $termID = false)
    {
        $condition = ['post_id' => $postID];

        if ($termID) {
            $condition['term_id'] = $termID;
        }

        return self::deleteAll($condition);
    }

    /**
     * @param $postID
     * @param $vocabID
     * @return int
     */
    public static function removeAllByVocabulary($postID, $vocabID)
    {
        return self::deleteAll(['post_id' => $postID, 'vocab_id' => $vocabID]);
    }
}
