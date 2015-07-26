<?php

namespace app\modules\page\models;

use app\modules\attachment\models\AttachmentFile;
use app\modules\page\models\PostBase as PagePost;
use Yii;

/**
 * This is the model class for table "page_attachment".
 *
 * @property integer $id
 * @property integer $post_id
 * @property integer $attachment_id
 * @property integer $status_id
 *
 * @property AttachmentFile $attachment
 * @property PagePost $post
 */
class PageAttachment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'page_attachment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['post_id', 'attachment_id'], 'required'],
            [['post_id', 'attachment_id', 'status_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'post_id' => 'Post ID',
            'attachment_id' => 'Attachment ID',
            'status_id' => 'Status ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAttachment()
    {
        return $this->hasOne(AttachmentFile::className(), ['id' => 'attachment_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPost()
    {
        return $this->hasOne(PagePost::className(), ['id' => 'post_id']);
    }

    public function afterSave($insert, $changedAttributes)
    {
        if ($insert) {
            AttachmentFile::updateAll(['status_id' => AttachmentFile::STATUS_PERMANENT], ['id' => $this->attachment_id]);
        }

        parent::afterSave($insert, $changedAttributes);
    }

    public function afterDelete()
    {
        AttachmentFile::updateAll(['status_id' => AttachmentFile::STATUS_TEMPORARY], ['id' => $this->attachment_id]);

        parent::afterDelete();
    }
}
